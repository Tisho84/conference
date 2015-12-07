<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Department
{
    public function __construct(Application $app, Request $request)
    {
        $this->app = $app;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!app()->make('ConferenceBaseController')->getDepartment()) {
            return redirect('/' . LaravelLocalization::setLocale());
        }

        return $next($request);
    }
}
