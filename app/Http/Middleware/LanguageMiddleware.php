<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use App;
use Closure;

class LanguageMiddleware
{
    protected $languages = ['en', 'bn'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('locale') && in_array(Session::get('locale'), $this->languages)) {
            App::setLocale(Session::get('locale'));
        }

        if (!Session::has('locale')) {
            Session::put('locale', config('app.locale'));
        }

        return $next($request);
    }
}
