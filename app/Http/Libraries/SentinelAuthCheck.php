<?php namespace App\Http\Libraries;


use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SentinelAuthCheck
{
    public static function check($permissionTag)
    {
        if (is_array($permissionTag)) {
            if (Sentinel::hasAnyAccess($permissionTag)) {
                return true;
            }
        } else if (Sentinel::hasAccess($permissionTag)) {
            return true;
        }

        return false;
    }
}