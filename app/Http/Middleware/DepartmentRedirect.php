<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DepartmentRedirect
{
    public function __construct(Application $app, Request $request)
    {
        $this->app = $app;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $laravelLocale = LaravelLocalization::setLocale() ? : $this->app->config->get('app.fallback_locale');
        $locale = '/' . $laravelLocale;
        $departments = app()->make('ConferenceBaseController')->getDepartments();
        if (count($departments) == 1 && !$request->segment(2)) {
            return redirect($locale . '/' . $departments->first()['keyword']);
        }

        return $next($request);
    }
}
