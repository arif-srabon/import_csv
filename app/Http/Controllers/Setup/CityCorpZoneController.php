<?php
/**
 * Created by PhpStorm.
 * User: Shakhawat
 * Date: 25/2/2016
 * Time: 10:51 AM
 */

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityCorpZoneRequest;
use App\KendoModel as kds;
use App\Model\Program\DivisionModel;
use App\Model\Setup\CityCorpPaurasavaModel;
use App\Model\Setup\CityCorpZoneModel;
use App\Model\Setup\CityCorpZoneMunicipalWardsModel;
use App\Model\Setup\DistrictModel;
use App\Model\Setup\UnionWardModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use Response;
use Riesenia\Kendo\Kendo;
use Session;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;


class CityCorpZoneController extends Controller
{
    public $kds;
    public $lang;

    public function __CONSTRUCT()
    {
        $this->middleware('auth');
        $this->kds = new kds;
        $this->lang = Session::get("locale");
        if (!isset($this->lang)) {
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

        Breadcrumbs::addBreadcrumb(trans('setup/city_corp_zone.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('setup/city_corp_zone.breadcrumb2'), '/citycorpzone');

        $transport_read_data = Kendo::createRead()
            ->setUrl('/citycorpzone/read')
            ->setContentType('application/json')
            ->setType('POST');
        $transport_destroy_data = Kendo::createDestroy()
            ->setUrl('/citycorpzone/destroy')
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

        $grid_city_corp_zone = Kendo::createGrid('#grid_city_corp_zone')
            ->setDataSource($dataSource_data)
            ->setHeight(config('app_config.grid_height'))
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'dist_name', 'title' => trans('setup/city_corp_zone.column_district')],
                ['field' => 'city_corp_name', 'title' => trans('setup/city_corp_zone.column_city_corp')],
                ['field' => 'zone_name', 'title' => trans('setup/city_corp_zone.column_name')],
                ['field' => 'zone_name_bn', 'title' => trans('setup/city_corp_zone.column_name_bn')],
                ['field' => 'wards', 'title' => trans('setup/city_corp_zone.column_wards'), 'filterable' => false, 'sortable' => false, 'width' => "25%"]
            ]);

        $command = array();
        if(SentinelAuth::check('dss.settings.city_corp_zone.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='" . trans('setup/city_corp_zone.btn_edit') . "' ><span class='k-icon k-edit'></span></div>";
            $command_edit = ["template" => $btn_edit];
            $command [] = $command_edit;
        }

        if(SentinelAuth::check('dss.settings.city_corp_zone.del')) {
            $btn_del = "<div class='k-button k-grid-delete' style='min-width: 16px;' title='" . trans('setup/city_corp_zone.btn_delete') . "' ><span class='k-icon k-delete'></span></div>";
            $command_del = ["template" => $btn_del];
            $command [] = $command_del;
        }

        if(SentinelAuth::check(['dss.settings.city_corp_zone.edit', 'dss.settings.city_corp_zone.del'])) {
            $grid_city_corp_zone->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "10%"]);
        }

