<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;

class SentinelPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $permissionTag array/string
     * @return mixed
     */
    public function handle($request, Closure $next, $permissionTag)
    {
        if (is_array($permissionTag)) {
            if (Sentinel::hasAnyAccess($permissionTag)) {
                return $next($request);
            }
        } else if (Sentinel::hasAccess($permissionTag)) {
            return $next($request);
        }

        return response('Unauthorized. Access Deny !!!', 401);
    }
}
