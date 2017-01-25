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
use App\Model\Setup\ThanaUnionWardModel as ThanaUnionWard;

use App\Model\Setup\ThanaUpazillaModel as ThanaUpazilla;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use Response;
use App\Http\Requests\ThanaUnionWardRequest;
use App\Model\Setup\DistrictModel as District;
use App\Model\Program\DivisionModel as Division;
use App\Model\Setup\UnionWardModel as UnionWard;
use narutimateum\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\App;
use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;

class ThanaUnionWardController extends Controller
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

        Breadcrumbs::addBreadcrumb(trans('setup/thanaunionward.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('setup/thanaunionward.breadcrumb2'), '/thanaunionward');

        $transport_read_data = Kendo::createRead()
            ->setUrl('/thanaunionward/read')
            ->setContentType('application/json')
            ->setType('POST');
        $transport_destroy_data = Kendo::createDestroy()
            ->setUrl('/thanaunionward/destroy')
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

        // grid filter
        if ($this->_defaultFilter() !== false) {
            $filter = $this->_defaultFilter();
            $dataSource_data->setFilter($filter);
        }
        ///////////////////

        $pageable = Kendo::createPageable();
        $pageable->setRefresh(true)
            ->setPageSizes(config('app_config.grid_page_sizes'))
            ->setButtonCount(config('app_config.grid_button_count'));

        $idsc_data = Kendo::createGrid('#grid_thana_union_ward')
            ->setDataSource($dataSource_data)
            ->setHeight(config('app_config.grid_height'))
            //->setScrollable(true)
            //->setSelectable('row')
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'division_geoCode_Name', 'sortable' => false, 'title' => trans('setup/thanaunionward.column_division')],
                ['field' => 'district_geoCode_Name', 'sortable' => false, 'title' => trans('setup/thanaunionward.column_district')],
                ['field' => 'thanaUpazila_geoCode_Name', 'sortable' => false, 'title' => trans('setup/thanaunionward.column_thana')],
                ['field' => 'unionWard_geoCode_Name', 'sortable' => false, 'title' => trans('setup/thanaunionward.column_union')],
                ['field' => 'geo_code', 'title' => trans('setup/thanaunionward.column_code'), 'width' => "15%"],
                ['field' => 'name', 'title' => trans('setup/thanaunionward.column_name')],
                ['field' => 'name_bn', 'title' => trans('setup/thanaunionward.column_name_bn')]
            ]);

        $command = array();
        if(SentinelAuth::check('dss.settings.unionward.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='".trans('setup/thanaunionward.btn_edit'). "' ><span class='k-icon k-edit'></span></div>";
            $command_edit = ["template" => $btn_edit];
            $command [] = $command_edit;
        }
        if(SentinelAuth::check('dss.settings.unionward.del')) {
            $btn_del = "<div class='k-button k-grid-delete' style='min-width: 16px;' title='".trans('setup/thanaunionward.btn_delete'). "' ><span class='k-icon k-delete'></span></div>";
            $command_del = ["template" => $btn_del];
            $command [] = $command_del;
        }
        if(SentinelAuth::check(['dss.settings.unionward.edit', 'dss.settings.unionward.del'])) {
            $idsc_data->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "10%"]);
        }

        $data = ['js_thana_union_ward' => $idsc_data];
        //return view('idsc_center', $data);
        return view('setup.thanaunionward.list', $data);
    }

    private function _defaultFilter()
    {
        $userOfficeInfo = Session::get('sess_user_office_info');

        //$userOfficeInfo[0]->office_office_type_id = 1;  // for test
        //dd($userOfficeInfo[0]->office_office_type_id);

        if (!empty($userOfficeInfo[0]->office_office_type_id) && $userOfficeInfo[0]->office_office_type_id == 1) {
            return true;    //show all user list
        } else if (!empty($userOfficeInfo[0]->office_office_type_id) && $userOfficeInfo[0]->office_office_type_id == 2) {
            $search[] = array('field' => 'district_id', 'operator' => 'eq', 'value' => $userOfficeInfo[0]->office_district_id);
            $filter[] = ['filters' => $search];
            // return $filter;

        } else if (!empty($userOfficeInfo[0]->office_office_type_id) && $userOfficeInfo[0]->office_office_type_id == 3) {

            $search[] = array('field' => 'thana_upazila_id', 'operator' => 'eq', 'value' => $userOfficeInfo[0]->office_thana_upazila_id);

            $filter[] = ['filters' => $search];
            //return $filter;

        } else if (!empty($userOfficeInfo[0]->office_office_type_id) && $userOfficeInfo[0]->office_office_type_id == 4) {
            $search[] = array('field' => 'thana_upazila_id', 'operator' => 'eq', 'value' => $userOfficeInfo[0]->office_thana_upazila_id);

            $filter[] = ['filters' => $search];
            //return $filter;
        } else {
            $filter[] = ['filters' => false];
        }

        return $filter;
    }

    public function read()
    {

        $request = json_decode(file_get_contents('php://input'));

        $table = "wards ward
                    INNER JOIN divisions AS division ON ward.division_id = division.id
                    INNER JOIN districts AS district ON ward.district_id = district.id
                    INNER JOIN thana_upazilas AS thanaUpazila ON thanaUpazila.id = ward.thana_upazila_id
                    INNER JOIN union_wards AS unionWard ON unionWard.id = ward.union_ward_id";

        $name = 'name';
        if($this->lang == 'bn'){
            $name = 'name_bn';
        }

        $properties = array('ward.id',
            'ward.geo_code',
            'ward.name',
            'ward.name_bn',

            "division.name AS division_name",
            'district.id AS district_id',
            'thanaUpazila.id AS thana_upazila_id',

            "CONCAT(division.$name,' (',division.geo_code ,')') AS division_geoCode_Name",
            "CONCAT(district.$name,' (', district.geo_code , ')') AS district_geoCode_Name",
            "CONCAT(thanaUpazila.$name,' (', thanaUpazila.geo_code , ')') AS thanaUpazila_geoCode_Name",
            "CONCAT(unionWard.$name,' (', unionWard.geo_code , ')') AS unionWard_geoCode_Name"
        );

        $data = $this->kds->read($table, $properties, $request);

        return response(json_encode($data))
            ->header('Content-Type', 'application/json');

    }

    public function destroy()
    {

        $request = json_decode(file_get_contents('php://input'));
        $stat = ThanaUnionWard::destroy($request->id);
        return response(json_encode($stat))
            ->header('Content-Type', 'application/json');

    }

    public function create()
    {

        \Assets::add(['kendoui/kendo.common.min.css',
            'kendoui/kendo.default.min.css',
            'kendoui/kendo.all.min.js'
        ]);

        $name = 'name';
        if ($this->lang == "bn") {
            $name = 'name_bn';
        }

        $division = Division::lists($name, 'id');
        $district = array();
        $thanaUpazilla = array();
        $union = array();

        $userOfficeInfo = Session::get('sess_user_office_info');

        if(count($userOfficeInfo)> 0){
            $data['office_division'] = $userOfficeInfo[0]->office_division_id;
            $data['office_district'] = $userOfficeInfo[0]->office_district_id;
            $data['office_thana_upazila'] = $userOfficeInfo[0]->office_thana_upazila_id;
            $data['office_thana_upazila'] = $userOfficeInfo[0]->office_thana_upazila_id;
            $data['office_city_corp_paurasava'] = $userOfficeInfo[0]->office_city_corp_paurasava_id;
            $district = District::where('division_id','=',$userOfficeInfo[0]->office_division_id)->lists($name, 'id');
            $thanaUpazilla = ThanaUpazilla::where('district_id','=',$userOfficeInfo[0]->office_district_id)->lists($name, 'id');
            $union = UnionWard::where('thana_upazila_id','=',$userOfficeInfo[0]->office_thana_upazila_id)->lists($name, 'id');
        }

        return view('setup.thanaunionward.create', compact('division', 'district', 'thanaUpazilla', 'union'))->with($data);
    }

    public function show($id)
    {
        $districts = ThanaUnionWard::find($id);
        return Response::json($districts);
    }


    public function store(ThanaUnionWardRequest $request)
    {
        try {
            $inputs = $request->all();
            ThanaUnionWard::create($inputs);
            $data = ['toastr_success' => config('app_config.toastr_success'), 'title' => 'Add', 'message' => config('app_config.msg_save')];
        } catch (\Exception $e) {
            $data = ['toastr_error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];
        }
        return Response::json($data);

    }

    public function edit($id)
    {
        $thanaunionward = ThanaUnionWard::findOrFail($id);
        if ($this->lang == "en") {
            $division = Division::lists('name', 'id');
        } else {
            $division = Division::lists('name_bn', 'id');
        }

        if ($this->lang == "en") {
            $district = District::where('division_id', '=', $thanaunionward['division_id'])
                ->lists('name', 'id');
        } else {
            $district = District::where('division_id', '=', $thanaunionward['division_id'])
                ->lists('name_bn', 'id');
        }
        if ($this->lang == "en") {
            $thanaUpazilla = ThanaUpazilla::where('district_id', '=', $thanaunionward['district_id'])
                ->lists('name', 'id');
        } else {
            $thanaUpazilla = ThanaUpazilla::where('district_id', '=', $thanaunionward['district_id'])
                ->lists('name_bn', 'id');
        }
        if ($this->lang == "en") {
            $union = UnionWard::where('thana_upazila_id', '=', $thanaunionward['thana_upazila_id'])
                ->lists('name', 'id');
        } else {
            $union = UnionWard::where('thana_upazila_id', '=', $thanaunionward['thana_upazila_id'])
                ->lists('name_bn', 'id');
        }

        return view('setup.thanaunionward.edit', compact('thanaunionward', 'division', 'district', 'thanaUpazilla', 'union'));
    }

    public function update(ThanaUnionWardRequest $request, $id)
    {
        try {
            $thanaupazilla = ThanaUnionWard::findOrFail($id);
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
                ->orderBy('name', 'asc')->select('name AS name','id')
                ->get();
        } else{
            $districts = District::where('division_id', '=', $divId)
                ->orderBy('name', 'asc')->select('name_bn AS name','id')
                ->get();
        }
        return Response::json($districts);
    }

    public function getUnionByThana($thanaUpazillaId = null)
    {
        $thanaId = $thanaUpazillaId;

        if ($this->lang == "en") {
            $unions = UnionWard::where('thana_upazila_id', '=', $thanaId)
                ->where('location_type_id' , '=',1)
                ->orderBy('name', 'asc')->select('name AS name','id')
                ->get();
        } else{
            $unions = UnionWard::where('thana_upazila_id', '=', $thanaId)
                ->where('location_type_id' , '=',1)
                ->orderBy('name', 'asc')->select('name_bn AS name','id')
                ->get();
        }
        return Response::json($unions);
    }

}