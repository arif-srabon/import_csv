<?php
/**
 * Created by PhpStorm.
 * User: Kamrul
 * Date: 2/7/2016
 * Time: 4:47 PM
 */

namespace App\Model\Setup;

use Illuminate\Database\Eloquent\Model;

class CityCorpPaurasavaModel extends Model
{
    protected $table = 'city_corp_paurasavas';

    protected $fillable = [
        'division_id',
        'district_id',
        'thana_upazila_id',
        'geo_code',
        'name',
        'name_bn',
        'type'
    ];

    // todo: assign from user login session
    protected $attributes = [
        'created_by' => 1,
        'updated_by' => 2,
    ];

//    public function ThanaUpazilla()
//    {
//        return $this->hasMany('ThanaUpazilla');
//    }
}