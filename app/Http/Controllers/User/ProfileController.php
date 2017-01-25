<?php namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;

use App\Model\Setup\CommonConfigModel;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use narutimateum\Toastr\Facades\Toastr;
use App\Fileentry;

use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use App\Model\User\UserModel as User;
use Session;
use Validator;


class ProfileController extends Controller
{
    public $kds;
    public $lang;

    public function __construct()
    {
        $this->middleware('auth');
        $this->kds = new kds;
        $this->lang = Session::get("locale");
        if(!isset($this->lang)){
            $this->lang =config('app.locale');
        }
    }

    public function index()
    {
        \Assets::add(['kendoui/kendo.common.min.css',
            'kendoui/kendo.default.min.css',
            'kendoui/kendo.all.min.js'
        ]);
        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb6'), '/profile');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb7'), '#');

        $uid = Session::get("sess_user_id");
        $transport_read_data = Kendo::createRead()
            ->setUrl("/myaccesslog/read/$uid")
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

        $pageable = Kendo::createPageable();
        $pageable->setRefresh(true)
            ->setPageSizes(config('app_config.grid_page_size'))
            ->setButtonCount(5);

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
                ['field' => 'login_ip', 'title' => trans('users/user.col_login_ip'), 'width' => "200px"],
                ['field' => 'login_datetime', 'title' => trans('users/user.col_login_time'), 'filterable' => false],
                ['field' => 'logout_datetime', 'title' => trans('users/user.col_logout_time'), 'filterable' => false],
            ]);

        $data = ['grid_data' => $grid_data];
        return view('user.profile.accesslog', $data);
    }

    public function read($uid)
    {
        $request = json_decode(file_get_contents('php://input'));

        // default sorting
        if (!isset($request->sort)) {
            $request->sort = array(
                (object)array('field' => 'login_datetime', 'dir' => 'DESC'));
        }

        //  $uid = Session::get("sess_user_id");
        $table = "access_log where user_id = $uid";
        $properties = array('id', 'user_id', 'login_ip',
            'DATE_FORMAT(login_datetime, "%d-%m-%Y %r") AS login_datetime',
            'IFNULL(DATE_FORMAT(logout_datetime, "%d-%m-%Y %r"), "") AS logout_datetime');

        $data = $this->kds->read($table, $properties, $request);
        return response(json_encode($data))
            ->header('Content-Type', 'application/json');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        \Assets::add(['plugins/forms/validation/validate.min.js',
            'plugins/forms/styling/uniform.min.js',
            'plugins/ui/moment/moment.min.js',
            'plugins/pickers/daterangepicker.js',
            'plugins/jquery.relatedselects.js',
            'plugins/forms/selects/select2.min.js',
            'app/user_form_validation.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb5'), '/profile');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb4'), '#');

        $id = Session::get("sess_user_id");
        // get basic data
        $data = [];
        $data = array_merge($data, $this->_getBasicData());

        $user = User::findOrFail($id);

        return view('user.profile.edit', compact('user'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, $id)
    {
        $id = Session::get("sess_user_id");

        try {
            $user = User::findOrFail($id);
            $user->updated_by = Session::get('sess_user_id');

            //$request['designation_id'] = $user->designation_id;

            $user->update($request->all());
            // upload
            $this->uploadPhoto($request, $id);


            Toastr::success(config('app_config.msg_update'), "Update", $options = []);

            return redirect("profile");

        } catch (\Exception $e) {

            Toastr::error(config('app_config.msg_failed_update'), "Update Failed", $options = []);

            return redirect("profile")
                ->with('dangerMsg', $e->getMessage());
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
        $data['manufacturer'] = DB::table('manufacturer')->where('status', '=', 1)->lists('name', 'id');

        return $data;
    }




    /**
     * change password form
     */

    public function changepassword()
    {
        \Assets::add(['plugins/forms/validation/validate.min.js',
            'app/changepassword_form_validation.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb6'), '/profile');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb8'), '#');

        //$id =  Session::get("sess_user_id");
        return view('user.profile.changepassword');
    }

    public function updatePasswd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:5',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        // change password
        try {
            $hasher = Sentinel::getHasher();

            $oldPassword = $request->input('old_password');
            $password = $request->input('password');
            $passwordConf = $request->input('password_confirmation');

            $user = Sentinel::getUser();

            if (!$hasher->check($oldPassword, $user->password) || $password != $passwordConf) {
                throw new \Exception('Old Password does not match. Try again !!!');
            }

            Sentinel::update($user, array('password' => $password));
            Toastr::success(config('app_config.msg_update'), "Update", $options = []);
            return redirect('passwd');

        } catch (\Exception $e) {
            Toastr::error(config('app_config.msg_failed_update'), "Update Failed", $options = []);
            return redirect("passwd")->with('dangerMsg', $e->getMessage());
        }
    }
}
