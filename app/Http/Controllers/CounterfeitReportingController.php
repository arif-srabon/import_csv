<?php
/**
 * Counterfeit Reporting Controller
 * @author  Mayeenul Islam
 * @since   1.0.0
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Setup\DistrictModel;
use App\Model\CounterfeitReportingModel as CounterfeitReporting;
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
use App\Http\Requests\CounterfeitReportingRequest;


class CounterfeitReportingController extends Controller
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
        Breadcrumbs::addBreadcrumb(trans('counterfeit.breadcrumb'), '/counterfeit');


        /**
         * Process and Display data using Kendo UI
         */
        $transport_read_data = Kendo::createRead()
            ->setUrl('/counterfeit/read')
            ->setContentType('application/json')
            ->setType('POST');
        $transport_destroy_data = Kendo::createDestroy()
            ->setUrl('/counterfeit/destroy')
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

        $grid_counterfeit = Kendo::createGrid('#grid_counterfeit')
            ->setDataSource($dataSource_data)
            ->setHeight(config('app_config.grid_height'))
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'submission_dt', 'title' => trans('counterfeit.column_submission_dt'),'filterable' =>false],
                ['field' => 'from_district', 'title' => trans('counterfeit.column_from_district')],
                ['field' => 'suspected_medicine', 'title' => trans('counterfeit.column_suspected_medicine')],
                ['field' => 'manufacturer', 'title' => trans('counterfeit.column_manufacturer')],
                ['field' => 'status', 'title' => trans('counterfeit.column_status'), 'template' => $status ]
            ]);

        $command = array();
        if(SentinelAuth::check('transactions.counterfeit.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='" . trans('counterfeit.btn_feedback') . "' ><span class='icon-bubble9'></span></div>";
            $command_edit = ["template" => $btn_edit];
            $command [] = $command_edit;
        }

        if(SentinelAuth::check('transactions.counterfeit.print')) {
            $btn_print = "<div class='k-button k-grid-print' style='min-width: 16px;' title='" . trans('counterfeit.btn_print') . "' ><span class='icon-printer'></span></div>";
            $command_print = ["template" => $btn_print];
            $command [] = $command_print;
        }

        if(SentinelAuth::check(['transactions.counterfeit.edit', 'transactions.counterfeit.print'])) {
            $grid_counterfeit->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "10%"]);
        }

        $data = ['js_grid_counterfeit' => $grid_counterfeit];

        return view('counterfeit.counterfeit', $data);

    }


    /**
     * Read Counterfeit Reporting Data
     * @return array JSON array.
     * ---------------------------------------------------------------------
     */
    public function read()
    {

        $request = json_decode(file_get_contents('php://input'));

        $table = 'counterfeit_reporting';
        $table .= ' LEFT JOIN users AS user ON counterfeit_reporting.reported_by = user.id';
        $table .= ' LEFT JOIN districts AS district ON user.district_id = district.id';
        $table .= ' LEFT JOIN cc_adr_status AS adr_status ON counterfeit_reporting.status_id = adr_status.id';

        $district = 'district.name AS from_district';
        $status   = 'counterfeit_reporting.status_id as status';
        if( 'bn' === $this->lang ) {
            $district = "district.name_{$this->lang} AS from_district";
        }

        $properties = array(
            'counterfeit_reporting.id',
            "DATE_FORMAT(counterfeit_reporting.submission_dt,'%e %M %Y') AS submission_dt", //date formatted to readable form
            $district,
            'counterfeit_reporting.suspected_medicine AS suspected_medicine',
            'counterfeit_reporting.manufacturer AS manufacturer',
            $status
        );

        $data = $this->kds->read($table, $properties, $request);

        return response(json_encode($data))
            ->header('Content-Type', 'application/json');

    }


    /**
     * Show Individual Counterfeit Reporting
     * @return array Counterfeit report data.
     * ---------------------------------------------------------------------
     */
    public function show($id)
    {
        $counterfeit_reports = CounterfeitReporting::find($id);
        return Response::json($counterfeit_reports);
    }


    /**
     * Edit Counterfeit Report
     * @param  integer $id ID of the counterfeit Report.
     * @return mixed       View of the Edit form of the counterfeit Reporting.
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
        Breadcrumbs::addBreadcrumb(trans('counterfeit.breadcrumb'), '/counterfeit');
        Breadcrumbs::addBreadcrumb(trans('counterfeit.breadcrumb_review'), '/counterfeit/edit');

        $counterfeit = CounterfeitReporting::findOrFail($id);
        //$division     = DivisionModel::lists('name', 'id');
        $district    = DistrictModel::lists('name', 'id');

        $data['getCounterfeitInfo']          = $counterfeit->getCounterfeitInfo($id);
        $data['getCounterfeitIncidentInfo']  = $counterfeit->getCounterfeitIncidentInfo($id);

        /**
         * Same as ADR Reporting
         * Because they both shares the same values.
         */
        $commonConfig            = new CommonConfigModel;
        $data['adrReportStatus'] = $commonConfig->getAllCommonConfigList( 'cc_adr_status', $this->lang );
        $data['adrAdvice']       = $commonConfig->getAllCommonConfigList( 'cc_adr_advice', $this->lang );

        return view('counterfeit.edit', compact('counterfeit', 'district'))->with($data);
    }


    /**
     * Update Counterfeit Reporting Data
     * @param  CounterfeitReportingRequest $request Type of the request.
     * @param  integer $id     Id of the counterfeit Report.
     * @return array           JSON array of the updated counterfeit Report data.
     * ---------------------------------------------------------------------
     */
    public function update(CounterfeitReportingRequest $request, $id)
    {
        try {
            $counterfeit             = CounterfeitReporting::findOrFail($id);
            $counterfeit->updated_by = Session::get('sess_user_id');
            $counterfeit->update($request->all());

            Toastr::success(config('app_config.msg_update'), "Update", $options = []);

            return redirect("counterfeit/$id/edit");

        } catch (\Exception $e) {

            Toastr::error(config('app_config.msg_failed_update'), "Update Failed", $options = []);

            return redirect("counterfeit/$id/edit")
                ->with('dangerMsg', $e->getMessage());
        }

        return Response::json($data);
    }


    /**
     * Print Counterfeit Reporting Data
     * @param  integer $id     Id of the counterfeit Report.
     * @return object          Print view.
     * ---------------------------------------------------------------------
     */
    public function printCounterfeitReport($id)
    {
        \Assets::add([
            'plugins/forms/styling/uniform.min.js',
            'plugins/forms/selects/select2.min.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('counterfeit.breadcrumb'), '#');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb3'), '#');

        $data                                = [];
        $counterfeit                         = new CounterfeitReporting;
        $counterfeits                        = CounterfeitReporting::findOrFail($id);
        $data['getCounterfeitInfo']          = $counterfeits->getCounterfeitInfo($id);
        $data['getCounterfeitIncidentInfo']  = $counterfeits->getCounterfeitIncidentInfo($id);
        
        /**
         * Same as ADR Reporting
         * Because they both shares the same values.
         */
        $commonConfig            = new CommonConfigModel;
        $data['adrReportStatus'] = $commonConfig->getAllCommonConfigList( 'cc_adr_status', $this->lang );
        $data['adrAdvice']       = $commonConfig->getAllCommonConfigList( 'cc_adr_advice', $this->lang );

        return view('counterfeit.print', compact('counterfeits'))->with($data);
    }

}
