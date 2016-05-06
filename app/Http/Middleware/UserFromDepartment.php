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
        if (isAdminPanel()) { #required for department admin and system admin check
            $id = $request->segment(4);
        } else {
            $department = app()->make('ConferenceBaseController')->getDepartment();
            $id = $department->id;
        }

        if (!auth()->guest() && $id != auth()->user()->department_id) { #if user is logged but not from that department logout him
            if (isAdminPanel()) {
                return redirect()->action('Admin\DepartmentController@index');
            }
            auth()->logout();
        }

        return $next($request);
    }
}
