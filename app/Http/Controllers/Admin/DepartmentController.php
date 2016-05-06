<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\ConferenceBaseController;
use App\Http\Middleware\DepartmentRedirect;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DepartmentController extends ConferenceBaseController
{
    private $systemAdmin = false;
    /**
     * Instantiate a new DepartmentController instance.
     */
    public function __construct()
    {
        $this->middleware('departmentAccess');
        if (systemAccess(100)) { #can config all departments
            $this->systemAdmin = true;
        } else {
            $this->middleware('userFromDepartment', ['except' => [
                'index'
            ]]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->systemAdmin) {
            $departments = Department::all();
        } else {
            $departments = Collection::make([Auth::user()->department]);
        }
        return view('admin.department.index', [
            'departments' => $departments,
            'title' => trans('admin.departments'),
            'url' => $this->systemAdmin ? action('Admin\DepartmentController@create') : ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DepartmentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\DepartmentRequest $request)
    {
        $sort = $request->get('sort');
        if (!$sort) {
            $sort = calcSort(Department::max('sort'));
        }

        DB::transaction(function () use ($sort, $request) {
            $department = Department::create([
                'keyword' => $request->get('keyword'),
                'url' => $request->get('url'),
                'image' => $request->file('image')->getClientOriginalName(),
                'theme_background_color' => $request->get('theme_background_color'),
                'theme_color' => $request->get('theme_color'),
                'sort' => $sort,
                'active' => $request->get('active'),
            ]);
            $this->addDepartmentLangs($request, $department);
            $request->file('image')->move('images/', $request->file('image')->getClientOriginalName());
            File::makeDirectory('papers/' . $department->keyword);
            Cache::forget('departments');
        });

        return redirect(action('Admin\DepartmentController@index'))->with('success', 'saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $this->loadDepartmentLangs($department);
        return view('admin.department.show', ['department' => $department]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $department->load('langs');
        foreach ($department->langs as $lang) {
            foreach (['name', 'title', 'description'] as $elem) {
                $key = $elem . '_' . systemTrans($lang['lang_id']);
                $department->$key = $lang[$elem];
            }
        }
        return view('admin.department.edit', ['department' => $department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DepartmentRequest $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\DepartmentRequest $request, Department $department)
    {
        DB::transaction(function () use ($department, $request) {
            $oldKeyword = $department->keyword;
            $data = [
                'keyword' => $request->get('keyword'),
                'url' => $request->get('url'),
                'theme_background_color' => $request->get('theme_background_color'),
                'theme_color' => $request->get('theme_color'),
                'sort' => $request->get('sort'),
                'active' => $request->get('active'),
            ];
            if ($request->file('image')) {
                $data['image'] = $request->file('image')->getClientOriginalName();
                File::delete('images/' . $department->image);
                $request->file('image')->move('images/', $request->file('image')->getClientOriginalName());
            }

            $department->update($data);
            $department->langs()->delete();
            $this->addDepartmentLangs($request, $department);
            if ($department->keyword != $oldKeyword) {
                File::move('papers/' . $oldKeyword, 'papers/' . $department->keyword);
            }
            Cache::forget('departments');
        });

        return redirect(action('Admin\DepartmentController@index'))->with('success', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        try {
            $department->delete();
        }
        catch (QueryException $e) {
            return redirect()->back()->with('error', 'error-delete-department');
        }

        File::delete('images/' . $department->image);
        File::delete('papers/' . $department->keyword);
        Cache::forget('departments');
        return redirect(action('Admin\DepartmentController@index'))->with('success', 'deleted');
    }

    private function loadDepartmentLangs(Department $department)
    {
        $department->load('langs');
        $department->dbLangs = $department->langs->keyBy('lang_id');
        $department->addVisible('dbLangs');
    }

    private function addDepartmentLangs(Requests\DepartmentRequest $request, Department $department)
    {
        $langs = [];
        foreach (LaravelLocalization::getSupportedLocales() as $short => $locale) {
            $langs[] = [
                'lang_id' => dbTrans($short),
                'name' => $request->get('name_' . $short),
                'title' => $request->get('title_' . $short),
                'description' => $request->get('description_' . $short),
            ];
        }
        $department->langs()->createMany($langs);
    }
}
