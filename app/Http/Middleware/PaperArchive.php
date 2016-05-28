<?php

namespace App\Http\Middleware;

use App\Paper;
use Closure;

class PaperArchive
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
        $paper = Paper::findOrFail($request->segment(4));
        $params = [];
        if ($paper->archive_id) {
            session(['error' => 'access-denied']);
            if ($request->segment(2) == 'admin') {
                $route = 'admin-home';
            } else {
                $route = 'department::index';
                $params = [$request->segment(2)];
            }
            return redirect()->route($route, $params);

        }
        return $next($request);
    }
}
