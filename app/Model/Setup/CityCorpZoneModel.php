<?php

/**
 * Created by PhpStorm.
 * User: Shakhawat
 * Date: 25/02/2016
 * Time: 10:54 AM
 */

namespace App\Model\Setup;

use Illuminate\Database\Eloquent\Model;

class CityCorpZoneModel extends Model
{
    protected $table = 'city_corp_zones';

    protected $fillable = [
        'id',
        'zone_name',
        'zone_name_bn',
        'city_corp_paurasava_id'
    ];

    protected $attributes = [
        'created_by' => 1,
        'updated_by' => 2,
    ];


}
