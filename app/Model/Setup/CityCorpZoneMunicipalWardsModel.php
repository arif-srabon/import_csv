<?php

/**
 * Created by PhpStorm.
 * User: Shakhawat
 * Date: 25/02/2016
 * Time: 10:54 AM
 */

namespace App\Model\Setup;

use Illuminate\Database\Eloquent\Model;

class CityCorpZoneMunicipalWardsModel extends Model
{
    protected $table = 'city_corp_zone_municipal_wards';

    protected $fillable = [
        'id',
        'city_corp_zone_id',
        'union_ward_id'
    ];

    protected $attributes = [
        'created_by' => 1,
        'updated_by' => 2,
    ];


}
