<?php

namespace App\Model\User;

use Cache;
use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    protected $table = 'permissions';


    public function getPermissionData($module)
    {
        $value = Cache::remember('cache_all_permission_'.$module, config('app_config.cache_time_limit'), function () use ($module) {
            return $this->where('module', $module)
                ->orderBy('module', 'asc')
                ->orderBy('weight', 'asc')
                ->get();
        });

        return $value;
    }


}
