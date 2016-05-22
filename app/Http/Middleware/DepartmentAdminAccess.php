<?php

namespace App\Http\Middleware;

use Closure;

class DepartmentAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param $access
     * @return mixed
     */
    public function handle($request, Closure $next, $access)
    {
        if (!systemAccess((int)$access)) {
            return redirect()->route('admin-home')->with('error', 'access-denied');
        }

        return $next($request);
    }
}
