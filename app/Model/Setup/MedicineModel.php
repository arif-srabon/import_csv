<?php

namespace App\Model\Setup;

use Illuminate\Database\Eloquent\Model;

class MedicineModel extends Model
{
    protected $table = 'medicine';

    protected $fillable = [
        'name',
        'code',
        'medicine_type_id',
        'generic_id',
        'price',
        'manufactuer_id',
        'medicine_image_path',
        'status',
        'presentation',
        'descriptions',
        'indications',
        'dosage_administration',
        'side_effects',
        'precaution',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
}
