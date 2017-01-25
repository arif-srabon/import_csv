<?php

namespace App\Model\Trans;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MedicinecodeModel extends Model
{

    protected $table = 'medicine_code_info';

    protected $fillable = [
        'medicine_id',
        'batch_lot_no',
        'generate_date',
        'total_codes',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['generate_date'];

    public function setGenerateDateAttribute($date)
    {
        if (!empty($date)) {
            $this->attributes['generate_date'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } else {
            $this->attributes['generate_date'] = (NULL);
        }
    }

    public function getGenerateDateAttribute($date)
    {
        if (!empty($date)) {
            return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
        }
    }

}
