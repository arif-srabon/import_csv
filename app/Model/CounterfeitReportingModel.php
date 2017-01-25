<?php
namespace App\Model;

use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CounterfeitReportingModel extends Model
{
    protected $table = 'counterfeit_reporting';
    protected $dates = ['submission_dt'];

    protected $fillable = [
        'submission_dt',
        'reported_by',
        'incident_details',
        'suspected_medicine',
        'generic_name',
        'manufacturer',
        'batch_lot',
        'license_number',
        'unique_number',
        'dose',
        'dose_form_id',
        'expiry_dt',
        'purchase_dt',
        'purchase_address',
        'district_id',
        'adverse_effects',
        'status_id',
        'advice_id',
    ];


    /**
     * Get all the Information about a Counterfeit Report
     *
     * Query the database table[s] and find the information necessary
     * to display the Counterfeit Reporting form.
     * 
     * @param  integer $id The Report ID.
     * @return object      Result Object.
     * ---------------------------------------------------------------------
     */
    public function getCounterfeitInfo( $id ) {

        $query = "SELECT
                    counterfeit_reporting.id,
                    DATE_FORMAT(
                        counterfeit_reporting.submission_dt,
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
                    counterfeit_reporting.incident_details,
                    counterfeit_reporting.suspected_medicine,
                    counterfeit_reporting.generic_name,
                    counterfeit_reporting.manufacturer,
                    counterfeit_reporting.batch_lot,
                    counterfeit_reporting.license_number,
                    counterfeit_reporting.unique_number,
                    counterfeit_reporting.dar_number,
                    counterfeit_reporting.dose,
                    cc_dose_form.name as dose_form,
                    DATE_FORMAT(
                        counterfeit_reporting.expiry_dt,
                        '%M %d, %Y'
                      ) AS expiry_dt,
                    DATE_FORMAT(
                        counterfeit_reporting.purchase_dt,
                        '%M %d, %Y'
                      ) AS purchase_dt,
                    counterfeit_reporting.purchase_address,
                    district2.name as purchase_district,
                    counterfeit_reporting.adverse_effects,
                    cc_adr_advice.name as advice,
                    cc_adr_status.name as status,
                    counterfeit_reporting.status_id as status_id
                FROM
                    counterfeit_reporting
                    LEFT JOIN users
                        ON counterfeit_reporting.reported_by = users.id
                    LEFT JOIN districts
                        ON users.district_id = districts.id
                    LEFT JOIN thana_upazilas
                        ON users.upazilla_id = thana_upazilas.id
                    LEFT JOIN union_wards
                        ON users.union_id = union_wards.id
                    LEFT JOIN districts AS district2
                        ON counterfeit_reporting.district_id = district2.id
                    LEFT JOIN cc_adr_status
                        ON counterfeit_reporting.status_id = cc_adr_status.id
                    LEFT JOIN cc_dose_form
                        ON counterfeit_reporting.dose_form_id = cc_dose_form.id
                    LEFT JOIN cc_adr_advice
                        ON counterfeit_reporting.advice_id = cc_adr_advice.id
                WHERE counterfeit_reporting.id = :COUNTERFEITREPORTING_ID";

        $results = DB::select( $query, ['COUNTERFEITREPORTING_ID' => $id] );
        return $results;

    }


    /**
     * Get all the Information about Counterfeit Medicine
     *
     * Query the database table `adr_concurrent_medicine` for medicine
     * names related to specific ADR Report.
     * 
     * @param  integer $id The Report ID.
     * @return object      Result Object.
     * ---------------------------------------------------------------------
     */
    public function getCounterfeitIncidentInfo( $id ) {

        $query = "SELECT
                    COUNTERFEIT.id,
                    counterfeit_incidents.incident_id,
                    cc_counterfeit_incident.name AS incident_label,
                    cc_counterfeit_incident.name_bn AS incident_label_bn
                FROM counterfeit_incidents
                    LEFT JOIN counterfeit_reporting AS COUNTERFEIT
                        ON counterfeit_incidents.counterfeit_reporting_id = COUNTERFEIT.id
                    LEFT JOIN cc_counterfeit_incident
                        ON cc_counterfeit_incident.id = counterfeit_incidents.incident_id
                WHERE COUNTERFEIT.id = :COUNTERFEITREPORTING_ID";

        $results = DB::select( $query, ['COUNTERFEITREPORTING_ID' => $id] );
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
