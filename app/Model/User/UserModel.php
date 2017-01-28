<?php namespace App\Model\User;

use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Session;

class UserModel extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'email',
        'full_name',
        'full_name_bn',
        'designation_id',
        'department_id',
        'official_email',
        'office_phone',


        'father_name',
        'mother_name',
        'mobile',
        'home_phone',
        'national_id',
        'gender_id',
        'marital_status_id',
        'blood_group',
        'date_of_birth',
        'date_of_joining',

        'user_photo',
        'user_sign',

        "permanent_house_road",
        "permanent_village",
        "permanent_division",
        "permanent_district",
        "permanent_upzilla",
        "permanent_ward",
        "permanent_postcode",

        "present_house_road",
        "present_village",
        "present_division",
        "present_district",
        "present_upzilla",
        "present_ward",
        "present_postcode",

        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['date_of_joining', 'date_of_birth'];
    /**
     * Get the roles for the user
     */
    public function roles()
    {
        return $this->belongsToMany('App\Model\User\RoleModel', 'role_users', 'user_id', 'role_id')->withTimestamps();
    }

    /**
     * get the list of role ids associated with the current user
     *
     * @return array
     */
    public function getAssignedRolesListAttribute()
    {
        return $this->roles->lists('id');
    }


    public function setDateOfBirthAttribute($date)
    {
        if (!empty($date)) {
            $this->attributes['date_of_birth'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } else {
            $this->attributes['date_of_birth'] = (NULL);
        }
    }

    public function setDateOfJoiningAttribute($date)
    {
        if (!empty($date)) {
            $this->attributes['date_of_joining'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } else {
            $this->attributes['date_of_joining'] = (NULL);
        }
    }

    public function getDateOfBirthAttribute($date)
    {
        if (!empty($date)) {
            return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
        }
    }

    public function getDateOfJoiningAttribute($date)
    {
        if (!empty($date)) {
            return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
        }
    }
}
