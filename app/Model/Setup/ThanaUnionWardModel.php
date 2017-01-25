<?php
/**
 * Created by PhpStorm.
 * User: Kamrul
 * Date: 2/7/2016
 * Time: 4:47 PM
 */

namespace App\Model\Setup;

use Illuminate\Database\Eloquent\Model;

class ThanaUnionWardModel extends Model
{
    protected $table = 'wards';

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
}