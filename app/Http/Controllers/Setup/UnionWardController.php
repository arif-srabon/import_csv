<?php


namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Model\Setup\UnionWardModel as UnionWard;
use Illuminate\Support\Facades\Session;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use Response;
use App\Http\Requests\UnionWardRequest;

use App\Model\Program\DivisionModel as Division;
use App\Model\Setup\DistrictModel as District;
use App\Model\Setup\ThanaUpazillaModel as ThanaUpazilla;
use App\Model\Setup\CityCorpPaurasavaModel as CityCorpPaurasava;
use App\Model\Setup\LocationTypeModel as LocationType;

use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;


class UnionWardController extends Controller
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

        Breadcrumbs::addBreadcrumb(trans('setup/unionward.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('setup/unionward.breadcrumb2'), '/unionward');

        $transport_read_data = Kendo::createRead()
            ->setUrl('/unionward/read')
            ->setContentType('application/json')
            ->setType('POST');
        $transport_destroy_data = Kendo::createDestroy()
            ->setUrl('/unionward/destroy')
            ->setContentType('application/json')
            ->setType('POST');

        $transport_data = Kendo::createTransport()
            ->setRead($transport_read_data)
            ->setDestroy($transport_destroy_data)
            ->setParameterMap(Kendo::js('function(data) { return kendo.stringify(data); }'));
        //print_r($transport_data);
        $model_data = Kendo::createModel()
            ->addField('id');
//            ->addField('name', ['type' => 'string'])
//            ->addField('name_bn', ['type' => 'string']);

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
            ->setPageSizes(array(5, 10, 15, 20))
            ->setButtonCount(5);

        $grid_data = Kendo::createGrid('#grid_union_ward')
            ->setDataSource($dataSource_data)
            ->setHeight(500)
            //->setScrollable(true)
            //->setSelectable('row')
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'division_geoCode_Name', 'sortable' => false, 'title' => trans('setup/unionward.column_division')],
                ['field' => 'district_geoCode_Name', 'sortable' => false, 'title' => trans('setup/unionward.column_district')],
                ['field' => 'thana_geoCode_Name', 'sortable' => false, 'title' => trans('setup/unionward.column_thana')],
                ['field' => 'geo_code', 'title' => trans('setup/unionward.column_code'), 'width' => "15%"],
                ['field' => 'unionward_name', 'title' => trans('setup/unionward.column_name')],
                ['field' => 'name_bn', 'title' => trans('setup/unionward.column_name_bn')]
            ]);

        $command = array();
        if (SentinelAuth::check('dss.settings.union_ward.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='" . trans('setup/unionward.btn_edit') . "' ><span class='k-icon k-edit'></span></div>";
            $command_edit = ["template" => $btn_edit];
            $command [] = $command_edit;
        }
        if (SentinelAuth::check('dss.settings.union_ward.del')) {
            $btn_del = "<div class='k-button k-grid-delete' style='min-width: 16px;' title='" . trans('setup/unionward.btn_delete') . "' ><span class='k-icon k-delete'></span></div>";
            $command_del = ["template" => $btn_del];
            $command [] = $command_del;
        }
        if (SentinelAuth::check(['dss.settings.union_ward.edit', 'dss.settings.union_ward.del'])) {
            $grid_data->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "10%"]);
        }

        $data = ['js_union_ward' => $grid_data];
        //return view('idsc_center', $data);
        return view('setup.union_ward.unionward_list_form', $data);
    }

