<?php

namespace App\Model\Trans;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class RegistrationModel extends Model
{
    protected $table = 'registration';
    protected $fillable = [
        'department_id',
        'client_id',
        'registration_date',
        'client_name',
        'client_name_bn',
        'mobile',
        'email',
        'date_of_birth',
        'gender_id',
        'marital_status_id',
        'birth_certificate_no',
        'father_name',
        'father_phone',
        'mother_name',
        'mother_phone',
        'guardian_name',
        'guardian_phone',
        'religion_id',
        'national_id_type',
        'national_id',
        'status',
        'house_no',
        'village',
        'division_id',
        'district_id',
        'upazilla_id',
        'ward',
        'post_code',
        'present_address',
        'client_photo',
    ];

    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes(array(
            'created_by' => Session::get('sess_user_id'),
            'updated_by' => Session::get('sess_user_id'),
        ), true);
        parent::__construct($attributes);
    }

    protected $dates = ['registration_date', 'date_of_birth'];

    public function setRegistrationDateAttribute($date)
    {
        $this->attributes['registration_date'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
    }

    public function setDateOfBirthAttribute($date)
    {
        $this->attributes['date_of_birth'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
    }



    public function getDateOfBirthAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
    }

    public function getRegistrationDateAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
    }
}
