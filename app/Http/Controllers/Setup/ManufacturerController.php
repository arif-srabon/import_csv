<?php
/**
 * Manufacturer Controller
 * @author  Mayeenul Islam
 * @since   1.0.0
 */

namespace App\Http\Controllers\Setup;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Setup\DistrictModel;
use App\Model\Program\DivisionModel;
use App\Model\Setup\ManufacturerModel as Manufacturer;

use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;
use narutimateum\Toastr\Facades\Toastr;
use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use Session;
use Validator;
use Response;
use App\Http\Requests\ManufacturerRequest;


class ManufacturerController extends Controller
{

	public $kds;
    public $lang;

    public function __construct()
    {
        $this->middleware('auth');
        $this->kds = new kds;
        $this->lang = Session::get("locale");

        if(!isset($this->lang)){
            $this->lang = config('app.locale');
        }
    }
    

    /**
     * Index: Primary View
     * @return mixed View will be populated by Kendo UI.
     * ---------------------------------------------------------------------
     */
    public function index()
    {

    	/**
         * Load necessary assets specific to this UI
         */
    	\Assets::add(['kendoui/kendo.common.min.css',
            'kendoui/kendo.default.min.css',
            'kendoui/kendo.all.min.js',
            'plugins/pickers/datepicker.js'
        ]);


        /**
         * Initiate the breadcrumb
         */
        Breadcrumbs::addBreadcrumb(trans('setup/manufacturer.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('setup/manufacturer.breadcrumb2'), '/manufacturer');


        /**
         * Process and Display data using Kendo UI
         */
        $transport_read_data = Kendo::createRead()
            ->setUrl('/manufacturer/read')
            ->setContentType('application/json')
            ->setType('POST');
        $transport_destroy_data = Kendo::createDestroy()
            ->setUrl('/manufacturer/destroy')
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

        /** Making boolean 'status' field to something readable **/
        if ('bn' === $this->lang) {
            $status = '# if (1 == status) { #সক্রিয়# } else { #নিষ্ক্রিয়# } #';
        } else {
            $status = '# if (1 == status) { #Active# } else { #Inactive# } #';
        }

        //$registration_date = date('d M Y g:i a', strtotime(registration_dt));

        $grid_manufacturer = Kendo::createGrid('#grid_manufacturer')
            ->setDataSource($dataSource_data)
            ->setHeight(config('app_config.grid_height'))
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'code', 'title' => trans('setup/manufacturer.column_code'),'filterable' =>false,'sortable' =>false],
                ['field' => 'name_bn', 'title' => trans('setup/manufacturer.column_name_bn')],
                ['field' => 'name', 'title' => trans('setup/manufacturer.column_name')],
                ['field' => 'division_name', 'title' => trans('setup/manufacturer.column_division_name')],
                ['field' => 'district_name', 'title' => trans('setup/manufacturer.column_district_name')],
                ['field' => 'address', 'title' => trans('setup/manufacturer.column_address')],
                ['field' => 'registration_dt', 'title' => trans('setup/manufacturer.column_registration_dt')],
                ['field' => 'status', 'title' => trans('setup/manufacturer.column_status'), 'template' => $status]
            ]);

