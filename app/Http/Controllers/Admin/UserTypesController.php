<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ConferenceBaseController;
use App\UserType;
use App\UserTypeAccess;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Classes\Access;

class UserTypesController extends ConferenceBaseController
{
    public function __construct()
    {
        $access = new Access();
        $this->access = $access->getAccess();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = $this->getUserTypes();
        $access = [];
        foreach ($types as $type) {
            $tmpAccess = [];
            foreach ($type->access as $acc) {
                $tmpAccess[] = $this->access[$acc->access_id];
            }
            $access[$type->id] = implode(', ', $tmpAccess);
        }

        return view('admin.user_type.index', [
            'userTypes' => $types,
            'access' => $access,
            'title' => trans('admin.user-types'),
            'url' => action('Admin\UserTypesController@create')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user_type.create', [
            'access' => $this->access
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\UserTypeRequest $request)
    {
        DB::transaction(function () use ($request) {
            $sort = $request->get('sort');
            if (!$sort) {
                $sort = calcSort(UserType::max('sort'));
            }
            $type = UserType::create([
                'title' => $request->get('title'),
                'sort' => $sort,
                'active' => $request->get('active'),
                'is_default' => 0
            ]);

            $access = [];
            foreach ($request->get('access') as $acc) {
                $access[] = new UserTypeAccess(['user_type_id' => $type->id, 'access_id' => $acc]);
            }
            $type->access()->saveMany($access);
        });
        return redirect(action('Admin\UserTypesController@index'))->with('success', 'saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserType $type
     * @return \Illuminate\Http\Response
     */
    public function edit(UserType $type)
    {
        if ($type->is_default) {
            return redirect()->back()->with('error', 'is-default');
        }

        return view('admin.user_type.edit', [
            'type' => $type,
            'selectedAccess' => $type->access->lists('access_id')->toArray(),
            'access' => $this->access
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserTypeRequest  $request
     * @param  UserType $type
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UserTypeRequest $request, UserType $type)
    {
        DB::transaction(function () use ($request, $type) {
            $type->update($request->except('access'));
            $type->access()->delete();
            $access = [];
            foreach ($request->get('access') as $acc) {
                $access[] = new UserTypeAccess(['user_type_id' => $type->id, 'access_id' => $acc]);
            }
            $type->access()->saveMany($access);
        });
        return redirect(action('Admin\UserTypesController@index'))->with('success', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserType  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserType $type)
    {
        if ($type->is_default) {
            return redirect()->back()->with('error', 'is-default');
        }
        $type->delete();
        return redirect(action('Admin\UserTypesController@index'))->with('success', 'deleted');
    }
}
