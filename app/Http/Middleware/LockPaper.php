<?php

namespace App\Http\Middleware;

use App\Department;
use Closure;

class LockPaper
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $department)
    {
        $department = Department::findOrFail($department);
        $lock = $department->settings()->key('papers');
        if (isset($lock->value) && $lock->value) {
            return redirect()->back()->with('error', 'lock-papers');
        }

        return $next($request);
    }
}
