<?php
namespace App\Model\Web;

use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CounterfeitModel extends Model
{
	protected $table = 'counterfeit_reporting';

	protected $fillable = [
        'incident_details',
        'suspected_medicine',
        'generic_name',
        'manufacturer',
        'batch_lot',
        'dose',
        'dose_form_id',
        'license_number',
        'unique_number',
        'dar_number',
        'purchase_address',
        'district_id',
        'purchase_dt',
        'expiry_dt',
        'adverse_effects',
        'submission_dt',
        'reported_by',
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
     public function setPurchaseDtAttribute($date)
     {
         if (!empty($date)) {
             $this->attributes['purchase_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
         } else {
             $this->attributes['purchase_dt'] = (NULL);
         }
     }

     public function setExpiryDtAttribute($date)
     {
         if (!empty($date)) {
             $this->attributes['expiry_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
         } else {
             $this->attributes['expiry_dt'] = (NULL);
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
     public function getPurchaseDtAttribute($date)
     {
         if (!empty($date)) {
             return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
         }
     }

     public function getExpiryDtAttribute($date)
     {
         if (!empty($date)) {
             return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
         }
     }

}