//    private function _defaultFilter()
//    {
//        $userOfficeInfo = Session::get('sess_user_office_info');
//
//        //$userOfficeInfo[0]->office_office_type_id = 1;  // for test
//        //dd($userOfficeInfo[0]->office_office_type_id);
//
//        if (!empty($userOfficeInfo[0]->office_office_type_id) && $userOfficeInfo[0]->office_office_type_id == 1) {
//            return true;    //show all user list
//        } else if (!empty($userOfficeInfo[0]->office_office_type_id) && $userOfficeInfo[0]->office_office_type_id == 2) {
//            $search[] = array('field' => 'district_id', 'operator' => 'eq', 'value' => $userOfficeInfo[0]->office_district_id);
//            $filter[] = ['filters' => $search];
//            // return $filter;
//
//        } else if (!empty($userOfficeInfo[0]->office_office_type_id) && $userOfficeInfo[0]->office_office_type_id == 3) {
//
//            $search[] = array('field' => 'thana_upazila_id', 'operator' => 'eq', 'value' => $userOfficeInfo[0]->office_thana_upazila_id);
//
//            if (!empty($userOfficeInfo[0]->office_thana_upazila_id)) {
//
//                $search[] = array('field' => 'thana_upazila_id', 'operator' => 'eq', 'value' => $userOfficeInfo[0]->office_thana_upazila_id);
//
//                if ($userOfficeInfo[0]->office_city_corp_paurasava_id != 0 && $userOfficeInfo[0]->office_city_corp_paurasava_id != null) {
//
//                    $search[] = array('field' => 'city_corp_paurasava_id', 'operator' => 'eq', 'value' => $userOfficeInfo[0]->office_city_corp_paurasava_id);
//                }
//// else {
////
////                    $search[] = array('field' => 'city_corp_paurasava_id', 'operator' => 'eq', 'value' => 0);
////                }
//
//            } else {
//                $search[] = array('field' => 'district_id', 'operator' => 'eq', 'value' => $userOfficeInfo[0]->office_district_id);
//            }
//
//            $filter1 = (object)array(
//                'logic' => 'or',
//                'filters' => array(
//                    (object)array(
//                        'field' => 'location_type_id',
//                        'operator' => 'eq',
//                        'value' => 1
//                    ),
//                    (object)array(
//                        'field' => 'location_type_id',
//                        'operator' => 'eq',
//                        'value' => 3
//                    ))
//            );
//            $search[] = $filter1;
//
//            $filter[] = ['filters' => $search];
//            //return $filter;
//
//        } else if (!empty($userOfficeInfo[0]->office_office_type_id) && $userOfficeInfo[0]->office_office_type_id == 4) {
//           // $search[] = array('field' => 'thana_upazila_id', 'operator' => 'eq', 'value' => $userOfficeInfo[0]->office_thana_upazila_id);
//
//            if ($userOfficeInfo[0]->office_thana_upazila_id != 0) {
//                $search[] = array('field' => 'thana_upazila_id', 'operator' => 'eq', 'value' => $userOfficeInfo[0]->office_thana_upazila_id);
//            }
//
//            if ($userOfficeInfo[0]->office_city_corp_paurasava_id != 0) {
//
//                $search[] = array('field' => 'city_corp_paurasava_id', 'operator' => 'eq', 'value' => $userOfficeInfo[0]->office_city_corp_paurasava_id);
//            }
//
//            $filter1 = (object)array(
//                'logic' => 'or',
//                'filters' => array(
//                    (object)array(
//                        'field' => 'location_type_id',
//                        'operator' => 'eq',
//                        'value' => 2
//                    ),
//                    (object)array(
//                        'field' => 'location_type_id',
//                        'operator' => 'eq',
//                        'value' => 3
//                    ))
//            );
//            $search[] = $filter1;
//
//            $filter[] = ['filters' => $search];
//            //return $filter;
//        } else {
//            $filter[] = ['filters' => false];
//        }
//
//        return $filter;
//    }

    public function read()
    {

        $request = json_decode(file_get_contents('php://input'));

        $table = "union_wards unionward INNER JOIN divisions AS division ON unionward.division_id = division.id
        INNER JOIN districts AS district ON unionward.district_id = district.id
        LEFT JOIN thana_upazilas AS thana ON unionward.thana_upazila_id = thana.id";

        $name = 'name';
        if ($this->lang == 'bn') {
            $name = 'name_bn';
        }

        $properties = array("unionward.id", 'unionward.geo_code', "unionward.name AS unionward_name", "unionward.name_bn",
            "division.name AS division_name",
            'district.id AS district_id',
            'thana.id AS thana_upazila_id',
            'unionward.location_type_id AS location_type_id',
            "CONCAT(division.$name, ' (', division.geo_code, ')') AS division_geoCode_Name",
            "CONCAT(district.$name, ' (', district.geo_code, ')') AS district_geoCode_Name",
            "CONCAT(thana.$name, ' (', thana.geo_code, ')') AS thana_geoCode_Name",
        );

        $data = $this->kds->read($table, $properties, $request);

        return response(json_encode($data))
            ->header('Content-Type', 'application/json');

    }

    public function destroy()
    {

        $request = json_decode(file_get_contents('php://input'));
        $stat = UnionWard::destroy($request->id);
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
        $district = array();
        $thanaUpazilla = array();
        $cityCorp = array();
        $paurasava = array();
        if ($this->lang == "en") {
            $locationType = LocationType::lists('name', 'id');
        } else {
            $locationType = LocationType::lists('name_bn', 'id');
        }
        return view('setup.union_ward.unionward_add_form', compact('division', 'district', 'thanaUpazilla', 'paurasava', 'cityCorp', 'locationType'));
    }

    public function store(UnionWardRequest $request)
    {
        try {
            $cityPaurasavaId = "";
            if (empty($request->input('paurasava_id')) && !empty($request->input('city_corp_id'))) {
                $cityPaurasavaId = $request->input('city_corp_id');
            }
            if (!empty($request->input('paurasava_id')) && empty($request->input('city_corp_id'))) {
                $cityPaurasavaId = $request->input('paurasava_id');
                $cityPaurasavaMasterId = CityCorpPaurasava::where('id', '=', $cityPaurasavaId)->get();
                $thanaId = $cityPaurasavaMasterId[0]->thana_upazila_id;
            }

            $inputs = new UnionWard;
            $inputs->division_id = $request->input('division_id');
            $inputs->district_id = $request->input('district_id');
            $inputs->location_type_id = $request->input('location_type_id');
            if ($request->input('thana_upazila_id') == "") {
                $inputs->thana_upazila_id = $thanaId;
            } else {
                $inputs->thana_upazila_id = $request->input('thana_upazila_id');
            }
            $inputs->city_corp_paurasava_id = $cityPaurasavaId;
            $inputs->geo_code = $request->input('geo_code');
            $inputs->name = $request->input('name');
            $inputs->name_bn = $request->input('name_bn');
            $inputs->created_by = 1;
            $inputs->updated_by = 1;
            $inputs->save();

            $data = ['toastr_success' => config('app_config.toastr_success'), 'title' => 'Add', 'message' => config('app_config.msg_save')];
        } catch (\Exception $e) {
            $data = ['toastr_error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];
        }
        return Response::json($data);

    }

    public function update(UnionWardRequest $request, $id)
    {
        try {

            $inputs = UnionWard::find($id);

            if (empty($request->input('paurasava_id')) && !empty($request->input('city_corp_id'))) {
                $cityPaurasavaId = $request->input('city_corp_id');
                $thanaId = null;
            } else if (!empty($request->input('paurasava_id')) && empty($request->input('city_corp_id'))) {
                $cityPaurasavaId = $request->input('paurasava_id');
                $cityPaurasavaMasterId = CityCorpPaurasava::where('id', '=', $cityPaurasavaId)->get();
                $thanaId = $cityPaurasavaMasterId[0]->thana_upazila_id;

            } else {
                $inputs->thana_upazila_id = $request->input('thana_upazila_id');
                $cityPaurasavaId = null;
            }
            $inputs->division_id = $request->input('division_id');
            $inputs->district_id = $request->input('district_id');
            $inputs->location_type_id = $request->input('location_type_id');
            if ($request->input('thana_upazila_id') == "") {
                $inputs->thana_upazila_id = $thanaId;
            } else {
                $inputs->thana_upazila_id = $request->input('thana_upazila_id');
            }
            $inputs->city_corp_paurasava_id = $cityPaurasavaId;
            $inputs->geo_code = $request->input('geo_code');
            $inputs->name = $request->input('name');
            $inputs->name_bn = $request->input('name_bn');
            $inputs->created_by = 1;
            $inputs->updated_by = 1;
            $inputs->save();

            $data = ['toastr_success' => config('app_config.toastr_success'), 'title' => 'Update', 'message' => config('app_config.msg_update')];

        } catch (\Exception $e) {
            $data = ['toastr_error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];
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
        \Assets::add(['plugins/forms/validation/validate.min.js',
            'plugins/forms/styling/uniform.min.js'
        ]);

        $unionWard = UnionWard::findOrFail($id);
        if ($this->lang == "en") {
            $division = Division::lists('name', 'id');
        } else {
            $division = Division::lists('name_bn', 'id');
        }
        if ($this->lang == "en") {
            $district = District::where('division_id', '=', $unionWard['division_id'])
                ->lists('name', 'id');
        } else {
            $district = District::where('division_id', '=', $unionWard['division_id'])
                ->lists('name_bn', 'id');
        }
        if ($this->lang == "en") {
            $thanaUpazilla = ThanaUpazilla::where('district_id', '=', $unionWard['district_id'])
                ->lists('name', 'id');
        } else {
            $thanaUpazilla = ThanaUpazilla::where('district_id', '=', $unionWard['district_id'])
                ->lists('name_bn', 'id');
        }
        if ($this->lang == "en") {
            $cityCorp = CityCorpPaurasava::where('district_id', '=', $unionWard['district_id'])
                ->where('type', '=', 'City Corp.')
                ->lists('name', 'id');

            $paurasava = CityCorpPaurasava::where('district_id', '=', $unionWard['district_id'])
                ->where('type', '=', 'Paurasava')
                ->lists('name_bn', 'id');
        } else {
            $cityCorp = CityCorpPaurasava::where('district_id', '=', $unionWard['district_id'])
                ->where('type', '=', 'City Corp.')
                ->lists('name_bn', 'id');

            $paurasava = CityCorpPaurasava::where('district_id', '=', $unionWard['district_id'])
                ->where('type', '=', 'Paurasava')
                ->lists('name_bn', 'id');
        }
        if ($this->lang == "en") {
            $locationType = LocationType::lists('name', 'id');
        } else {
            $locationType = LocationType::lists('name_bn', 'id');
        }

        return view('setup.union_ward.unionward_edit_form', compact('unionWard', 'division', 'district', 'thanaUpazilla', 'paurasava', 'cityCorp', 'locationType'));
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

    public function getThanaUpazillaByDistrict($districtId = null)
    {
        $disId = $districtId;
        if ($this->lang == "en") {
            $thanaUpazillas = ThanaUpazilla::where('district_id', '=', $disId)
                ->orderBy('name', 'asc')->select('name AS name', 'id')
                ->get();
        } else {
            $thanaUpazillas = ThanaUpazilla::where('district_id', '=', $disId)
                ->orderBy('name', 'asc')->select('name_bn AS name', 'id')
                ->get();
        }

        return Response::json($thanaUpazillas);
    }

    public function getPaurasavaByDistrict($districtId = null)
    {
        $disId = $districtId;
        if ($this->lang == "en") {
            $paurasavas = CityCorpPaurasava::where('district_id', '=', $disId)
                ->where('type', '=', 'Paurasava')
                ->orderBy('name', 'asc')->select('name AS name', 'id')
                ->get();
        } else {
            $paurasavas = CityCorpPaurasava::where('district_id', '=', $disId)
                ->where('type', '=', 'Paurasava')
                ->orderBy('name', 'asc')->select('name_bn AS name', 'id')
                ->get();
        }

        return Response::json($paurasavas);


    }

    public function getCityCorpByDistrict($districtId = null)
    {
        $disId = $districtId;
        if ($this->lang == "en") {
            $cityCorps = CityCorpPaurasava::where('district_id', '=', $disId)
                ->where('type', '=', 'City Corp.')->select('name AS name', 'id')
                ->orderBy('name', 'asc')
                ->get();
        } else {
            $cityCorps = CityCorpPaurasava::where('district_id', '=', $disId)
                ->where('type', '=', 'City Corp.')
                ->orderBy('name', 'asc')->select('name_bn AS name', 'id')
                ->get();
        }

        return Response::json($cityCorps);


    }

}