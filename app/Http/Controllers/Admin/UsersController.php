<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Country;
use App\Classes\Rank;
use App\Events\ReviewerPaperSet;
use App\Http\Controllers\ConferenceBaseController;
use App\Paper;
use App\User;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends ConferenceBaseController
{
    public function __construct()
    {
        $this->middleware('departmentAccess:5');
        $this->middleware('adminDepartmentObject:User', ['only' => ['edit', 'update', 'delete']]);

        $departments = [];
        $this->systemAdmin = false;
        if (systemAccess(100)) {
            $this->systemAdmin = true;
            $departments = getNomenclatureSelect($this->getDepartmentsAdmin(), true);
        }
        view()->share([
            'systemAdmin' => $this->systemAdmin,
            'departments' => $departments,
            'types' => simpleSelect($this->getUserTypes(true), true, 'title'),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('type.access');
        if (!$this->systemAdmin) {
            $users->where('department_id', auth()->user()->department_id);
        }

        if (session('department_filter_id')) {
            $users->where('department_id', session('department_filter_id'));
        }

        if (request()->get('paper_id')) {
            $users->whereHas('requests', function($query) {
                $query->where('paper_id', request()->get('paper_id'));
            });
        }

        $users = $users->get();

        return view('admin.user.index', [
            'title' => trans('admin.users'),
            'url' => action('Admin\UsersController@create'),
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Classes\Rank $rank,
     * @param \App\Classes\Country $country,
     * @return \Illuminate\Http\Response
     */
    public function create(Rank $rank, Country $country)
    {
        return view('admin.user.create', [
            'ranks' => $rank->getRanks(),
            'countries' => $country->getCountries(),
            'reviewer' => 1,
            'categories' => $this->systemAdmin ? [] : getNomenclatureSelect($this->getCategories(auth()->user()->department_id)),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DepartmentUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\DepartmentUserRequest $request)
    {
        $user = User::create([
            'rank_id' => $request->get('rank_id'),
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'institution' => $request->get('institution'),
            'country_id' => $request->get('country_id'),
            'email' => $request->get('email'),
            'email2' => $request->get('email2'),
            'password' => bcrypt($request->get('password')),
            'department_id' => $this->systemAdmin ? $request->get('department_id') : auth()->user()->department_id,
            'user_type_id' => $request->get('user_type_id'),
            'is_reviewer' => count((array)$request->get('categories')) ? 1 : 0,
            'active' => $request->get('active')
        ]);

        if (systemAccess(2, $user)) {
            $user->categories()->attach((array)$request->get('categories'));
        }

        return redirect()->action('Admin\UsersController@index')->with('success', 'saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @param \App\Classes\Rank $rank,
     * @param \App\Classes\Country $country,
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Rank $rank, Country $country)
    {
        $user->load('categories');
        return view('admin.user.edit', [
            'user' => $user,
            'ranks' => $rank->getRanks(),
            'countries' => $country->getCountries(),
            'reviewer' => 1,
            'selectedCategories' => $user->categories->lists('id')->toArray(),
            'categories' => getNomenclatureSelect($this->getCategories($user->department_id)),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DepartmentUserRequest $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\DepartmentUserRequest $request, User $user)
    {
        $data = [
            'rank_id' => $request->get('rank_id'),
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'institution' => $request->get('institution'),
            'country_id' => $request->get('country_id'),
            'email' => $request->get('email'),
            'email2' => $request->get('email2'),
            'department_id' => $this->systemAdmin ? $request->get('department_id') : auth()->user()->department_id,
            'user_type_id' => $request->get('user_type_id'),
            'is_reviewer' => count((array)$request->get('categories')) ? 1 : 0,
            'active' => $request->get('active')
        ];

        if ($request->get('password')) {
            $data['password'] = bcrypt($request->get('password'));
        }

        $user->update($data);

        if (systemAccess(2, $user)) {
            $user->categories()->sync((array)$request->get('categories'));
        } else {
            $user->categories()->detach();
        }

        return redirect()->action('Admin\UsersController@index')->with('success', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (systemAccess(100, $user)) {
            return redirect()->back()->with('error', 'admin-delete');
        }

        try {
            $user->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'error-user-paper');
        }
        return redirect()->action('Admin\UsersController@index')->with('success', 'deleted');
    }

    public function paper($user, $paper)
    {
        $user = User::findOrFail($user);
        $paper = Paper::findOrFail($paper);
        if (count($user->requests()->where('paper_id', $paper->id)->get())) {
            $data = ['reviewer_id' => $user->id];
            if ($paper->status_id < 2) {
                $data['status_id'] = 2;
            }
            $paper->update($data);
            event(new ReviewerPaperSet($paper));

            return redirect()->action('Admin\PaperController@index')->with('success', 'reviewer-set');
        }

        return redirect()->action('Admin\UsersController@index')->with('error', 'access-denied');
    }
}