        $data = ['js_grid_city_corp_zone' => $grid_city_corp_zone];
        return view('setup.city_corp_zone.city_corp_zone_list', $data);
    }

    public function read()
    {

        $request = json_decode(file_get_contents('php://input'));

        $table = "city_corp_zones AS zone
            INNER JOIN city_corp_zone_municipal_wards AS dtl ON zone.id = dtl.city_corp_zone_id
            INNER JOIN union_wards ON dtl.union_ward_id = union_wards.id
            LEFT JOIN city_corp_paurasavas AS city_corp ON zone.city_corp_paurasava_id = city_corp.id
            LEFT JOIN districts ON city_corp.district_id = districts.id
            GROUP BY zone.id";

        $dis_name ='districts.name';
        $city_corp_name ='city_corp.name';
        $ward_name ='union_wards.name';


        if($this->lang =='bn'){
            $dis_name ='districts.name_'.$this->lang;
            $city_corp_name ='city_corp.name_'.$this->lang;
            $ward_name ='union_wards.name_'.$this->lang;
        }

        $properties = array("zone.id",
            "CONCAT($dis_name,' (' ,districts.geo_code,')') AS dist_name",
            "$city_corp_name AS city_corp_name",
            "zone.zone_name",
            "zone.zone_name_bn",
            "GROUP_CONCAT($ward_name) AS wards"
        );

        $data = $this->kds->read($table, $properties, $request);

        return response(json_encode($data))
            ->header('Content-Type', 'application/json');

    }

    public function destroy()
    {
        $request = json_decode(file_get_contents('php://input'));
        $stat = CityCorpZoneModel::destroy($request->id);
        return response(json_encode($stat))
            ->header('Content-Type', 'application/json');
    }

    public function create()
    {

        \Assets::add(['kendoui/kendo.common.min.css',
            'kendoui/kendo.default.min.css',
            'kendoui/kendo.all.min.js',
            'core/libraries/jquery-dynamic-form.js'
        ]);

        $name = 'name';

        if ($this->lang == 'bn') {
            $name = 'name_bn';
        }

        $division = DivisionModel::lists($name, 'id');
        $district = array();
        $city_corp = array();
        $union_ward = array();
        $selected_wards = array();
        return view('setup.city_corp_zone.city_corp_zone_add', compact('division', 'district', 'city_corp', 'union_ward','selected_wards'));
    }

    public function store(CityCorpZoneRequest $request)
    {

        try {

            $inputs = $request->all();
            $data = CityCorpZoneModel::create($inputs);

            $savedId = $data->id;

            $ward = $inputs['union_ward_id'];

            foreach ($ward as $key => $value) {
                $dtl = new CityCorpZoneMunicipalWardsModel();
                $dtl->city_corp_zone_id = $savedId;
                $dtl->union_ward_id = $value;
                $dtl->save();
            }

            $data = ['toastr_success' => config('app_config.toastr_success'), 'title' => 'Add', 'message' => config('app_config.msg_save')];

        } catch (\Exception $e) {
            $data = ['toastr_error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];
        }

        return Response::json($data);
    }

    public function show($id)
    {
        $city_corp_zone = CityCorpZoneModel::find($id);
        return Response::json($city_corp_zone);
    }

    public function edit($id)
    {

        if (!empty($id)) {

            $citycorpzone = CityCorpZoneModel::findOrFail($id);
            $selected_div_dist = DB::table('city_corp_paurasavas')
                ->select('division_id', 'district_id')
                ->where('id', '=', $citycorpzone['city_corp_paurasava_id'])
                ->get();

            $citycorpzone['division_id'] = $selected_div_dist[0]->division_id;
            $citycorpzone['district_id'] = $selected_div_dist[0]->district_id;

            $name = 'name';

            if ($this->lang == 'bn') {
                $name = 'name_bn';
            }

            $division = DivisionModel::lists($name, 'id');
            $district = DistrictModel::where('division_id', '=', $selected_div_dist[0]->division_id)->lists($name, 'id');
            $city_corp = CityCorpPaurasavaModel::where('id', '=', $citycorpzone['city_corp_paurasava_id'])->lists($name, 'id');

            $union_ward =UnionWardModel::where('city_corp_paurasava_id', '=', $citycorpzone['city_corp_paurasava_id'])->lists($name, 'id');
            $selected_ward = CityCorpZoneMunicipalWardsModel::where('city_corp_zone_id', '=', $citycorpzone['id'])->lists('union_ward_id','id');

            foreach ($selected_ward as $selected_ward => $value) {
                $selected_wards[] = $value;
            }

            return view('setup.city_corp_zone.city_corp_zone_edit', compact('citycorpzone', 'division', 'district', 'city_corp', 'union_ward', 'selected_wards'));
        }

    }

    public function update(CityCorpZoneRequest $request, $id)
    {

        try {

            $zone = CityCorpZoneModel::findOrFail($id);
            $zone->update($request->all());

            CityCorpZoneMunicipalWardsModel::where('city_corp_zone_id', $id)->delete();

            $inputs = $request->all();

            $ward = $inputs['union_ward_id'];

            foreach ($ward as $key => $value) {
                $dtl = new CityCorpZoneMunicipalWardsModel();
                $dtl->city_corp_zone_id = $id;
                $dtl->union_ward_id = $value;
                $dtl->save();
            }

            $data = ['toastr_success' => config('app_config.toastr_success'), 'title' => 'Update', 'message' => config('app_config.msg_update')];

        } catch (\Exception $e) {

            $data = ['toastr_error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];
        }
        return Response::json($data);
    }

}