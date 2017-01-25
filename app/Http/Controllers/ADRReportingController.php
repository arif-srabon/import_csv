<?php
/**
 * ADR Reporting Controller
 * @author  Mayeenul Islam
 * @since   1.0.0
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Setup\DistrictModel;
use App\Model\ADRReportingModel as ADRReporting;
use App\Model\Setup\CommonConfigModel;

use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;
use Illuminate\Support\Facades\Session;
use narutimateum\Toastr\Facades\Toastr;
use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
//use Session;
use Validator;
use Response;
use App\Http\Requests\ADRReportingRequest;


class ADRReportingController extends Controller
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
            'kendoui/kendo.all.min.js'
        ]);


        /**
         * Initiate the breadcrumb
         */
        Breadcrumbs::addBreadcrumb(trans('adrreporting.breadcrumb'), '/adrreporting');


        /**
         * Process and Display data using Kendo UI
         */
        $transport_read_data = Kendo::createRead()
            ->setUrl('/adrreporting/read')
            ->setContentType('application/json')
            ->setType('POST');
        $transport_destroy_data = Kendo::createDestroy()
            ->setUrl('/adrreporting/destroy')
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
            $status = '#if(status == 1){#
                            সক্রিয়
                        #}else if(status == 0){#
                            ~ অনির্ধারিত ~
                        #}else{#
                            নিষ্ক্রিয়
                        #}#';
        } else {
            $status = '#if(status == 1){#
                            Active
                        #}else if(status == 0){#
                            ~ No Status ~
                        #}else{#
                            InActive
                        #}#';
        }

        $grid_adrreporting = Kendo::createGrid('#grid_adrreporting')
            ->setDataSource($dataSource_data)
            ->setHeight(config('app_config.grid_height'))
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'submission_dt', 'title' => trans('adrreporting.column_submission_dt'),'filterable' =>false],
                ['field' => 'from_district', 'title' => trans('adrreporting.column_from_district')],
                ['field' => 'suspected_medicine', 'title' => trans('adrreporting.column_suspected_medicine')],
                ['field' => 'manufacturer', 'title' => trans('adrreporting.column_manufacturer')],
                ['field' => 'status', 'title' => trans('adrreporting.column_status'), 'template' => $status]
            ]);

        $command = array();
        if(SentinelAuth::check('transactions.adrreporting.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='" . trans('adrreporting.btn_feedback') . "' ><span class='icon-bubble9'></span></div>";
            $command_edit = ["template" => $btn_edit];
            $command [] = $command_edit;
        }

        if(SentinelAuth::check('transactions.adrreporting.print')) {
            $btn_print = "<div class='k-button k-grid-print' style='min-width: 16px;' title='" . trans('adrreporting.btn_print') . "' ><span class='icon-printer'></span></div>";
            $command_print = ["template" => $btn_print];
            $command [] = $command_print;
        }

        if(SentinelAuth::check(['transactions.adrreporting.edit', 'transactions.adrreporting.print'])) {
            $grid_adrreporting->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "10%"]);
        }

        $data = ['js_grid_adrreporting' => $grid_adrreporting];

        return view('adrreporting.adrreporting', $data);

    }


    /**
     * Read ADR Reporting Data
     * @return array JSON array.
     * ---------------------------------------------------------------------
     */
    public function read()
    {

        $request = json_decode(file_get_contents('php://input'));

        $table = 'adr_reporting';
        $table .= ' LEFT JOIN users AS user ON adr_reporting.reported_by = user.id';
        $table .= ' LEFT JOIN districts AS district ON user.district_id = district.id';
        $table .= ' LEFT JOIN cc_adr_status AS adr_status ON adr_reporting.status_id = adr_status.id';

        $district     = 'district.name AS from_district';
        $status       = 'adr_reporting.status_id as status';
        if( 'bn' === $this->lang ) {
            $district = "district.name_{$this->lang} AS from_district";
        }

        $properties = array(
            'adr_reporting.id',
            "DATE_FORMAT(adr_reporting.submission_dt,'%e %M %Y') AS submission_dt", //date formatted to readable form
            $district,
            'adr_reporting.suspected_medicine AS suspected_medicine',
            'adr_reporting.manufacturer AS manufacturer',
            $status
        );

        $data = $this->kds->read($table, $properties, $request);

        return response(json_encode($data))
            ->header('Content-Type', 'application/json');

    }


    /**
     * Show Individual ADR Reporting
     * @return array ADR Report data.
     * ---------------------------------------------------------------------
     */
    public function show($id)
    {
        $adr_reports = ADRReporting::find($id);
        return Response::json($adr_reports);
    }


    /**
     * Edit ADR Report
     * @param  integer $id ID of the ADR Report.
     * @return mixed       View of the Edit form of the ADR Reporting.
     * ---------------------------------------------------------------------
     */
    public function edit($id)
    {

        \Assets::add([
            'plugins/forms/styling/uniform.min.js',
            'plugins/forms/selects/select2.min.js'
        ]);

        /**
         * Initiate the breadcrumb
         */
        Breadcrumbs::addBreadcrumb(trans('adrreporting.breadcrumb'), '/adrreporting');
        Breadcrumbs::addBreadcrumb(trans('adrreporting.breadcrumb_review'), '/adrreporting/edit');

        $adrreporting = ADRReporting::findOrFail($id);
        //$division     = DivisionModel::lists('name', 'id');
        $district     = DistrictModel::lists('name', 'id');

        $data['getADRReportingInfo']         = $adrreporting->getADRReportingInfo($id);
        $data['getConcurrentMedicineInfo']   = $adrreporting->getConcurrentMedicineInfo($id);
        $data['getAdverseEffectSeriousness'] = $adrreporting->getAdverseEffectSeriousness($id);
        $data['getAdverseEffectOutcome']     = $adrreporting->getAdverseEffectOutcome($id);
        $data['getThreeMonthsMedicineInfo']  = $adrreporting->getThreeMonthsMedicineInfo($id);

        $commonConfig            = new CommonConfigModel;
        $data['adrReportStatus'] = $commonConfig->getAllCommonConfigList( 'cc_adr_status', $this->lang );
        $data['adrAdvice']       = $commonConfig->getAllCommonConfigList( 'cc_adr_advice', $this->lang );

        return view('adrreporting.edit', compact('adrreporting', 'district'))->with($data);
    }


    /**
     * Update ADR Reporting Data
     * @param  ADRReportingRequest $request Type of the request.
     * @param  integer              $id     Id of the ADR Report.
     * @return array                        JSON array of the updated ADR Report data.
     * ---------------------------------------------------------------------
     */
    public function update(ADRReportingRequest $request, $id)
    {
        try {
            $adr_reporting             = ADRReporting::findOrFail($id);
            $adr_reporting->updated_by = Session::get('sess_user_id');
            $adr_reporting->update($request->all());

            Toastr::success(config('app_config.msg_update'), "Update", $options = []);

            return redirect("adrreporting/$id/edit");

        } catch (\Exception $e) {

            Toastr::error(config('app_config.msg_failed_update'), "Update Failed", $options = []);

            return redirect("adrreporting/$id/edit")
                ->with('dangerMsg', $e->getMessage());
        }
    }


    /**
     * Print ADR Reporting Data
     * @param  integer $id     Id of the ADR Report.
     * @return object          Print view.
     * ---------------------------------------------------------------------
     */
    public function printADRReport($id)
    {
        \Assets::add([
            'plugins/forms/styling/uniform.min.js',
            'plugins/forms/selects/select2.min.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('adrreporting.breadcrumb'), '#');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb3'), '#');

        $data                                = [];
        $adr_reporting                       = new ADRReporting;
        $adr_reportings                      = ADRReporting::findOrFail($id);
        $data['getADRReportingInfo']         = $adr_reportings->getADRReportingInfo($id);
        $data['getConcurrentMedicineInfo']   = $adr_reportings->getConcurrentMedicineInfo($id);
        $data['getAdverseEffectSeriousness'] = $adr_reportings->getAdverseEffectSeriousness($id);
        $data['getAdverseEffectOutcome']     = $adr_reportings->getAdverseEffectOutcome($id);
        $data['getThreeMonthsMedicineInfo']  = $adr_reportings->getThreeMonthsMedicineInfo($id);
        
        $commonConfig                        = new CommonConfigModel;
        $data['adrReportStatus']             = $commonConfig->getAllCommonConfigList( 'cc_adr_status', $this->lang );
        $data['adrAdvice']                   = $commonConfig->getAllCommonConfigList('cc_adr_advice', $this->lang);

        return view('adrreporting.print', compact('adr_reportings'))->with($data);
    }

}
