<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HomeController extends ConferenceBaseController
{
    public function __construct(Application $app, Request $request)
    {
//        $this->middleware('department', ['except' => ['department']]);
        $this->app = $app;
        $this->request = $request;
    }

    /**
     * System home page
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
            $query->lang();
        }]);

        return view('conference.index', [
            'departments' => $departments,
        ]);
    }

    public function department()
    {
        $department = $this->getDepartment();
        return view('conference.department');
//        dd($this->getDepartment());
    }
}
