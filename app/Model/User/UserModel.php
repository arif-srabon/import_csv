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
        'name_title',
        'full_name',
        'department_id',
        'designation_id',
        'official_email',
        'manufacturer_id',
        'user_photo',
        'mobile',
        'national_id',
        'address',
        'office_phone',
        'profession',
        'division_id',
        'district_id',
        'upazilla_id',
        'union_id',
        'postcode',
        'home_phone',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];


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

}
