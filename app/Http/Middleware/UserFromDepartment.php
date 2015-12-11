<?php

namespace App\Http\Middleware;

use Closure;

class UserFromDepartment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $department = app()->make('ConferenceBaseController')->getDepartment();

        if (!auth()->guest() && $department->id != auth()->user()->department_id) { #if user is logged but not from that department logout him
            auth()->logout();
        }

        return $next($request);
    }
}
