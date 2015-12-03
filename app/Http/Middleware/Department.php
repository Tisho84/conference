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
        $department = \App\Department::keyword($request->segment(2))->first();

        if (!$department) {
            return redirect('/' . LaravelLocalization::setLocale());
        }

        view()->share('department', $department);
        return $next($request);
    }
}
