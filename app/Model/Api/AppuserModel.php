<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;

class AppuserModel extends Model
{
    protected $table = 'app_users';

    protected $fillable = [
        'name',
        'nid',
        'address',
        'phone',
        'email',
        'profession',
        'division_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

}
