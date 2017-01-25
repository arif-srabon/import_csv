<?php
namespace App\Model\Web;

use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ADRModel extends Model
{
	protected $table = 'adr_reporting';
  protected $dates = [
              'event_starting_dt',
              'event_stop_dt',
              'event_reporting_dt',
              'dose_start_dt',
              'dose_stop_dt',
              'effect_start_dt',
              'effect_end_dt',
              'outcome_fatal_dt'
            ];

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
        'status_id',
    ];


   /**
    * Changing Date Format for Insertion
    *
    * Changing human-readable date-format to a database-specific
    * date-format for insertion.
    *
    * @param string $date Human-readable date.
    * ---------------------------------------------------------------------
    */
   public function setEventStartingDtAttribute($date)
   {
       if (!empty($date)) {
           $this->attributes['event_starting_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
       } else {
           $this->attributes['event_starting_dt'] = (NULL);
       }
   }

   public function setEventStopDtAttribute($date)
   {
       if (!empty($date)) {
           $this->attributes['event_stop_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
       } else {
           $this->attributes['event_stop_dt'] = (NULL);
       }
   }

   public function setEventReportingDtAttribute($date)
   {
       if (!empty($date)) {
           $this->attributes['event_reporting_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
       } else {
           $this->attributes['event_reporting_dt'] = (NULL);
       }
   }

   public function setDoseStartDtAttribute($date)
   {
       if (!empty($date)) {
           $this->attributes['dose_start_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
       } else {
           $this->attributes['dose_start_dt'] = (NULL);
       }
   }

   public function setDoseStopDtAttribute($date)
   {
       if (!empty($date)) {
           $this->attributes['dose_stop_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
       } else {
           $this->attributes['dose_stop_dt'] = (NULL);
       }
   }

   public function setEffectStartDtAttribute($date)
   {
       if (!empty($date)) {
           $this->attributes['effect_start_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
       } else {
           $this->attributes['effect_start_dt'] = (NULL);
       }
   }

   public function setEffectEndDtAttribute($date)
   {
       if (!empty($date)) {
           $this->attributes['effect_end_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
       } else {
           $this->attributes['effect_end_dt'] = (NULL);
       }
   }

   public function setOutcomeFatalDtAttribute($date)
   {
       if (!empty($date)) {
           $this->attributes['outcome_fatal_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
       } else {
           $this->attributes['outcome_fatal_dt'] = (NULL);
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
   public function getEventStartingDtAttribute($date)
   {
       if (!empty($date)) {
           return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
       }
   }

   public function getEventStopDtAttribute($date)
   {
       if (!empty($date)) {
           return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
       }
   }

   public function getEventReportingDtAttribute($date)
   {
       if (!empty($date)) {
           return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
       }
   }

   public function getDoseStartDtAttribute($date)
   {
       if (!empty($date)) {
           return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
       }
   }

   public function getDoseStopDtAttribute($date)
   {
       if (!empty($date)) {
           return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
       }
   }

   public function getEffectStartDtAttribute($date)
   {
       if (!empty($date)) {
           return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
       }
   }

   public function getEffectEndDtAttribute($date)
   {
       if (!empty($date)) {
           return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
       }
   }

   public function getOutcomeFatalDtAttribute($date)
   {
       if (!empty($date)) {
           return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
       }
   }

}
