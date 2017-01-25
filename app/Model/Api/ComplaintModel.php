<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;

class ComplaintModel extends Model
{
    protected $table = 'complaint';

    protected $fillable = [
        'submit_date',
        'complaint_details',
        'app_user_id',
		'is_read',
        'created_at',
        'updated_at',
        'is_read',
        'status_id'
    ];
}
