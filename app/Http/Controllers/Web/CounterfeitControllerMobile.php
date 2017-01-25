<?php
/**
 * Front End: Counterfeit
 *
 * @package  adr_dgda/web
 * @author   Mayeenul Islam
 */


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Model\Setup\DistrictModel;
use App\Model\Setup\CommonConfigModel;
use App\Model\Web\CounterfeitModel;
use Illuminate\Support\Facades\DB;

use Validator;
use Response;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Web\CounterfeitRequest;

class CounterfeitControllerMobile extends Controller
{
    public $lang;

    public function __construct()
    {
        $this->lang = Session::get("locale");
        if (!isset($this->lang)) {
            $this->lang = config('app.locale');
        }
    }


    /**
     * Display the form page with necessary dynamic data.
     *
     * @return object Page view.
     */
    public function index()
    {
        /**
         * Load necessary assets specific to this UI
         */
        \Assets::add([
                'plugins/pickers/datepicker.js',
                'plugins/bootstrap3-typeahead.min.js'
            ]);

        $district = DistrictModel::lists('name', 'id');

        /**
         * Same as ADR Reporting
         * Because they both shares the same values.
         */
        $commonConfig                 = new CommonConfigModel;
        $data['counterfeitIncidents'] = $commonConfig->getAllCommonConfigList( 'cc_counterfeit_incident', $this->lang );
        $data['doseForm']             = $commonConfig->getAllCommonConfigList( 'cc_dose_form', $this->lang );
        //$data['adrReportStatus'] = $commonConfig->getAllCommonConfigList( 'cc_adr_status', $this->lang );

        return view('web.counterfeit_mobile', compact('district'))->with($data);
    }


    /**
     * Handle the form submission.
     * 
     * @return object Page view.
     * ---------------------------------------------------------------------
     */
    public function create()
    {
        /**
         * Load necessary assets specific to this UI
         */
        \Assets::add([
                'plugins/pickers/datepicker.js',
                'plugins/bootstrap3-typeahead.min.js'
            ]);
        
        $district = DistrictModel::lists('name', 'id');

        /**
         * Same as ADR Reporting
         * Because they both shares the same values.
         */
        $commonConfig                 = new CommonConfigModel;
        $data['counterfeitIncidents'] = $commonConfig->getAllCommonConfigList( 'cc_counterfeit_incident', $this->lang );
        $data['doseForm']             = $commonConfig->getAllCommonConfigList( 'cc_dose_form', $this->lang );
        //$data['adrReportStatus'] = $commonConfig->getAllCommonConfigList( 'cc_adr_status', $this->lang );

        return view('web.counterfeit_mobile', compact('district'))->with($data);
    }


    /**
     * Store/Add Counterfeit Data
     * @param  CounterfeitRequest $request  Type of request.
     * @return array                        JSON array.
     * ---------------------------------------------------------------------
     */
    public function store(CounterfeitRequest $request)
    {

        try
        {

            $inputs = $request->all();
            $inputs['submission_dt'] = date('Y-m-d');
            /**
             * Taking the value of `id` column from the app_config file
             * that denotes the ID of the `cc_adr_status` table for
             * status 'open'
             */
            $inputs['status_id']    = config('app_config.adr_default_status_id'); //default `1` = open
            
            //user ID dynamically
            $user_id               = Session::get('sess_user_id');
            $inputs['reported_by'] = $user_id;

            $counterfeit_report = CounterfeitModel::create($inputs);

            $counterfeit_id = $counterfeit_report->id;

            if( isset($counterfeit_id) ) {

                // Storing Counterfeit Incidents
                if( isset($inputs['incident_aftermath']) ) {
                    DB::table('counterfeit_incidents')->insert(
                        array(
                                'counterfeit_reporting_id' => $counterfeit_id,
                                'incident_id'              => $inputs['incident_aftermath'],
                                'created_by'               => $user_id,
                                'updated_by'               => $user_id
                            )
                    );
                }

            }

            return redirect('complaints/counterfeit-mobile/create')->with('successMsg', config('app_config.msg_save'));

        } catch (\Exception $e) {

            return redirect('complaints/counterfeit-mobile/create')
                ->with('dangerMsg', $e->getMessage());

        }

    }
}
