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
use App\Model\Setup\ThanaUpazillaModel as ThanaUpazilla;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use Response;
use App\Http\Requests\ThanaUpazillaRequest;

use App\Model\Setup\DistrictModel as District;

use App\Model\Program\DivisionModel as Division;

use narutimateum\Toastr\Facades\Toastr;

use Illuminate\Support\Facades\App;

use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;

class ThanaUpazillaiController extends Controller
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

        Breadcrumbs::addBreadcrumb(trans('setup/thanaupazilla.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('setup/thanaupazilla.breadcrumb2'), '/thanaupazilla');

        $transport_read_data = Kendo::createRead()
            ->setUrl('/thanaupazilla/read')
            ->setContentType('application/json')
            ->setType('POST');
        $transport_destroy_data = Kendo::createDestroy()
            ->setUrl('/thanaupazilla/destroy')
            ->setContentType('application/json')
            ->setType('POST');

        $transport_data = Kendo::createTransport()
            ->setRead($transport_read_data)
            ->setDestroy($transport_destroy_data)
            ->setParameterMap(Kendo::js('function(data) { return kendo.stringify(data); }'));
        //print_r($transport_data);
        $model_data = Kendo::createModel()
            ->addField('id')
            ->addField('name', ['type' => 'string'])
            ->addField('name_bn', ['type' => 'string']);

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
            ->setPageSizes(array(5, 10, 15, 20))
            ->setButtonCount(5);

        $thana = trans('setup/thanaupazilla.label_thana');
        $upazila = trans('setup/thanaupazilla.label_upazilla');
        $both = trans('setup/thanaupazilla.label_both');

        $type =  '# if (type == "Thana") { #'.$thana.'# } else if (type == "Upazilla") { #'.$upazila.'# } else { #'.$both.'# } #';


        $idsc_data = Kendo::createGrid('#grid_thana_upazilla')
            ->setDataSource($dataSource_data)
            ->setHeight(500)
            //->setScrollable(true)
            //->setSelectable('row')
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'division_geoCode_Name', 'sortable' => false, 'title' => trans('setup/thanaupazilla.column_division')],
                ['field' => 'district_geoCode_Name', 'sortable' => false, 'title' => trans('setup/thanaupazilla.column_district')],
                ['field' => 'type', 'sortable' => false, 'title' => trans('setup/thanaupazilla.column_type'), 'template' => $type],
                ['field' => 'geo_code', 'title' => trans('setup/thanaupazilla.column_code'), 'width' => "15%"],
                ['field' => 'name', 'title' => trans('setup/thanaupazilla.column_name')],
                ['field' => 'name_bn', 'title' => trans('setup/thanaupazilla.column_name_bn')]
            ]);

        $command = array();
        if (SentinelAuth::check('dss.settings.thana_upazilla.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='" . trans('setup/thanaupazilla.btn_edit') . "' ><span class='k-icon k-edit'></span></div>";
            $command_edit = ["template" => $btn_edit];
            $command [0] = $command_edit;
        }
        if (SentinelAuth::check('dss.settings.thana_upazilla.del')) {
            $btn_del = "<div class='k-button k-grid-delete' style='min-width: 16px;' title='" . trans('setup/thanaupazilla.btn_delete') . "' ><span class='k-icon k-delete'></span></div>";
            $command_del = ["template" => $btn_del];
            $command [1] = $command_del;
        }
        if(SentinelAuth::check(['dss.settings.thana_upazilla.edit', 'dss.settings.thana_upazilla.del'])) {
            $idsc_data->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "10%"]);
        }

        $data = ['js_thana_upazilla' => $idsc_data];
        //return view('idsc_center', $data);
        return view('setup.thana_upazilla.thanaupazilla_list_form', $data);
    }

    public function read()
    {
        $request = json_decode(file_get_contents('php://input'));

        $table = "thana_upazilas thanaUpazilla INNER JOIN divisions AS division ON thanaUpazilla.division_id = division.id
        INNER JOIN districts AS district ON thanaUpazilla.district_id = district.id";

        $div_name = 'division.name';
        $district = 'district.name';
        if($this->lang =='bn') {
            $div_name = 'division.name_' . $this->lang;
            $district = 'district.name_'. $this->lang;
        }

        $properties = array("thanaUpazilla.id",
            'thanaUpazilla.geo_code',
            "thanaUpazilla.name AS name",
            "thanaUpazilla.name_bn",
            "thanaUpazilla.type",
            "CONCAT($div_name, ' (', division.geo_code, ')') AS division_geoCode_Name",
            "CONCAT($district, ' (', district.geo_code, ')') AS district_geoCode_Name"
        );

        $data = $this->kds->read($table, $properties, $request);

        return response(json_encode($data))
            ->header('Content-Type', 'application/json');

    }

    public function destroy()
    {

        $request = json_decode(file_get_contents('php://input'));
        $stat = ThanaUpazilla::destroy($request->id);
        return response(json_encode($stat))
            ->header('Content-Type', 'application/json');

    }

    public function create()
    {

        \Assets::add(['kendoui/kendo.common.min.css',
            'kendoui/kendo.default.min.css',
            'kendoui/kendo.all.min.js'
        ]);

        if ($this->lang == "en") {
            $division = Division::lists('name', 'id');
        } else {
            $division = Division::lists('name_bn', 'id');
        }
        $district = array();

        return view('setup.thana_upazilla.thanaupazilla_add_form', compact('division', 'district'));
    }

    public function show($id)
    {
        $districts = ThanaUpazilla::find($id);
        return Response::json($districts);
    }


    public function store(ThanaUpazillaRequest $request)
    {
        try {
            $inputs = $request->all();
            ThanaUpazilla::create($inputs);
            $data = ['toastr_success' => config('app_config.toastr_success'), 'title' => 'Add', 'message' => config('app_config.msg_save')];
        } catch (\Exception $e) {
            $data = ['toastr_error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];
        }
        return Response::json($data);

    }

    public function edit($id)
    {
        if ($this->lang == "en") {
            $division = Division::lists('name', 'id');
        } else {
            $division = Division::lists('name_bn', 'id');
        }
        $thanaUpazillas = ThanaUpazilla::findOrFail($id);

        if ($this->lang == "en") {
            $district = District::where('division_id', '=', $thanaUpazillas['division_id'])
                ->lists('name', 'id');
        } else {
            $district = District::where('division_id', '=', $thanaUpazillas['division_id'])
                ->lists('name_bn', 'id');
        }

        return view('setup.thana_upazilla.thanaupazilla_edit_form', compact('thanaUpazillas', 'division', 'district'));
    }

    public function update(ThanaUpazillaRequest $request, $id)
    {
        try {

            $thanaupazilla = ThanaUpazilla::findOrFail($id);
            $thanaupazilla->update($request->all());
            $data = ['toastr_success' => config('app_config.toastr_success'), 'title' => 'Update', 'message' => config('app_config.msg_update')];

        } catch (\Exception $e) {
            $data = ['toastr_error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];
        }
        return Response::json($data);
    }

    public function getDistrict($divisionId = null)
    {
        $divId = $divisionId;
        if ($this->lang == "en") {
            $districts = District::where('division_id', '=', $divId)
                ->orderBy('name', 'asc')->select('name AS name', 'id')
                ->get();
        } else {
            $districts = District::where('division_id', '=', $divId)
                ->orderBy('name', 'asc')->select('name_bn AS name', 'id')
                ->get();
        }

        return Response::json($districts);


    }

}