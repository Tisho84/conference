<?php

namespace App\Http\Middleware;

use Closure;

class SystemAdminAccess
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
        if (!adminAccess(100)) {
            return redirect()
                ->route('admin-home')
                ->withErrors(trans('messages.access-denied'));
        }
        return $next($request);
    }
}
