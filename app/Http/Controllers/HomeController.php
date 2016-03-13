<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests;
use App\User;
use App\UserType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HomeController extends ConferenceBaseController
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

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

    public function getLogin()
    {
        return view('admin.auth.login');
    }

    public function postLogin()
    {
        $request = $this->request;
        $this->validate($request, [
            'email' => 'required', 'password' => 'required',
        ]);

        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        if (Auth::attempt($this->getCredentials($request))) {
            if (auth()->user()->user_type_id && in_array(9, auth()->user()->type->access->pluck('access_id')->toArray())) { #admin panel access id
                Session::flash('success', 'login');
                return $this->handleUserWasAuthenticated($request, $throttles);
            } else {
                auth()->logout();
            }
        }

        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect(route('admin-index'))
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans('admin.admin-login-failed')]);
    }

    public function authenticated($request, $user)
    {
        return redirect()->route('admin-home');
    }

    public function admin()
    {
        return view('admin.master');
    }
}
