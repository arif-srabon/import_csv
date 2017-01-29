<?php

namespace App\Http\Controllers\Trans;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\RegistrationRequest;
use App\Http\Controllers\Controller;
use App\Model\Setup\CommonConfigModel;
use App\Model\Trans\RegistrationModel as RegistrationModel;
use Illuminate\Support\Facades\Session;
use League\Flysystem\Exception;
use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use Response;
use DB;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use narutimateum\Toastr\Facades\Toastr;

class RegistrationController extends Controller
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

    public function index()
    {
        \Assets::add(['kendoui/kendo.common.min.css',
            'kendoui/kendo.default.min.css',
            'kendoui/kendo.all.min.js'
        ]);
        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('trans/registration.breadcrumb1'), '/registration');
        Breadcrumbs::addBreadcrumb(trans('trans/registration.breadcrumb2'), '#');

        $transport_read_data = Kendo::createRead()
            ->setUrl('/registration/read')
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
//         $search[] = array('field' => 'deptID', 'operator' => '=', 'value' => Session::get('sess_department_id'));
//         $filter[] = ['filters' => $search];
//         $dataSource_data->setFilter($filter);
        ///////////////////


        $pageable = Kendo::createPageable();
        $pageable->setRefresh(true)
            ->setPageSizes(config('app_config.grid_page_sizes'))
            ->setButtonCount(config('app_config.grid_button_count'));

        if ($this->lang == 'bn') {
            $status = "# if (status == 'active') { #সক্রিয়# } else { #নিষ্ক্রিয়# } #";
        } else {
            $status = "# if (status == 'active') { #Active# } else { #Inactive# } #";
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
                ['field' => 'client_id', 'title' => 'client ID','width'=>'90px'],
                ['field' => 'client_name', 'title' => 'name','width'=>'150px'],
                ['field' => 'dept_name', 'title' => 'DepartMent','width'=>'130px'],
                ['field' => 'mobile', 'title' => 'Mobile','width'=>'80px'],
                ['field' => 'date_of_birth', 'title' => 'Date OF Birth','width'=>'100px'],
                ['field' => 'email', 'title' => 'E-mail','width'=>'110px'],
                ['field' => 'status', 'title' => 'Status','width'=>'70px', 'filterable' => false, 'template' => $status],
            ]);


        $command = [];
            $command_printID = ["click" => Kendo::js('commandPrintID'), "text" => trans('trans/registration.btn_printID')];
            $command[] = $command_printID;

            $command_permission = ["click" => Kendo::js('commandPrintInfo'), "text" => trans('trans/registration.btn_print')];
            $command[] = $command_permission;

            $command_edit = ["click" => Kendo::js('commandEdit'), "text" => trans('trans/registration.btn_edit')];
            $command[] = $command_edit;

            $command_del = ["click" => Kendo::js('commandDelete'), "text" => trans('trans/registration.btn_delete')];
            $command[] = $command_del;

        $grid_data->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "25%"]);

        $data = ['grid_data' => $grid_data];
        return view('trans.registration.list', $data);
    }

    public function read()
    {
        $request = json_decode(file_get_contents('php://input'));
        $table = "registration reg
                LEFT JOIN cc_department AS dept ON reg.department_id = dept.id
                ORDER BY id DESC";
        $properties = ["reg.id AS id","reg.client_id AS client_id",
                "reg.client_name AS client_name","dept.name AS dept_name",
                "reg.department_id AS deptID",
                "reg.mobile AS mobile","reg.date_of_birth AS date_of_birth",
                "reg.email AS email","reg.status AS status"
        ];
        $this->kds = new kds;
        $data = $this->kds->read($table, $properties, $request);

        return response(json_encode($data))
            ->header('Content-Type', 'application/json');
    }

    public function create(){
        \Assets::add(['plugins/forms/validation/validate.min.js',
            'plugins/forms/styling/uniform.min.js',
            'plugins/ui/moment/moment.min.js',
            'plugins/bootstrap-datetimepicker.min.js',
            'bootstrap-datetimepicker-standalone.css',
            'plugins/jquery.relatedselects.js',
            'plugins/forms/selects/select2.min.js',
            'app/registration_form_validation.js'
        ]);
        Breadcrumbs::addBreadcrumb(trans('trans/registration.breadcrumb1'), '/registration');
        Breadcrumbs::addBreadcrumb(' Add', '#');
        $data = [];
        $data = array_merge($data, $this->_getBasicData());
        return view('trans.registration.create',$data);
    }
    public function store(RegistrationRequest $requests){
        try{
            $inputs = $requests->all();
            $clientPrefix=$requests->input('client_prefix');
            $client_id=$requests->input('client_id');
            $clientID=$clientPrefix.'-'.$client_id;
            $inputs['client_id']=$clientID;
            unset($inputs['client_prefix']);
            $value = RegistrationModel::create($inputs);
            $this->uploadPhoto($requests, $value->id);

            Toastr::success(config('app_config.msg_save'), "Save", $options = []);

            return redirect('registration/create');
        }catch(\Exception $e){
            Toastr::error(config('app_config.msg_failed_save'), "Save Failed", $options = []);

            return redirect('registration/create')
                ->with('dangerMsg', $e->getMessage());
        }
    }
    public function edit($id){
        \Assets::add(['plugins/forms/validation/validate.min.js',
            'plugins/forms/styling/uniform.min.js',
            'plugins/ui/moment/moment.min.js',
            'plugins/bootstrap-datetimepicker.min.js',
            'bootstrap-datetimepicker-standalone.css',
            'plugins/jquery.relatedselects.js',
            'plugins/forms/selects/select2.min.js',
            'app/registration_form_validation.js'
        ]);
        Breadcrumbs::addBreadcrumb(trans('trans/registration.breadcrumb1'), '/registration');
        Breadcrumbs::addBreadcrumb(' Edit', '#');

        $Registration = RegistrationModel::findOrFail($id);
        $clienRol=explode("-",$Registration->client_id);
        $client_prefix=$clienRol[0];
        $client_id=$clienRol[1];
        $data = [];
        $data = array_merge($data, $this->_getBasicData());

    }
    public function update(){

    }
    public function destroy(){

    }


    private function _getBasicData()
    {
        $cConfig = new CommonConfigModel;
        $data['designation'] = $cConfig->getCommonConfigListForRegistration('cc_designation');
        $data['department'] = $cConfig->getCommonConfigListForRegistration('cc_department');
        $data['gender'] = $cConfig->getCommonConfigListForRegistration('cc_genders');
        $data['maritalstatus'] = $cConfig->getCommonConfigListForRegistration('cc_marital_status');
        $data['divisionList'] = $cConfig->getDivisionsListForRegistration('divisions');
        $data['religionlist'] = $cConfig->getCommonConfigListForRegistration('cc_religion');
        return $data;
    }

    public function uploadPhoto($requests,$id){
        $file=$requests->file('client_photo');
        if(!empty($file)){
            $uploadPath = config('app_config.registration_upload_photo_path')."$id/";
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $orginalfileName = $file->getclientoriginalname() ;
            $file->move(public_path($uploadPath), $orginalfileName);
            $uploadFile = $uploadPath . $orginalfileName;
            $entry = RegistrationModel::find($id);
            $entry->client_photo = $uploadFile;
            $entry->save();
        }
    }
    //For Ajux calling function area
    public function getDepartmentCode(Request $request){
        $deptCode = $request->get('dpetID');
        if($deptCode){
            $dptCode=DB::table('cc_department')
                    ->where('id','=',$deptCode)
                    ->pluck('code');
            return $dptCode;
        }
    }

    public function getAge(){
        $request = json_decode(file_get_contents('php://input'));
        $date_reg = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $date_reg = explode('-', $date_reg);
        $age1 = Carbon::createFromDate($date_reg[0], $date_reg[1], $date_reg[2])->diff(Carbon::now())->format('%y');
        $age2 = Carbon::createFromDate($date_reg[0], $date_reg[1], $date_reg[2])->diff(Carbon::now())->format('%m');
        $age5 = Carbon::createFromDate($date_reg[0], $date_reg[1], $date_reg[2])->diff(Carbon::now())->format('%d');
        if ((INT)$age1 <= 1) {
            $age3 = $age1 . " year";
        } else {
            $age3 = $age1 . " years";
        }
        if ((INT)$age2 <= 1) {
            $age4 = $age2 . " month";
        } else {
            $age4 = $age2 . " months";
        }
        $age = $age3 . " " . $age4 . " ".$age5." day";
        return response(json_encode($age))
            ->header('Content-Type', 'application/json');
    }

    ///
}
