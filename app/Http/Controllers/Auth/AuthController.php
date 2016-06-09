<?php

namespace App\Http\Controllers\Auth;

use App\Category;
use App\Classes\Country;
use App\Classes\Rank;
use App\Department;
use App\Http\Controllers\ConferenceBaseController;
use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends ConferenceBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectAfterLogout;
    protected $loginPath;
    protected $redirectPath;

    public function __construct()
    {
        $url = app()->request->segment(1) . '/' . app()->request->segment(2);
        $this->redirectAfterLogout = $url;
        $this->loginPath = $url . '/auth/login';
        $this->redirectPath = $url;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        $rank = new Rank();
        $country = new Country();
        return Validator::make($data, [
            'rank_id' => 'in:' . implode(',', array_keys($rank->getRanks())),
            'name' => 'required|max:255|min:4',
            'phone' => 'max:30|min:5|regex:' . config('auth.expressions.phone'),
            'address' => 'required|max:255|min:4',
            'institution' => 'required|max:100|min:4',
            'country_id' => 'required|in:' . implode(',', array_keys($country->getCountries())),
            'email' => 'required|email|max:255|unique:users,email,NULL,id,department_id,' . $this->getDepartment()->id,
            'email2' => 'email|max:255',
            'password' => 'required|confirmed|min:6',
            'categories' => request('reviewer') ? 'required|exists:category,id' : ''
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        Session::flash('success', 'registered');
        $user = User::create([
            'rank_id' => $data['rank_id'],
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'institution' => $data['institution'],
            'country_id' => $data['country_id'],
            'email' => $data['email'],
            'email2' => $data['email2'],
            'password' => bcrypt($data['password']),
            'department_id' => $this->getDepartment()->id,
            'user_type_id' => request('reviewer') ? 2 : 1,
            'is_reviewer' => request('reviewer') ? 1 : 0,
            'active' => request('reviewer') ? 0 : 1, #reviewer is not active on registration
        ]);

        if (request('reviewer')) {
            $user->categories()->attach($data['categories']);
        }

        return $user;
    }


    public function postLogin()
    {
        $request = request();
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);
        $credentialsSecond = [
            'email2' => $credentials['email'],
            'password' => $credentials['password'],
        ];
        if (Auth::attempt($credentials, $request->has('remember')) || Auth::attempt($credentialsSecond, $request->has('remember'))) {
            if (auth()->user()->department_id != $this->getDepartment()->id) { #user is not from this department
                auth()->logout();
            } else {
                Session::flash('success', 'login');
                return $this->handleUserWasAuthenticated($request, $throttles);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    public function getLogout()
    {
        Session::flash('success', 'logout');
        Auth::logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    public function getRegister(Rank $rank, Country $country)
    {
        $lock = $this->getDepartment()->settings()->key('registrations');
        if (isset($lock->value) && $lock->value) {
            return redirect()->back()->with('error', 'lock-registrations');
        }

        return view('auth.register', [
            'ranks' => $rank->getRanks(),
            'countries' => $country->getCountries(),
            'categories' => getNomenclatureSelect($this->getCategories())
        ]);
    }
}