        $command = array();
        if(SentinelAuth::check('settings.manufacturer.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='" . trans('setup/manufacturer.btn_edit') . "' ><span class='k-icon k-edit'></span></div>";
            $command_edit = ["template" => $btn_edit];
            $command [] = $command_edit;
        }

        if(SentinelAuth::check('settings.manufacturer.del')) {
            $btn_del = "<div class='k-button k-grid-delete' style='min-width: 16px;' title='" . trans('setup/manufacturer.btn_delete') . "' ><span class='k-icon k-delete'></span></div>";
            $command_del = ["template" => $btn_del];
            $command [] = $command_del;
        }

        if(SentinelAuth::check(['settings.manufacturer.edit', 'settings.manufacturer.del'])) {
            $grid_manufacturer->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "10%"]);
        }

        $data = ['js_grid_manufacturer' => $grid_manufacturer];

        return view('setup.manufacturer.manufacturer', $data);

    }


    /**
     * Read Manufacturer Data
     * @return array JSON array.
     * ---------------------------------------------------------------------
     */
    public function read()
    {

        $request = json_decode(file_get_contents('php://input'));

        $table = 'manufacturer';
        $table .= ' LEFT JOIN divisions AS division ON manufacturer.division_id = division.id';
        $table .= ' LEFT JOIN districts AS district ON manufacturer.district_id = district.id';

        $div_name = 'division.name AS division_name'; 
        $district = 'district.name AS district_name';
        if( 'bn' === $this->lang ) {
            $div_name = "division.name_{$this->lang} AS division_name";
            $district = "district.name_{$this->lang} AS district_name";
        }

        $properties = array(
            'manufacturer.id',
            'manufacturer.code AS code',
            'manufacturer.code_non_bio AS code_non_bio',
            'manufacturer.name AS name',
            'manufacturer.name_bn AS name_bn',
            $div_name,
            $district,
            'manufacturer.address AS address',
            "DATE_FORMAT(manufacturer.registration_dt,'%e %M %Y') AS registration_dt", //date formatted to readable form
            'manufacturer.status AS status'
        );

        $data = $this->kds->read($table, $properties, $request);

        return response(json_encode($data))
            ->header('Content-Type', 'application/json');

    }


    /**
     * Show Individual Manufacturer
     * @return array Manufacturer data.
     * ---------------------------------------------------------------------
     */
    public function show($id)
    {
        $manufacturers = Manufacturer::find($id);
        return Response::json($manufacturers);
    }


    /**
     * Create Manufacturer
     * @return mixed Creation of a manufacturer UI.
     * ---------------------------------------------------------------------
     */
    public function create()
    {
        if ( 'en' === $this->lang )
            $manufacturer = Manufacturer::lists('name', 'id');
        else
            $manufacturer = Manufacturer::lists('name_bn', 'id');

        $district = DistrictModel::lists('name', 'id');
        $division = DivisionModel::lists('name', 'id');

        return view('setup.manufacturer.manufacturer_add', compact('district', 'division'));
    }


    /**
     * Store/Add Manufacturer Data
     * @param  ManufacturerRequest $request Type of request.
     * @return array                        JSON array.
     * ---------------------------------------------------------------------
     */
    public function store(ManufacturerRequest $request)
    {
        try
        {

            $inputs = $request->all();
            Manufacturer::create($inputs);
            $data = ['toastr_success' => config('app_config.toastr_success'), 'title' => 'Add', 'message' => config('app_config.msg_save')];

        } catch (\Exception $e) {

            $data = ['toastr_error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];

        }

        return Response::json($data);

    }


    /**
     * Edit Manufacturer
     * @param  integer $id ID of the Manufacturer.
     * @return mixed       View of the Edit form of the manufacturer.
     * ---------------------------------------------------------------------
     */
    public function edit($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        $division     = DivisionModel::lists('name', 'id');
        $district     = DistrictModel::lists('name', 'id');
        return view('setup.manufacturer.manufacturer_edit_form', compact('manufacturer', 'division', 'district'));
    }


    /**
     * Update Manufacturer Data
     * @param  ManufacturerRequest $request Type of the request.
     * @param  integer              $id     Id of the manufacturer.
     * @return array                        JSON array of the updated manufacturer data.
     * ---------------------------------------------------------------------
     */
    public function update(ManufacturerRequest $request, $id)
    {
        try
        {

            $manufacturer = Manufacturer::findOrFail($id);
            $manufacturer->update($request->all());
            $data = ['toastr_success' => config('app_config.toastr_success'), 'title' => 'Update', 'message' => config('app_config.msg_update')];

        } catch (\Exception $e) {

            $data = ['toastr_error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];

        }

        return Response::json($data);
    }


    /**
     * Destroy/Delete Manufacturer
     * @return array JSON array.
     * ---------------------------------------------------------------------
     */
    public function destroy()
    {
        $request = json_decode(file_get_contents('php://input'));
        $stat    = Manufacturer::destroy($request->id);
        return response(json_encode($stat))
            ->header('Content-Type', 'application/json');
    }

}
