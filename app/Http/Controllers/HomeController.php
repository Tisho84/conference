<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HomeController extends Controller
{
    public function __construct(Application $app, Request $request)
    {
        $this->app = $app;
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Session::has('departments')) {
            $departments = Session::pull('departments');
        } else {
            $departments = Department::active()
                ->sort()
                ->get();
        }

        $departments->load(['langs' => function ($query) {
            $query->lang(dbTrans());
        }]);

        return view('departments', [
            'departments' => $departments,
            'locales' => LaravelLocalization::getSupportedLocales()
        ]);
    }
}
