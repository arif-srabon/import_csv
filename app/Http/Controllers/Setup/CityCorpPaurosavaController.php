<?php
/**
 * Created by PhpStorm.
 * User: Shipon
 * Date: 1/24/2016
 * Time: 6:48 PM
 */

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;

use App\Model\Setup\CityCorpPaurasavaModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Setup\CityCorpPaurasavaModel as CityCorpPaurasava;

use Illuminate\Support\Facades\Session;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use narutimateum\Toastr\Facades\Toastr;

use Response;
use App\Http\Requests\CityCorpPaurasavaRequest;

use Illuminate\Support\Facades\App;

use App\Model\Program\DivisionModel as Division;

use App\Model\Setup\DistrictModel as District;

use App\Model\Setup\ThanaUpazillaModel as ThanaUpazilla;

use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;


class CityCorpPaurosavaController extends Controller
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

        Breadcrumbs::addBreadcrumb(trans('setup/citypaurasava.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('setup/citypaurasava.breadcrumb2'), '/citycorppaurasava');

        $transport_read_data = Kendo::createRead()
            ->setUrl('/citycorppaurasava/read')
            ->setContentType('application/json')
            ->setType('POST');
        $transport_destroy_data = Kendo::createDestroy()
            ->setUrl('/citycorppaurasava/destroy')
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

        $idsc_data = Kendo::createGrid('#grid_city_paurasava')
            ->setDataSource($dataSource_data)
            ->setHeight(500)
            //->setScrollable(true)
            //->setSelectable('row')
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'division_geoCode_Name', 'sortable' => false, 'title' => trans('setup/citypaurasava.column_division')],
                ['field' => 'district_geoCode_Name', 'sortable' => false, 'title' => trans('setup/citypaurasava.column_district')],
                ['field' => 'thana_geoCode_Name', 'sortable' => false, 'title' => trans('setup/citypaurasava.column_thana')],
                ['field' => 'geo_code', 'title' => trans('setup/citypaurasava.column_code'), 'width' => "15%"],
                ['field' => 'name', 'title' => trans('setup/citypaurasava.column_name')],
                ['field' => 'name_bn', 'title' => trans('setup/citypaurasava.column_name_bn')]
            ]);

        $command = array();
        if(SentinelAuth::check('dss.settings.city_corp_paurasava.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='".trans('setup/citypaurasava.btn_edit'). "' ><span class='k-icon k-edit'></span></div>";
            $command_edit = ["template" => $btn_edit];
            $command [] = $command_edit;
        }

        if(SentinelAuth::check('dss.settings.city_corp_paurasava.del')) {
            $btn_del = "<div class='k-button k-grid-delete' style='min-width: 16px;' title='".trans('setup/citypaurasava.btn_delete'). "' ><span class='k-icon k-delete'></span></div>";
            $command_del = ["template" => $btn_del];
            $command [] = $command_del;
        }

        if(SentinelAuth::check(['dss.settings.city_corp_paurasava.edit', 'dss.settings.city_corp_paurasava.del'])) {
            $idsc_data->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "10%"]);
        }

        $data = ['js_city_paurasava' => $idsc_data];
        //return view('idsc_center', $data);
        return view('setup.city_corp_paurasava.citycorppaurasava_list_form', $data);
    }

    public function read()
    {

        $request = json_decode(file_get_contents('php://input'));

        $table = "city_corp_paurasavas cityPaurasava INNER JOIN divisions AS division ON cityPaurasava.division_id = division.id
        INNER JOIN districts AS district ON cityPaurasava.district_id = district.id
        LEFT JOIN thana_upazilas AS thana ON cityPaurasava.thana_upazila_id = thana.id";
        $div_name = 'division.name';
        $district = 'district.name';
        $thana = 'thana.name';
        if($this->lang =='bn') {
            $div_name = 'division.name_' . $this->lang;
            $district = 'district.name_'. $this->lang;
            $thana = 'thana.name_'. $this->lang;
        }
        $properties = array("cityPaurasava.id",
            'cityPaurasava.geo_code',
            "cityPaurasava.name AS name",
            "cityPaurasava.name_bn",
            "CONCAT({$div_name}, ' (', division.geo_code, ')') AS division_geoCode_Name",
            "CONCAT({$district}, ' (', district.geo_code, ')') AS district_geoCode_Name",
            "CONCAT({$thana}, ' (', thana.geo_code, ')') AS thana_geoCode_Name"
        );

        $data = $this->kds->read($table, $properties, $request);

        return response(json_encode($data))
            ->header('Content-Type', 'application/json');

    }

    public function destroy()
    {

        $request = json_decode(file_get_contents('php://input'));
        $stat = CityCorpPaurasava::destroy($request->id);
        return response(json_encode($stat))
            ->header('Content-Type', 'application/json');
    }

    public function create()
    {
        \Assets::add(['kendoui/kendo.common.min.css',
            'kendoui/kendo.default.min.css',
            'kendoui/kendo.all.min.js'
        ]);

        $district = array();
        if ($this->lang == "en") {
            $division = Division::lists('name', 'id');
        } else {
            $division = Division::lists('name_bn', 'id');
        }
        $thanaUpazilla = array();
        return view('setup.city_corp_paurasava.citycorppaurasava_add_form', compact('division', 'district', 'thanaUpazilla'));
    }

    public function store(CityCorpPaurasavaRequest $request)
    {
        try {
            $inputs = $request->all();
            if($request->input('thana_upazila_id') == "") {
                $inputs['thana_upazila_id'] = null;
            }else{
                $inputs['thana_upazila_id'] = $request->input('thana_upazila_id');
            }
            CityCorpPaurasava::create($inputs);
            $data = ['toastr_success' =>config('app_config.toastr_success'),'title' =>'Add','message'=>config('app_config.msg_save')];
        } catch (\Exception $e) {
            $data = ['toastr_error' =>config('app_config.toastr_error'),'title' =>'Error','message' =>$e->getMessage()];
        }
        return Response::json($data);

    }

    public function update(CityCorpPaurasavaRequest $request, $id)
    {
        try {

            $district = CityCorpPaurasava::findOrFail($id);

            $inputs = $request->all();

            if($request->input('thana_upazila_id') == "") {
                $inputs['thana_upazila_id'] = null;
            }else{
                $inputs['thana_upazila_id'] = $request->input('thana_upazila_id');
            }

            $district->update($inputs);

            $data = ['toastr_success' =>config('app_config.toastr_success'), 'title' =>'Update','message'=>config('app_config.msg_update')];

        } catch (\Exception $e) {
            $data = ['toastr_error' =>config('app_config.toastr_error'),'title' =>'Error','message' =>$e->getMessage()];
        }
        return Response::json($data);
    }

    public function show($id)
    {
        $districts = CityCorpPaurasava::find($id);
        return Response::json($districts);
    }

    public function edit($id)
    {

        $citypaurasava = CityCorpPaurasava::findOrFail($id);

        if ($this->lang == "en") {
            $division = Division::lists('name', 'id');
        } else {
            $division = Division::lists('name_bn', 'id');
        }

        if ($this->lang == "en") {
            $district = District::where('division_id', '=', $citypaurasava['division_id'])
                ->lists('name', 'id');
        } else {
            $district = District::where('division_id', '=', $citypaurasava['division_id'])
                ->lists('name_bn', 'id');
        }

        if ($this->lang == "en") {
            $thanaUpazilla = ThanaUpazilla::where('district_id', '=', $citypaurasava['district_id'])
                ->lists('name','id');
        } else {
            $thanaUpazilla = ThanaUpazilla::where('district_id', '=', $citypaurasava['district_id'])
                ->lists('name_bn','id');
        }

        return view('setup.city_corp_paurasava.citycorppaurasava_edit_form', compact('citypaurasava', 'division', 'district', 'thanaUpazilla'));
    }

    public function getDistrict($divisionId = null)
    {
        $divId = $divisionId;
        if ($this->lang == "en") {
            $districts = District::where('division_id', '=', $divId)
                ->orderBy('name', 'asc')->select('name AS name','id')
                ->get();
        } else{
            $districts = District::where('division_id', '=', $divId)
                ->orderBy('name', 'asc')->select('name_bn AS name','id')
                ->get();
        }

        return Response::json($districts);


    }

    public function getThanaUpazillaByDistrict($districtId = null)
    {
        $disId = $districtId;

        if ($this->lang == "en") {
            $thanaUpazillas = ThanaUpazilla::where('district_id', '=', $disId)
                ->orderBy('name', 'asc')->select('name AS name','id')
                ->get();
        } else{
            $thanaUpazillas = ThanaUpazilla::where('district_id', '=', $disId)
                ->orderBy('name', 'asc')->select('name_bn AS name','id')
                ->get();
        }

        return Response::json($thanaUpazillas);


    }

    public function getCityCorpPaurasavaByDistrict($districtId = null)
    {
        $disId = $districtId;

        $city_corp_paurasava = CityCorpPaurasavaModel::where('district_id', '=', $disId)
            ->orderBy('name', 'asc')
            ->get();

        return Response::json($city_corp_paurasava);
    }

}