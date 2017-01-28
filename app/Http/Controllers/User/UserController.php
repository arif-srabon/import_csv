<?php namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Setup\CommonConfigModel;
use App\Model\User\RoleModel;
use App\Model\Setup\DistrictModel;
use App\Model\Setup\ThanaUnionWardModel;
use App\Model\Setup\ThanaUpazillaModel;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use DB;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use narutimateum\Toastr\Facades\Toastr;
use App\Fileentry;
use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;

use App\Model\User\UserModel as User;
use App\Http\Requests\UserRequest;
use Session;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;


class UserController extends Controller
{
    public $kds;
    public $lang;

    public function __construct()
    {
        $this->middleware('auth');
        $this->lang = Session::get("locale");
        if (!isset($this->lang)) {
            $this->lang = config('app.locale');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        \Assets::add(['kendoui/kendo.common.min.css',
            'kendoui/kendo.default.min.css',
            'kendoui/kendo.all.min.js'
        ]);
        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb1'), '/user');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb2'), '#');

        $transport_read_data = Kendo::createRead()
            ->setUrl('/user/read')
            ->setContentType('application/json')
            ->setType('POST');

        $transport_data = Kendo::createTransport()
            ->setRead($transport_read_data)
            ->setParameterMap(Kendo::js('function(data) { return kendo.stringify(data); }'));

        $model_data = Kendo::createModel()
            ->setId('id');

        $schema_data = Kendo::createSchema()
            ->setData('data')
            ->setModel($model_data)
            ->setTotal('total');

        $dataSource_data = Kendo::createDataSource()
            ->setTransport($transport_data)
            ->setSchema($schema_data)
            ->setPageSize(config('app_config.num_paging_row'))
            ->setServerSorting(true)
            ->setServerPaging(true)
            ->setServerFiltering(true);

        // grid filter
//        if ($this->_defaultFilter() !== false) {
//            $filter = $this->_defaultFilter();
//            $dataSource_data->setFilter($filter);
//        }
        ///////////////////


        $pageable = Kendo::createPageable();
        $pageable->setRefresh(true)
            ->setPageSizes(config('app_config.grid_page_sizes'))
            ->setButtonCount(config('app_config.grid_button_count'));

        if ($this->lang == 'bn') {
            $status = '# if (status == 1) { #সক্রিয়# } else { #নিষ্ক্রিয়# } #';
        } else {
            $status = '# if (status == 1) { #Active# } else { #Inactive# } #';
        }

