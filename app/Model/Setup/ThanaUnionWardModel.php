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

class ThanaUnionWardModel extends Model
{
    protected $table = 'union_wards';

    protected $fillable = [
        'division_id',
        'district_id',
        'thana_upazila_id',
        'union_ward_id',
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

    public function getAllWardByUpazillaList($upazilla_id)
    {
        $value = Cache::remember('cache_upzillaList_' . $upazilla_id, config('app_config.cache_time_limit'), function () use ($upazilla_id) {
            return $this->where('thana_upazila_id', $upazilla_id)
                ->orderBy('name', 'asc')->lists('name', 'id');
        });

        return $value;
    }
}