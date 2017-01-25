<?php namespace App\Model\User;

use Cache;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $table = 'roles';

    protected $fillable = ['slug', 'name', 'permissions'];

    /**
     * Get the post that owns the comment.
     */
    public function user()
    {
        return $this->belongsToMany('App\Model\User\UserModel', 'role_users', 'role_id', 'user_id')->withTimestamps();
    }


    public function getAllList()
    {
        $value = Cache::remember('cache_roleList', config('app_config.cache_time_limit'), function() {
            return $this->orderBy('name', 'asc')->lists('name', 'id');
        });

        return $value;
    }

}
