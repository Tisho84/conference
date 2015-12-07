<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HomeController extends ConferenceBaseController
{
    public function __construct(Application $app, Request $request)
    {
        $this->app = $app;
        $this->request = $request;
    }

    /**
     * System home page all departments
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('conference.index', [
            'departments' => $this->getDepartments(),
        ]);
    }

    /**
     * Department home page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function department()
    {
        return view('conference.department');
    }
}
