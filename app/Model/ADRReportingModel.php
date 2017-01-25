<?php
namespace App\Model;

use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ADRReportingModel extends Model
{
    protected $table = 'adr_reporting';
    protected $dates = ['submission_dt'];

    protected $fillable = [
        'submission_dt',
        'reported_by',
        'experienced_by',
        'patient_name',
        'patient_gender',
        'patient_age',
        'patient_age_unit_id',
        'patient_weight',
        'patient_weight_unit_id',
        'patient_height',
        'patient_height_unit_id',
        'hospital',
        'reference_number',
        'event_starting_dt',
        'event_stop_dt',
        'event_reporting_dt',
        'is_treated',
        'treatment_specification',
        'suspected_medicine',
        'generic_name',
        'manufacturer',
        'batch_lot',
        'dose_start_dt',
        'dose_stop_dt',
        'dose',
        'dose_form_id',
        'dose_frequency_id',
        'route_id',
        'medicine_reason',
        'action_after_reaction_id',
        'lab_test_result',
        'adverse_effects',
        'effect_start_dt',
        'effect_end_dt',
        'outcome_fatal_dt',
        'other_history',
        'is_medicine_three_months',
        'miscellaneous_info',
        'is_doctor_told',
        'is_doctor',
        'doctor_name',
        'doctor_hospital',
        'doctor_address',
        'doctor_district_id',
        'doctor_postcode',
        'advice_id',
        'status_id'
    ];


    /**
     * Get all the Information about an ADR Report
     *
     * Query the database table[s] and find the information necessary
     * to display the ADR Reporting form.
     * 
     * @param  integer $id The Report ID.
     * @return object      Result Object.
     * ---------------------------------------------------------------------
     */
    public function getADRReportingInfo( $id ) {

        $query = "SELECT
                    adr_reporting.id,
                    DATE_FORMAT(
                        adr_reporting.submission_dt,
                        '%M %d, %Y'
                      ) AS submission_dt,
                    users.name_title,
                    users.full_name as reporter_name,
                    users.profession as reporter_profession,
                    users.mobile as reporter_mobile,
                    users.email as reporter_email,
                    users.address as reporter_address,
                    users.postcode as reporter_postcode,
                    districts.name as reporter_district,
                    thana_upazilas.name as reporter_upazila,
                    union_wards.name as reporter_union,
                    adr_reporting.experienced_by,
                    adr_reporting.patient_name,
                    adr_reporting.patient_gender,
                    adr_reporting.patient_age,
                    cc_age_unit.name as patient_age_unit,
                    adr_reporting.patient_weight,
                    cc_weight_unit.name as patient_weight_unit,
                    adr_reporting.patient_height,
                    cc_height_unit.name as patient_height_unit,
                    adr_reporting.hospital,
                    adr_reporting.reference_number,
                    DATE_FORMAT(
                        adr_reporting.event_starting_dt,
                        '%M %d, %Y'
                      ) AS event_starting_dt,
                    DATE_FORMAT(
                        adr_reporting.event_stop_dt,
                        '%M %d, %Y'
                      ) AS event_stop_dt,
                    DATE_FORMAT(
                        adr_reporting.event_reporting_dt,
                        '%M %d, %Y'
                      ) AS event_reporting_dt,
                    adr_reporting.is_treated,
                    adr_reporting.treatment_specification,
                    adr_reporting.suspected_medicine,
                    adr_reporting.generic_name,
                    adr_reporting.manufacturer,
                    adr_reporting.batch_lot,
                    DATE_FORMAT(
                        adr_reporting.dose_start_dt,
                        '%M %d, %Y'
                      ) AS dose_start_dt,
                    DATE_FORMAT(
                        adr_reporting.dose_stop_dt,
                        '%M %d, %Y'
                      ) AS dose_stop_dt,
                    adr_reporting.dose,
                    cc_dose_form.name as dose_form,
                    cc_dose_frequency.name as dose_frequency,
                    cc_dose_route.name as dose_route,
                    adr_reporting.medicine_reason,
                    cc_reaction_after_action.name as action_after_reaction,
                    adr_reporting.lab_test_result,
                    adr_reporting.adverse_effects,
                    DATE_FORMAT(
                        adr_reporting.effect_start_dt,
                        '%M %d, %Y'
                      ) AS effect_start_dt,
                    DATE_FORMAT(
                        adr_reporting.effect_end_dt,
                        '%M %d, %Y'
                      ) AS effect_end_dt,
                    DATE_FORMAT(
                        adr_reporting.outcome_fatal_dt,
                        '%M %d, %Y'
                      ) AS outcome_fatal_dt,
                    adr_reporting.other_history,
                    adr_reporting.is_medicine_three_months,
                    adr_reporting.miscellaneous_info,
                    adr_reporting.is_doctor_told,
                    adr_reporting.is_doctor,
                    adr_reporting.miscellaneous_info,
                    adr_reporting.doctor_name,
                    adr_reporting.doctor_hospital,
                    adr_reporting.doctor_address,
                    district2.name as doctor_district,
                    adr_reporting.doctor_postcode,
                    cc_adr_advice.name as advice,
                    cc_adr_status.name as status
                FROM
                    adr_reporting
                    LEFT JOIN users
                        ON adr_reporting.reported_by = users.id
                    LEFT JOIN districts
                        ON users.district_id = districts.id
                    LEFT JOIN thana_upazilas
                        ON users.upazilla_id = thana_upazilas.id
                    LEFT JOIN union_wards
                        ON users.union_id = union_wards.id
                    LEFT JOIN cc_adr_status
                        ON adr_reporting.status_id = cc_adr_status.id
                    LEFT JOIN cc_age_unit
                        ON adr_reporting.patient_age_unit_id = cc_age_unit.id
                    LEFT JOIN cc_weight_unit
                        ON adr_reporting.patient_weight_unit_id = cc_weight_unit.id
                    LEFT JOIN cc_height_unit
                        ON adr_reporting.patient_height_unit_id = cc_height_unit.id
                    LEFT JOIN cc_dose_form
                        ON adr_reporting.dose_form_id = cc_dose_form.id
                    LEFT JOIN cc_dose_frequency
                        ON adr_reporting.dose_frequency_id = cc_dose_frequency.id
                    LEFT JOIN cc_dose_route
                        ON adr_reporting.route_id = cc_dose_route.id
                    LEFT JOIN cc_reaction_after_action
                        ON adr_reporting.action_after_reaction_id = cc_reaction_after_action.id
                    LEFT JOIN districts AS district2
                        ON adr_reporting.doctor_district_id = district2.id
                    LEFT JOIN cc_adr_advice
                        ON adr_reporting.advice_id = cc_adr_advice.id
                WHERE adr_reporting.id = :ADRREPORTING_ID";

        $results = DB::select( $query, ['ADRREPORTING_ID' => $id] );
        return $results;

    }


    /**
     * Get all the Information about Concurrent Medicine
     *
     * Query the database table `adr_concurrent_medicine` for medicine
     * names related to specific ADR Report.
     * 
     * @param  integer $id The Report ID.
     * @return object      Result Object.
     * ---------------------------------------------------------------------
     */
    public function getConcurrentMedicineInfo( $id ) {

        $query = "SELECT
                    ACM.brand_name,
                    ACM.generic,
                    ACM.indication,
                    ACM.dose,
                    cc_dose_form.name as dose_form,
                    cc_dose_route.name as dose_route,
                    cc_dose_frequency.name as dose_frequency,
                    DATE_FORMAT(
                        ACM.dose_start_dt,
                        '%M %d, %Y'
                      ) AS dose_start_dt,
                    DATE_FORMAT(
                        ACM.dose_stop_dt,
                        '%M %d, %Y'
                      ) AS dose_stop_dt
                FROM adr_concurrent_medicine AS ACM
                    INNER JOIN adr_reporting
                        ON adr_reporting.id = ACM.adr_reporting_id
                    LEFT JOIN cc_dose_form
                        ON ACM.dose_form_id = cc_dose_form.id
                    LEFT JOIN cc_dose_frequency
                        ON ACM.dose_frequency_id = cc_dose_frequency.id
                    LEFT JOIN cc_dose_route
                        ON ACM.route_id = cc_dose_route.id
                WHERE adr_reporting.id = :ADRREPORTING_ID";

        $results = DB::select( $query, ['ADRREPORTING_ID' => $id] );
        return $results;

    }


    /**
     * Get all the Information about Seriousness of the Adverse Effect
     *
     * Query the database table `adr_adverse_events` for seriousness
     * names related to specific ADR Report.
     * 
     * @param  integer $id The Report ID.
     * @return object      Result Object.
     * ---------------------------------------------------------------------
     */
    public function getAdverseEffectSeriousness( $id ) {

        $query = "SELECT
                    ADR.id,
                    ADV.event_id,
                    ADV.event_type,
                    SERIOUSNESS.name AS seriousness_label,
                    SERIOUSNESS.name_bn AS seriousness_label_bn
                FROM adr_adverse_events AS ADV
                    LEFT JOIN adr_reporting AS ADR
                        ON ADV.adr_reporting_id = ADR.id
                    LEFT JOIN cc_adr_seriousness AS SERIOUSNESS
                        ON SERIOUSNESS.id = ADV.event_id
                WHERE ADV.event_type = 'seriousness'
                    AND ADR.id = :ADRREPORTING_ID";

        $results = DB::select( $query, ['ADRREPORTING_ID' => $id] );
        return $results;

    }


    /**
     * Get all the Information about Outcome of the Adverse Effect
     *
     * Query the database table `adr_adverse_events` for outcome
     * names related to specific ADR Report.
     * 
     * @param  integer $id The Report ID.
     * @return object      Result Object.
     * ---------------------------------------------------------------------
     */
    public function getAdverseEffectOutcome( $id ) {

        $query = "SELECT
                    ADR.id,
                    ADV.event_id,
                    ADV.event_type,
                    OUTCOME.name AS outcome_label,
                    OUTCOME.name_bn AS outcome_label_bn
                FROM adr_adverse_events AS ADV
                    LEFT JOIN adr_reporting AS ADR
                        ON ADV.adr_reporting_id = ADR.id
                    LEFT JOIN cc_adr_outcome AS OUTCOME
                        ON OUTCOME.id = ADV.event_id
                WHERE ADV.event_type = 'outcome'
                    AND ADR.id = :ADRREPORTING_ID";

        $results = DB::select( $query, ['ADRREPORTING_ID' => $id] );
        return $results;

    }



    /**
     * Get all the Information about 3 Months' Medicine
     *
     * Query the database table `adr_three_months_medicine` for medicine
     * names related to specific ADR Report.
     * 
     * @param  integer $id The Report ID.
     * @return object      Result Object.
     * ---------------------------------------------------------------------
     */
    public function getThreeMonthsMedicineInfo( $id ) {

        $query = "SELECT
                    adr_three_months_medicine.id,
                    adr_three_months_medicine.medicine_name
                FROM adr_three_months_medicine
                    INNER JOIN adr_reporting
                        ON adr_reporting.id = adr_three_months_medicine.adr_reporting_id
                WHERE adr_reporting.id = :ADRREPORTING_ID";

        $results = DB::select( $query, ['ADRREPORTING_ID' => $id] );
        return $results;

    }


    /**
     * Changing Date Format for Insertion
     * 
     * Changing human-readable date-format to a database-specific
     * date-format for insertion.
     * 
     * @param string $date Human-readable date.
     * ---------------------------------------------------------------------
     */
    public function setSubmissionDtAttribute($date)
    {
        if (!empty($date)) {
            $this->attributes['submission_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } else {
            $this->attributes['submission_dt'] = (NULL);
        }
    }


    /**
     * Changing Date Format for Output
     * 
     * Changing database-specific date-format to a human-readable
     * date-format for output.
     * 
     * @param string $date Human-readable date.
     * ---------------------------------------------------------------------
     */
    public function getSubmissionDtAttribute($date)
    {
        if (!empty($date)) {
            return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
        }
    }

}
