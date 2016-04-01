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
        if (!systemAccess(100)) {
            session(['error' => 'access-denied']);
            return redirect()->route('admin-home');
        }
        return $next($request);
    }
}
