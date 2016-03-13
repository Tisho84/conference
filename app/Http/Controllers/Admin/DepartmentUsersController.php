<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Country;
use App\Classes\Rank;
use App\Department;
use App\Http\Controllers\ConferenceBaseController;
use App\Http\Controllers\UsersController;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DepartmentUsersController extends ConferenceBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Department $department
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        return view('admin.department_users.index', [
            'title' => $department->keyword . ' ' . trans('admin.users'),
            'url' => action('Admin\DepartmentUsersController@create', [ $department->id ]),
            'department' => $department,
            'types' => $this->getUserTypes(true)->pluck('title', 'id')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param \App\Department $department,
     * @param \App\Classes\Rank $rank,
     * @param \App\Classes\Country $country,
     * @return \Illuminate\Http\Response
     */
    public function create(Department $department, Rank $rank, Country $country)
    {
        return view('admin.department_users.create', [
            'department' => $department,
            'ranks' => $rank->getRanks(),
            'countries' => $country->getCountries(),
            'reviewer' => 1,
            'categories' => getNomenclatureSelect($department->categories()),
            'types' => $this->getUserTypes(true)->pluck('title', 'id')
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Department $department
     * @param  User  $user
     * @param \App\Classes\Rank $rank,
     * @param \App\Classes\Country $country,
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department, User $user, Rank $rank, Country $country)
    {
        return view('admin.department_users.edit', [
            'user' => $user,
            'department' => $department,
            'ranks' => $rank->getRanks(),
            'countries' => $country->getCountries(),
            'types' => $this->getUserTypes(true)->pluck('title', 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
