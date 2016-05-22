<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ConferenceBaseController;
use App\News;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NewsController extends ConferenceBaseController
{
    private $systemAdmin;

    public function __construct()
    {
        $this->middleware('departmentAccess:4');
        $this->middleware('adminDepartmentObject:News', ['only' => ['edit', 'update', 'delete']]);

        $this->systemAdmin = false;
        $departments = [];

        if (systemAccess(100)) {
            $this->systemAdmin = true;
            $departments = getNomenclatureSelect($this->getDepartmentsAdmin(), true);
        }

        view()->share([
            'systemAdmin' => $this->systemAdmin,
            'departments' => $departments
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::with('langs');
        if (!$this->systemAdmin) {
            $news->where('department_id', auth()->user()->department_id);
        }
        $news = $news->sort()->get();
        $this->loadLangs($news);

        return view('admin.news.index', [
            'title' => trans('static.news'),
            'url' => action('Admin\NewsController@create'),
            'news' => $news
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\NewsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\NewsRequest $request)
    {
        $departmentId = auth()->user()->department_id;
        if ($request->has('department_id') && $this->systemAdmin) {
            $departmentId = $request->get('department_id');
        }

        DB::transaction(function () use ($departmentId, $request) {
            $news = News::create([
                'department_id' => $departmentId,
                'active' => $request->get('active'),
                'sort' => $request->get('sort'),
            ]);
            $langs = [];
            foreach (LaravelLocalization::getSupportedLocales() as $short => $locale) {
                $langs[] = [
                    'lang_id' => dbTrans($short),
                    'title' => $request->get('title_' . $short),
                    'description' => $request->get('description_' . $short)
                ];
            }
            $news->langs()->createMany($langs);
        });

        return redirect(action('Admin\NewsController@index'))->with('success', 'saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $news->load('langs');
        foreach ($news->langs as $lang) {
            $title = 'title_' . systemTrans($lang['lang_id']);
            $description = 'description_' . systemTrans($lang['lang_id']);
            $news->$title = $lang['title'];
            $news->$description = $lang['description'];
        }

        return view('admin.news.edit', ['news' => $news]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\NewsRequest $request
     * @param  \App\News $news
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\NewsRequest $request, News $news)
    {
        DB::transaction( function () use ($request, $news) {
            $update = [
                'active' => $request->get('active'),
                'sort' => $request->get('sort'),
            ];
            if ($this->systemAdmin) {
                $update['department_id'] = $request->get('department_id');
            }
            $news->update($update);
            foreach ($news->langs as $lang) {
                $lang->update([
                    'title' => $request->get('title_' . systemTrans($lang['lang_id'])),
                    'description' => $request->get('description_' . systemTrans($lang['lang_id'])),
                ]);
            }
        });

        return redirect(action('Admin\NewsController@index'))->with('success', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $news->delete();
        return redirect(action('Admin\NewsController@index'))->with('success', 'deleted');
    }
}
