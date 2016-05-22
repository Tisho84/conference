<?php

namespace App\Http\Middleware;

use App\News;
use Closure;

class AdminDepartmentObject
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param $object
     * @return mixed
     */
    public function handle($request, Closure $next, $object)
    {

        $objectId = $request->segment(4);
        $object = app()->make('App' . '\\' . $object);
        $object = $object->find($objectId);
        if (!systemAccess(100) && $object) {
            if ($object->department_id != $departmentId = auth()->user()->department_id) {
                return redirect()->route('admin-home')->with('error', 'access-denied');
            }
        }

        return $next($request);
    }
}
