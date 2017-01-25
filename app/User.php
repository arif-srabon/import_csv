<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

class User extends SentinelUser
{

    protected $fillable = [
        'email',
        'password',
        'full_name',
        'permissions',
        'official_email'
    ];

    protected $loginNames = ['email', 'official_email'];

}
