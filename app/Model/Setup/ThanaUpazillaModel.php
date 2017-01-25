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

class ThanaUpazillaModel extends Model
{
    protected $table = 'thana_upazilas';

    protected $fillable = [
        'division_id',
        'district_id',
        'geo_code',
        'name',
        'name_bn',
        'type'
    ];

    protected $attributes = [
        'created_by' => 1,
        'updated_by' => 2,
    ];

    public function District()
    {
        return $this->belongsTo('District');
    }

    public function getAllUpazillaByDistrictList($district_id, $lang = 'bn')
    {
        $value = Cache::remember('cache_upzillaList_'.$district_id.$lang, config('app_config.cache_time_limit'), function() use ($district_id,$lang) {
            $name = 'name';
            if ($lang == 'bn') {
                $name = 'name_bn';
            }
            return $this->where('district_id', $district_id)
                ->orderBy('name', 'asc')->lists($name, 'id');
        });

        return $value;
    }
}