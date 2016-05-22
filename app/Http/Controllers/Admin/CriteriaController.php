<?php

namespace App\Http\Controllers\Admin;

use App\Classes\CriteriaType;
use App\Criteria;
use App\Http\Controllers\ConferenceBaseController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CriteriaController extends  ConferenceBaseController
{
    private $systemAdmin;

    public function __construct()
    {
        $this->middleware('departmentAccess:6');
        $this->middleware('adminDepartmentObject:Criteria', ['only' => ['edit', 'update', 'delete']]);

        $this->systemAdmin = false;
        $departments = [];
        $types = new CriteriaType();

        if (systemAccess(100)) {
            $this->systemAdmin = true;
            $departments = getNomenclatureSelect($this->getDepartmentsAdmin(), true);
        }
        view()->share([
            'systemAdmin' => $this->systemAdmin,
            'departments' => $departments,
            'types'       => $types->getTypes()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $criteria = Criteria::with('langs');
        if (!$this->systemAdmin) {
            $criteria->where('department_id', auth()->user()->department_id);
        }
        $criteria = $criteria->sort()->get();
        $this->loadLangs($criteria);

        return view('admin.criteria.index', [
            'title' => trans('static.criteria'),
            'url' => action('Admin\CriteriaController@create'),
            'criteria' => $criteria
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.criteria.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CriteriaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CriteriaRequest $request)
    {
        $departmentId = auth()->user()->department_id;
        if ($request->has('department_id') && $this->systemAdmin) {
            $departmentId = $request->get('department_id');
        }

        DB::transaction(function () use ($departmentId, $request) {
            $criteria = Criteria::create([
                'department_id' => $departmentId,
                'type_id' => $request->get('type_id'),
                'required' => $request->get('required'),
                'visible' => $request->get('visible'),
                'admin' => $request->get('admin'),
                'sort' => $request->get('sort'),
            ]);
            $langs = [];
            foreach (LaravelLocalization::getSupportedLocales() as $short => $locale) {
                $langs[] = ['lang_id' => dbTrans($short), 'title' => $request->get('title_' . $short)];
            }
            $criteria->langs()->createMany($langs);
        });

        return redirect(action('Admin\CriteriaController@index'))->with('success', 'saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Criteria $criteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Criteria $criteria)
    {
        $criteria->load('langs');
        foreach ($criteria->langs as $lang) {
            $key = 'title_' . systemTrans($lang['lang_id']);
            $criteria->$key = $lang['title'];
        }

        return view('admin.criteria.edit', ['criteria' => $criteria]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CriteriaRequest $request
     * @param  \App\Criteria $criteria
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CriteriaRequest $request, Criteria $criteria)
    {
        DB::transaction( function () use ($request, $criteria) {
            $update = [
                'required' => $request->get('required'),
                'visible' => $request->get('visible'),
                'admin' => $request->get('admin'),
                'sort' => $request->get('sort'),
                'type_id' => $request->get('type_id')
            ];
            if ($this->systemAdmin) {
                $update['department_id'] = $request->get('department_id');
            }
            $criteria->update($update);
            foreach ($criteria->langs as $lang) {
                $lang->update(['title' => $request->get('title_' . systemTrans($lang['lang_id']))]);
            }
        });

        return redirect(action('Admin\CriteriaController@index'))->with('success', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Criteria $criteria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criteria $criteria)
    {
        $criteria->delete();
        return redirect(action('Admin\CriteriaController@index'))->with('success', 'deleted');
    }
}
