<?php
/**
 * Created by PhpStorm.
 * User: Kamrul
 * Date: 2/7/2016
 * Time: 4:47 PM
 */

namespace App\Model\Setup;

use Cache;
use Illuminate\Database\Eloquent\Model;

class DistrictModel extends Model
{
    protected $table = 'districts';

    protected $fillable = [
        'division_id',
        'geo_code',
        'name',
        'name_bn'
    ];

    // todo: assign from user login session
    protected $attributes = [
        'created_by' => 1,
        'updated_by' => 2,
    ];

    public function ThanaUpazilla()
    {
        return $this->hasMany('ThanaUpazilla');
    }

    public function getAllDistrictByDivisionList($division_id, $lang = 'bn')
    {
        $value = Cache::remember('cache_districtList_' . $division_id.$lang, config('app_config.cache_time_limit'), function () use ($division_id,$lang) {

            $name = 'name';
            if ($lang == 'bn') {
                $name = 'name_bn';
            }
            return $this->where('division_id', $division_id)
                ->orderBy('name', 'asc')->lists($name, 'id');
        });

        return $value;
    }


    public function getAllDistrictList($lang = 'bn')
    {
        $value = Cache::remember('cache_alldistrictList_' . $lang, config('app_config.cache_time_limit'), function () use ($lang) {
            if ($lang == 'bn') {
                return $this->orderBy('name_bn', 'asc')->lists('name_bn', 'id');
            } else {
                return $this->orderBy('name', 'asc')->lists('name', 'id');
            }
        });

        return $value;
    }


}