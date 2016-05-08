<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\CategoryLang;
use App\Department;
use App\Http\Controllers\ConferenceBaseController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryController extends ConferenceBaseController
{
    private $systemAdmin;

    public function __construct()
    {
        $this->systemAdmin = false;
        $departments = [];
        if (systemAccess(100)) {
            $this->systemAdmin = true;
            $departments = getNomenclatureSelect($this->getDepartmentsAdmin(), true);
        }
        view()->share(['systemAdmin' => $this->systemAdmin, 'departments' => $departments]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->getCategoriesAdmin($this->systemAdmin ? null : auth()->user()->department_id);
        return view('admin.category.index', [
            'categories' => $categories,
            'title' => trans('admin.categories'),
            'url' => action('Admin\CategoryController@create')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CategoryRequest $request)
    {
        $departmentId = auth()->user()->department_id;
        if ($request->has('department_id') && $this->systemAdmin) {
            $departmentId = $request->get('department_id');
        }

        DB::transaction(function () use ($departmentId, $request) {
            $category = Category::create(['department_id' => $departmentId, 'sort' => $request->get('sort'), 'active' => $request->get('active')]);
            $langs = [];
            foreach (LaravelLocalization::getSupportedLocales() as $short => $locale) {
                $langs[] = ['lang_id' => dbTrans($short), 'name' => $request->get('name_' . $short)];
            }
            $category->langs()->createMany($langs);
        });

        return redirect(action('Admin\CategoryController@index'))->with('success', 'saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $category->load('langs');
        foreach ($category->langs as $lang) {
            $key = 'name_' . systemTrans($lang['lang_id']);
            $category->$key = $lang['name'];
        }

        return view('admin.category.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CategoryRequest $request, Category $category)
    {
        DB::transaction( function () use ($request, $category) {
            $update = ['sort' => $request->get('sort'), 'active' => $request->get('active')];
            if ($this->systemAdmin) {
                $update['department_id'] = $request->get('department_id');
            }
            $category->update($update);
            foreach ($category->langs as $lang) {
                $lang->update(['name' => $request->get('name_' . systemTrans($lang['lang_id']))]);
            }
        });

        return redirect(action('Admin\CategoryController@index'))->with('success', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect(action('Admin\CategoryController@index'))->with('success', 'deleted');
    }
}
