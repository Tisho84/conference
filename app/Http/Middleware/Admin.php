<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if (!Auth::user() || !Auth::user()->user_type_id || !in_array(9, Auth::user()->type->access->pluck('access_id')->toArray())) { #admin panel access id
            return redirect()->guest($request->segment(1) . '/admin/');
        }

        return $next($request);
    }
}
