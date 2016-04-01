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
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!systemAccess(10)) {
            return redirect()
                ->route('admin-home')
                ->withErrors(trans('messages.access-denied'));
        }

        return $next($request);
    }
}
