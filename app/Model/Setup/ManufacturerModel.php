<?php
namespace App\Model\Setup;

use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ManufacturerModel extends Model
{
    protected $table = 'manufacturer';
    protected $dates = ['registration_dt'];

    protected $fillable = [
        'code',
        'code_non_bio',
        'name',
        'name_bn',
        'division_id',
        'district_id',
        'address',
        'registration_dt',
        'status'
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
   public function setRegistrationDtAttribute($date)
   {
       if (!empty($date)) {
           $this->attributes['registration_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
       } else {
           $this->attributes['registration_dt'] = (NULL);
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
   public function getRegistrationDtAttribute($date)
   {
       if (!empty($date)) {
           return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
       }
   }

}