        $grid_data = Kendo::createGrid('#grid_center')
            ->setDataSource($dataSource_data)
            ->setHeight(500)
            ->setScrollable(true)
            ->setSelectable('row')
            ->setSortable(true)
            ->setResizable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'full_name', 'title' => trans('users/user.col_user_full_name'), 'width' => "130px"],
                ['field' => 'department', 'title' => trans('users/user.col_user_department'), 'width' => "115px"],
                ['field' => 'designation', 'title' => trans('users/user.lbl_desg'),'width' => "100px"],
                ['field' => 'email', 'title' => trans('users/user.col_username'), 'width' => "100px"],
                ['field' => 'official_email', 'title' => trans('users/user.lbl_email'),'width' => "100px"],
                ['field' => 'mobile', 'title' => trans('users/user.lbl_mobile'),'width' => "90px"],
                ['field' => 'status', 'title' => trans('users/user.lbl_status'),'width' => "80px", 'filterable' => false, 'template' => $status],
            ]);


        $command = [];
        if (SentinelAuth::check('dss.security.users.permission')) {
            $command_permission = ["click" => Kendo::js('commandPermission'), "text" => trans('users/user.btn_permission')];
            $command[] = $command_permission;
        }

        if (SentinelAuth::check('dss.security.users.edit')) {
            $command_edit = ["click" => Kendo::js('commandEdit'), "text" => trans('users/user.btn_edit')];
            $command[] = $command_edit;
        }

        if (SentinelAuth::check('dss.security.users.del')) {
            $command_del = ["click" => Kendo::js('commandDelete'), "text" => trans('users/user.btn_delete')];
            $command[] = $command_del;
        }

        $grid_data->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "24%"]);

        $data = ['grid_data' => $grid_data];
        return view('user.list', $data);
    }

    public function read()
    {
        $request = json_decode(file_get_contents('php://input'));
        if($this->lang == 'bn'){
            $full_name = 'full_name_bn';
            $name = 'name_bn';
        }else{
            $full_name='full_name';
            $name='name';
        }
        $table = "users
                    LEFT JOIN cc_department ON cc_department.id = users.department_id
                    LEFT JOIN cc_designation ON cc_designation.id = users.designation_id";
        $properties = array('users.id AS id',
                    'users.email AS email',
                    "users.$full_name AS full_name",
                    'users.official_email AS official_email',
                    'users.status AS status',
                    'users.mobile AS mobile',
                    "cc_department.$name AS department",
                    "cc_designation.$name AS designation",
                );

        $this->kds = new kds;
        $data = $this->kds->read($table, $properties, $request);
        return response(json_encode($data))
            ->header('Content-Type', 'application/json');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        \Assets::add(['plugins/forms/validation/validate.min.js',
            'plugins/forms/styling/uniform.min.js',
            'plugins/forms/selects/select2.min.js',
            'app/user_form_validation.js',
            'plugins/ui/moment/moment.min.js',
            'plugins/jquery.relatedselects.js',
            'plugins/bootstrap-datetimepicker.min.js',
            'bootstrap-datetimepicker-standalone.css',
            'core/libraries/jquery.form.js',
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb1'), '/user');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb2'), '/user');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb3'), '#');

        $data = [];
        $data = array_merge($data, $this->_getBasicData());
        $data['assignedRole'] = [];
        $roles = new RoleModel;
        $data['allRoles'] = $roles->getAllList();
        $savedData = $this->_getSavedUserBasicData();
        $data = array_merge($data, $savedData);
        return view('user.create')->with($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    private function _registerUser($request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        // check user activation status
        if ($request->input('status') == 1) {
            $activation = true;
        } else {
            $activation = false;
        }

        if ($user = Sentinel::register($credentials, $activation)) {
            return $user;
        }
        return false;
    }


    public function store(UserRequest $request)
    {
        try {
//            dd($request);
            $user = $this->_registerUser($request);
            $userInfo = User::findOrFail($user->id);
            $userInfo->created_by = Session::get('sess_user_id');
            $userInfo->update($request->all());

            $this->uploadPhoto($request, $user->id);
            $this->uploadSign($request, $user->id);
            // save user roles
            $userRoleIds = $request->input('assigned_roles_list');
//            dd($userRoleIds);
            if (is_array($userRoleIds) && count($userRoleIds)) {
                $user->roles()->sync($userRoleIds);
            }

            Toastr::success(config('app_config.msg_save'), "Save", $options = []);
            return redirect('user/create');

        } catch (\Exception $e) {
            Toastr::error(config('app_config.msg_failed_save'), "Save Failed", $options = []);

            return redirect('user/create')
                ->with('dangerMsg', $e->getMessage());
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        \Assets::add(['plugins/forms/validation/validate.min.js',
            'plugins/forms/styling/uniform.min.js',
            'plugins/forms/selects/select2.min.js',
            'app/user_form_validation.js',
            'plugins/ui/moment/moment.min.js',
            'plugins/jquery.relatedselects.js',
            'plugins/bootstrap-datetimepicker.min.js',
            'bootstrap-datetimepicker-standalone.css',
            'core/libraries/jquery.form.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb1'), '/user');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb2'), '/user');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb4'), '#');

        // get basic data
        $data = [];
        $data = array_merge($data, $this->_getBasicData());

        $roles = new RoleModel;
        $data['allRoles'] = $roles->getAllList();

        $user = User::findOrFail($id);
        $data['assignedRole'] = $user->assigned_roles_list->toArray();
        $savedData = $this->_getSavedUserBasicData($user);
        $data = array_merge($data, $savedData);
        return view('user.edit', compact('user'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->updated_by = Session::get('sess_user_id');
            $user->update($request->all());

            $this->_updateUserCredentials($request, $id);
            $this->_userActivation($request, $id);

            // upload
            $this->uploadPhoto($request, $id);
            $this->uploadSign($request, $id);
            // save user roles
            $userRoleIds = $request->input('assigned_roles_list');
            if (is_array($userRoleIds) && count($userRoleIds)) {
                $user->roles()->sync($userRoleIds);
            }

            Toastr::success(config('app_config.msg_update'), "Update", $options = []);
            return redirect("user/$id/edit");

        } catch (\Exception $e) {

            Toastr::error(config('app_config.msg_failed_update'), "Update Failed", $options = []);

            return redirect("user/$id/edit")
                ->with('dangerMsg', $e->getMessage());
        }
    }

    private function _updateUserCredentials($request, $user_id)
    {
        $user = Sentinel::findById($user_id);
        $credentials = [
            'email' => $request->input('email')
        ];

        if (!empty($request->input('password') && ($request->input('password') === $request->input('password_confirmation')))) {
            $credentials = array_add($credentials, 'password', $request->input('password'));
        }

        $user = Sentinel::update($user, $credentials);
        return $user;
    }

    private function _userActivation($request, $user_id)
    {
        $user = Sentinel::findById($user_id);
        if ($request->input('status') == 1) {
            $activation = Activation::exists($user);
            if (!$activation) {
                $activation = Activation::create($user);
                Activation::complete($user, $activation->code);
            } else {
                Activation::complete($user, $activation->code);
            }
        } else { // when inactive
            Activation::remove($user);
            DB::table('activations')->where('user_id', '=', $user_id)->delete();
        }
    }


    public function uploadPhoto($request, $id)
    {
        $file = $request->file('user_photo');
        if (!empty($file)) {
            $uploadPath = config('app_config.user_upload_photo_path') . "$id/";
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($uploadPath), $fileName);
            $uploadFile = $uploadPath . $fileName;
            // update path
            $entry = User::find($id);
            $entry->user_photo = $uploadFile;
            $entry->save();
        }
    }

    public function uploadSign($request, $id){
        $file = $request->file('user_sign');
        if (!empty($file)) {
            $uploadPath = config('app_config.user_upload_sign_path') . "$id/";
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($uploadPath), $fileName);
            $uploadFile = $uploadPath . $fileName;
            // update path
            $entry = User::find($id);
            $entry->user_sign = $uploadFile;
            $entry->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $request = json_decode(file_get_contents('php://input'));

        $stat = DB::transaction(function () use ($request) {
            DB::table('activations')->where('user_id', $request->id)->delete();
            DB::table('role_users')->where('user_id', $request->id)->delete();
            return User::destroy($request->id);
        });

        return response(json_encode($stat))
            ->header('Content-Type', 'application/json');
    }

    /**
     * generate user basic configuration data
     *
     * @return array
     */
    private function _getBasicData()
    {
        $cConfig = new CommonConfigModel;
        $data['designation'] = $cConfig->getAllCommonConfigList('cc_designation', $this->lang);
        $data['department'] = $cConfig->getAllCommonConfigList('cc_department', $this->lang);
        $data['gender'] = $cConfig->getAllCommonConfigList('cc_genders', $this->lang);
        $data['maritalstatus'] = $cConfig->getAllCommonConfigList('cc_marital_status', $this->lang);
        $data['divisionList'] = $cConfig->getAllDivisionList('divisions', $this->lang);
        return $data;
    }

    private function _getSavedUserBasicData($user = null)
    {
        if (empty($user)) {
            $data['districtList'] = [];
            $data['upazillaList'] = [];
            $data['wardList'] = [];
            $data['present_districtList'] = [];
            $data['present_upazillaList'] = [];
            $data['present_wardList'] = [];

            return $data;
        }

        $district = new DistrictModel;
        $data['districtList'] = $district->getAllDistrictByDivisionList($user->permanent_division);
        $upazilla = new ThanaUpazillaModel;
        $data['upazillaList'] = $upazilla->getAllUpazillaByDistrictList($user->permanent_district);
        $ward = new ThanaUnionWardModel;
        $data['wardList'] = $ward->getAllWardByUpazillaList($user->permanent_upzilla);
        $district = new DistrictModel;
        $data['present_districtList'] = $district->getAllDistrictByDivisionList($user->present_division);
        $upazilla = new ThanaUpazillaModel;
        $data['present_upazillaList'] = $upazilla->getAllUpazillaByDistrictList($user->present_district);
        $ward = new ThanaUnionWardModel;
        $data['present_wardList'] = $ward->getAllWardByUpazillaList($user->present_upzilla);

        return $data;
    }

}
