<?php

namespace App\Http\Controllers\Trans;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Setup\CommonConfigModel;


use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use Session;
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

            $command_permission = ["click" => Kendo::js('commandPermission'), "text" => trans('users/user.btn_permission')];
            $command[] = $command_permission;

            $command_edit = ["click" => Kendo::js('commandEdit'), "text" => trans('users/user.btn_edit')];
            $command[] = $command_edit;

            $command_del = ["click" => Kendo::js('commandDelete'), "text" => trans('users/user.btn_delete')];
            $command[] = $command_del;

        $grid_data->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "24%"]);

        $data = ['grid_data' => $grid_data];
        return view('trans.registration.list', $data);
    }

    public function read(){

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
    public function store(){

    }
    public function edit(){

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
        return $data;
    }
}
