<?php

namespace App\Http\Controllers\Admin;

use App\Criteria;
use App\CriteriaOption;
use App\CriteriaOptionLang;
use App\Http\Controllers\ConferenceBaseController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CriteriaOptionController extends ConferenceBaseController
{
    public function __construct()
    {
        $criteria = Criteria::findOrFail(request()->segment(4));
        if (!$criteria->type['option']) {
            return redirect()->back()->with('error', 'options');
        }
    }

    /**
     * Display a listing of the resource.
     * @param \App\Criteria $criteria
     * @return \Illuminate\Http\Response
     */
    public function index(Criteria $criteria)
    {
        $criteria->load(['options', 'options.langs', 'langs']);
        $options = $criteria->options()->sort()->get();
        $criteria = $this->loadLangs(Collection::make([$criteria]))->first();
        $options = $this->loadLangs($options);

        return view('admin.criteria.option.index', [
            'title' => $criteria->dbLangs->get(dbTrans())->title . ' ' . trans('static.options'),
            'url' => action('Admin\CriteriaOptionController@create', [$criteria->id]),
            'back' => action('Admin\CriteriaController@index'),
            'options' => $options,
            'criteria' => $criteria
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param \App\Criteria $criteria
     * @return \Illuminate\Http\Response
     */
    public function create(Criteria $criteria)
    {
        return view('admin.criteria.option.create', ['criteria' => $criteria]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OptionRequest $request
     * @param \App\Criteria $criteria
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\OptionRequest $request, Criteria $criteria)
    {
        DB::transaction(function () use ($criteria, $request) {
            $option = $criteria->options()->create(['sort' => $request->get('sort')]);
            $langs = [];
            foreach (LaravelLocalization::getSupportedLocales() as $short => $locale) {
                $langs[] = ['lang_id' => dbTrans($short), 'title' => $request->get('title_' . $short)];
            }
            $option->langs()->createMany($langs);
        });

        return redirect(action('Admin\CriteriaOptionController@index', [$criteria->id]))->with('success', 'saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     *  @param \App\Criteria $criteria
     *  @param \App\CriteriaOption $option
     * @return \Illuminate\Http\Response
     */
    public function edit(Criteria $criteria, CriteriaOption $option)
    {
        $option->load('langs');
        foreach ($option->langs as $lang) {
            $key = 'title_' . systemTrans($lang['lang_id']);
            $option->$key = $lang['title'];
        }
        return view('admin.criteria.option.edit', compact('criteria', 'option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OptionRequest $request
     * @param \App\Criteria $criteria
     *  @param \App\CriteriaOption $option
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\OptionRequest $request, Criteria $criteria, CriteriaOption $option)
    {
        DB::transaction( function () use ($request, $option) {
            $option->update(['sort' => $request->get('sort')]);
            foreach ($option->langs as $lang) {
                $lang->update(['title' => $request->get('title_' . systemTrans($lang['lang_id']))]);
            }
        });

        return redirect(action('Admin\CriteriaOptionController@index', [$criteria->id]))->with('success', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Criteria $criteria
     *  @param \App\CriteriaOption $option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criteria $criteria, CriteriaOption $option)
    {
        $option->delete();
        return redirect(action('Admin\CriteriaOptionController@index', [$criteria->id]))->with('success', 'deleted');
    }
}
