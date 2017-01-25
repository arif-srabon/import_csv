<?php
/**
 * Created by PhpStorm.
 * User: Shipon
 * Date: 1/24/2016
 * Time: 6:48 PM
 */

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Setup\DistrictModel as District;

use Illuminate\Support\Facades\Session;
use narutimateum\Toastr\Facades\Toastr;

use Response;
use App\Http\Requests\DistrictRequest;

use Illuminate\Support\Facades\App;

use App\Model\Program\DivisionModel as Division;

use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;


class DistrictuiController extends Controller
{
    public $kds;
    public $lang;

    public function __CONSTRUCT()
    {
        $this->middleware('auth');
        $this->kds = new kds;
        $this->lang = Session::get("locale");

        if(!isset($this->lang)){
            $this->lang = config('app.locale');
        }
    }

    public function index()
    {
        \Assets::add(['kendoui/kendo.common.min.css',
            'kendoui/kendo.default.min.css',
            'kendoui/kendo.all.min.js',
            'pages/components_modals.js'
        ]);

        Breadcrumbs::addBreadcrumb(trans('setup/district.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('setup/district.breadcrumb2'), '/district');

        $transport_read_data = Kendo::createRead()
            ->setUrl('/district/read')
            ->setContentType('application/json')
            ->setType('POST');
        $transport_destroy_data = Kendo::createDestroy()
            ->setUrl('/district/destroy')
            ->setContentType('application/json')
            ->setType('POST');

        $transport_data = Kendo::createTransport()
            ->setRead($transport_read_data)
            ->setDestroy($transport_destroy_data)
            ->setParameterMap(Kendo::js('function(data) { return kendo.stringify(data); }'));

        $model_data = Kendo::createModel()
            ->addField('id');

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
            ->setPageSizes(config('app_config.grid_page_sizes'))
            ->setButtonCount(config('app_config.grid_button_count'));
        /*if ($this->lang == "en") {
            $division = 'geoCode_Name';
        }else{
            $division = 'geoCode_Name_bn';
        }*/

        $grid_district = Kendo::createGrid('#grid_district')
            ->setDataSource($dataSource_data)
            ->setHeight(config('app_config.grid_height'))
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'geoCode_Name', 'title' => trans('setup/district.column_division')],
                ['field' => 'geo_code', 'title' => trans('setup/district.column_code'), 'width' => "11%"],
                ['field' => 'name', 'title' => trans('setup/district.column_name')],
                ['field' => 'name_bn', 'title' => trans('setup/district.column_name_bn')]
            ]);

        $command = array();
        if(SentinelAuth::check('dss.settings.district.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='" . trans('setup/district.btn_edit') . "' ><span class='k-icon k-edit'></span></div>";
            $command_edit = ["template" => $btn_edit];
            $command [] = $command_edit;
        }

        if(SentinelAuth::check('dss.settings.district.del')) {
            $btn_del = "<div class='k-button k-grid-delete' style='min-width: 16px;' title='" . trans('setup/district.btn_delete') . "' ><span class='k-icon k-delete'></span></div>";
            $command_del = ["template" => $btn_del];
            $command [] = $command_del;
        }

        if(SentinelAuth::check(['dss.settings.district.edit', 'dss.settings.district.del'])) {
            $grid_district->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "10%"]);
        }

        $data = ['js_grid_district' => $grid_district];
        return view('setup.district.district_list_form', $data);
    }

    public function read()
    {

        $request = json_decode(file_get_contents('php://input'));

        $table = "districts district INNER JOIN divisions AS division ON district.division_id = division.id";

        $div_name = 'division.name';
        //$district = 'district.name';
        if($this->lang =='bn') {
            $div_name = 'division.name_' . $this->lang;
            //$district = 'district.name_'. $this->lang;
        }
        $properties = array("district.id",
            'district.geo_code AS geo_code',
            "district.name AS name",
            "district.name_bn AS  name_bn",
            //"{$div_name} AS division_name",
            "CONCAT({$div_name},' (',division.geo_code,')') AS geoCode_Name"
        );

        $data = $this->kds->read($table, $properties, $request);

        return response(json_encode($data))
            ->header('Content-Type', 'application/json');

    }

    public function destroy()
    {
        $request = json_decode(file_get_contents('php://input'));
        $stat = District::destroy($request->id);
        return response(json_encode($stat))
            ->header('Content-Type', 'application/json');
    }

    public function create()
    {
        if ($this->lang == "en") {
            $division = Division::lists('name', 'id');
        } else {
            $division = Division::lists('name_bn', 'id');
        }
        return view('setup.district.district_add', compact('division'));
    }

    public function store(DistrictRequest $request)
    {
        try {
            $inputs = $request->all();
            District::create($inputs);
            $data = ['toastr_success' => config('app_config.toastr_success'), 'title' => 'Add', 'message' => config('app_config.msg_save')];

        } catch (\Exception $e) {
            $data = ['toastr_error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];

        }

        return Response::json($data);

    }

    public function show($id)
    {
        $districts = District::find($id);
        return Response::json($districts);
    }

    public function edit($id)
    {
        $districts = District::findOrFail($id);
        if ($this->lang == "en") {
            $division = Division::lists('name', 'id');
        } else {
            $division = Division::lists('name_bn', 'id');
        }
        return view('setup.district.district_edit_form', compact('districts', 'division'));

    }

    public function update(DistrictRequest $request, $id)
    {
        try {

            $district = District::findOrFail($id);
            $district->update($request->all());
            $data = ['toastr_success' => config('app_config.toastr_success'), 'title' => 'Update', 'message' => config('app_config.msg_update')];

        } catch (\Exception $e) {
            $data = ['toastr_error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];

        }
        return Response::json($data);
    }


}