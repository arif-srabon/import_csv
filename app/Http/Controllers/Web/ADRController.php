<?php
/**
 * Front End: Adverse Drug Reaction Reporting
 *
 * @package  adr_dgda/web
 * @author   Mayeenul Islam
 */


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Model\Setup\DistrictModel;
use App\Model\Setup\CommonConfigModel;
use App\Model\Web\ADRModel;
use Illuminate\Support\Facades\DB;

use Validator;
use Response;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Web\ADRRequest;

class ADRController extends Controller
{
    public $lang;

    public function __construct()
    {
        $this->middleware('webauth');
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
                'plugins/jquery-dynamic-form.js',
                'plugins/bootstrap3-typeahead.min.js'
    		]);

    	//language supported districts
        $district = ('en' === $this->lang) ? DistrictModel::lists('name', 'id') : DistrictModel::lists('name_bn', 'id');

        /**
         * Same as ADR Reporting
         * Because they both shares the same values.
         */
        $commonConfig                 = new CommonConfigModel;
        $data['counterfeitIncidents'] = $commonConfig->getAllCommonConfigList( 'cc_counterfeit_incident', $this->lang );
        $data['doseForm']             = $commonConfig->getAllCommonConfigList( 'cc_dose_form', $this->lang );
        $data['ageUnit']              = $commonConfig->getAllCommonConfigList( 'cc_age_unit', $this->lang );
        $data['weightUnit']           = $commonConfig->getAllCommonConfigList( 'cc_weight_unit', $this->lang );
        $data['heightUnit']           = $commonConfig->getAllCommonConfigList( 'cc_height_unit', $this->lang );
        $data['doseFrequency']        = $commonConfig->getAllCommonConfigList( 'cc_dose_frequency', $this->lang );
        $data['reactionAction']       = $commonConfig->getAllCommonConfigList( 'cc_reaction_after_action', $this->lang );
        $data['doseRoute']       	  = $commonConfig->getAllCommonConfigList( 'cc_dose_route', $this->lang );
        $data['seriousness']          = $commonConfig->getAllCommonConfigList( 'cc_adr_seriousness', $this->lang );
        $data['outcome']          	  = $commonConfig->getAllCommonConfigList( 'cc_adr_outcome', $this->lang );

        return view('web.adr', compact('district'))->with($data);
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
    			'plugins/jquery-dynamic-form.js',
                'plugins/bootstrap3-typeahead.min.js'
    		]);

        //language supported districts
        $district = ('en' === $this->lang) ? DistrictModel::lists('name', 'id') : DistrictModel::lists('name_bn', 'id');

        /**
         * Same as ADR Reporting
         * Because they both shares the same values.
         */
        $commonConfig                 = new CommonConfigModel;
        $data['counterfeitIncidents'] = $commonConfig->getAllCommonConfigList( 'cc_counterfeit_incident', $this->lang );
        $data['doseForm']             = $commonConfig->getAllCommonConfigList( 'cc_dose_form', $this->lang );
        $data['ageUnit']              = $commonConfig->getAllCommonConfigList( 'cc_age_unit', $this->lang );
        $data['weightUnit']           = $commonConfig->getAllCommonConfigList( 'cc_weight_unit', $this->lang );
        $data['heightUnit']           = $commonConfig->getAllCommonConfigList( 'cc_height_unit', $this->lang );
        $data['doseFrequency']        = $commonConfig->getAllCommonConfigList( 'cc_dose_frequency', $this->lang );
        $data['reactionAction']       = $commonConfig->getAllCommonConfigList( 'cc_reaction_after_action', $this->lang );
        $data['doseRoute']       	  = $commonConfig->getAllCommonConfigList( 'cc_dose_route', $this->lang );
        $data['seriousness']          = $commonConfig->getAllCommonConfigList( 'cc_adr_seriousness', $this->lang );
        $data['outcome']          	  = $commonConfig->getAllCommonConfigList( 'cc_adr_outcome', $this->lang );

        return view('web.adr', compact('district'))->with($data);
    }


    /**
     * Store/Add ADR Data
     * @param  ADRRequest $request  Type of request.
     * @return array                JSON array.
     * ---------------------------------------------------------------------
     */
    public function store(Request $request)
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

            $user_id = Session::get('sess_user_id');
            
            //user ID dynamically
			$inputs['reported_by'] = $user_id;            
			$inputs['created_by']  = $user_id;
			$inputs['updated_by']  = $user_id;

            $adr_report = ADRModel::create($inputs);

            $adr_report_id = $adr_report->id;

            if( isset($adr_report_id) ) {

            	// Adverse Event Seriousness
            	if( isset($inputs['incident_seriousness']) ) {
		            foreach( $inputs['incident_seriousness'] as $seriousness_id ) {
		            	
		            	DB::table('adr_adverse_events')->insert(
						    array(
									'adr_reporting_id' => $adr_report_id,
									'event_type'       => 'seriousness',
									'event_id'         => $seriousness_id,
									'created_by'       => $user_id,
									'updated_by'       => $user_id
						    	)
						);
		            }
            	}

            	// Adverse Event Outcome
	            if( isset($inputs['incident_outcome']) ) {
		            foreach( $inputs['incident_outcome'] as $outcome_id ) {
		            	DB::table('adr_adverse_events')->insert(
						    array(
									'adr_reporting_id' => $adr_report_id,
									'event_type'       => 'outcome',
									'event_id'         => $outcome_id,
									'created_by'       => $user_id,
									'updated_by'       => $user_id
						    	)
						);
		            }
	            }

	            // ADR Other Medicine[s]
	            if( isset($inputs['other_suspected_medicine']) ) {
		            foreach( $inputs['other_suspected_medicine'] as $key => $medicine_name ) {

		            	// Format dates to Y-m-d
						$other_med_start_dt = date('Y-m-d', strtotime( $inputs['other_dose_start_dt'][$key] ));
						$other_med_stop_dt  = date('Y-m-d', strtotime( $inputs['other_dose_stop_dt'][$key] ));

		            	DB::table('adr_concurrent_medicine')->insert(
						    array(
									'adr_reporting_id'  => $adr_report_id,
									'brand_name'        => $medicine_name,
									'generic'           => $inputs['other_generic'][$key],
									'indication'        => $inputs['other_indication'][$key],
									'dose'              => $inputs['other_dose_form_id'][$key],
									'dose_form_id'      => $inputs['other_route_id'][$key],
									'route_id'          => $inputs['other_dose'][$key],
									'dose_frequency_id' => $inputs['other_dose_frequency_id'][$key],
									'dose_start_dt'     => $other_med_start_dt, // Formatted: Y-m-d
									'dose_stop_dt'      => $other_med_stop_dt, // Formatted: Y-m-d
									'created_by'        => $user_id,
									'updated_by'        => $user_id
						    	)
						);
		            }
	            }

	            // ADR Three Months Medicine
	            if( isset($inputs['three_months_medicine']) ) {
		            foreach( $inputs['three_months_medicine'] as $medicine_name ) {
		            	DB::table('adr_three_months_medicine')->insert(
						    array(
									'adr_reporting_id' => $adr_report_id,
									'medicine_name'    => $medicine_name,
									'created_by'       => $user_id,
									'updated_by'       => $user_id
						    	)
						);
		            }
	            }

            }


            return redirect('complaints/adr/create')->with('successMsg', config('app_config.msg_save'));

        } catch (\Exception $e) {

            return redirect('complaints/adr/create')->with('dangerMsg', $e->getMessage());

        }

    }


    /**
     * AutoComplete
     * @param  string $table  Table name.
     * @param  string $select Field name to select.
     * @param  string $string String to search.
     * @return array          One dimensional array.
     * ---------------------------------------------------------------------
     */
    private function autocomplete($table, $select, $string) {
        // get original model
        $fetchMode = DB::getFetchMode();

        // set mode to fetch associative arrays instead of objects
        DB::setFetchMode(\PDO::FETCH_ASSOC);

        $fetched_data = DB::table($table)
                            ->select($select)
                            ->where($select, 'like', "%$string%")
                            ->limit(10)
                            ->get();

        // restore mode the original
        DB::setFetchMode($fetchMode);        

        $collection = collect($fetched_data);
        $collapsed  = $collection->flatten(); //flatten them to one dimensional array
        $values     = $collapsed->all();

        return $values;
    }


    /**
     * AutoComplete : Medicine Names
     * ---------------------------------------------------------------------
     */
    public function autoMedicineName(Request $request) {
        $search = $request->input('search');

        return $this->autocomplete( 'medicine', 'name', $search );
    }

    /**
     * AutoComplete : Medicine Generic
     * ---------------------------------------------------------------------
     */
    public function autoMedicineGeneric(Request $request) {
        $search = $request->input('search');

        return $this->autocomplete( 'cc_generic', 'name', $search );
    }

    /**
     * AutoComplete : Manufacturer
     * ---------------------------------------------------------------------
     */
    public function autoManufacturerName(Request $request) {
        $search = $request->input('search');

        return $this->autocomplete( 'manufacturer', 'name', $search );
    }
}
