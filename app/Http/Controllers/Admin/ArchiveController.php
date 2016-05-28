<?php

namespace App\Http\Controllers\Admin;

use App\Archive;
use App\Classes\PaperClass;
use App\Classes\PaperStatus;
use App\Department;
use App\Http\Controllers\ConferenceBaseController;
use App\Paper;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ArchiveController extends ConferenceBaseController
{
    private $systemAdmin;

    public function __construct()
    {
        $this->middleware('departmentAccess:11');
        $statuses = new PaperStatus();
        if (systemAccess(100)) {
            $this->systemAdmin = true;
        }

        view()->share(['systemAdmin' => $this->systemAdmin, 'statuses' => $statuses->getStatuses()]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departmentId = null;
        if ($this->systemAdmin) {
            if (session('department_filter_id')) {
                $departmentId = session('department_filter_id');
            }
        } else {
            $departmentId = auth()->user()->department_id;
        }

        $archives = Archive::with(['papers', 'department.langs' => function($query){
            $query->lang();
        }]);

        if ($departmentId) {
            $archives->where('department_id', $departmentId);
        }
        $archives = $archives->get();

        return view('admin.archive.index', [
            'archives' => $archives,
            'title' => trans('static.archive'),
            'url' => action('Admin\ArchiveController@create')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.archive.create', ['departments' => getNomenclatureSelect($this->getDepartmentsAdmin(), true)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = ['name' => 'required|unique:archive,name|regex:' . config('app.expressions.dir')];
        if ($this->systemAdmin) {
            $rules['department_id'] = 'required';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::transaction(function() use ($request) { #add all papers from department to archive
            $archive = Archive::create($request->all());
            $department = Department::findOrFail($request->get('department_id'));
            $paperObj = new PaperClass();
            $archivePath = 'archive/';
            if (!File::exists($archivePath . $archive->name)) {
                File::makeDirectory($archivePath . $archive->name);
            }

            $newPath = $archivePath . $archive->name . '/';
            $oldPath = $paperObj->prefix() . '/' . $department->keyword . '/';

            foreach($department->papers()->archived()->get() as $paper) {
                $paper->archive()->associate($archive);
                $paper->save();
                File::move($oldPath . $paper->source, $newPath . $paper->source);
                if ($paper->payment_source) {
                    File::move($oldPath . $paper->payment_source, $newPath . $paper->payment_source);
                }
            }
        });

        return redirect()->action('Admin\ArchiveController@index')->with('success', 'updated');
    }


    public function show($id)
    {
        $archive = Archive::findOrFail($id);
        $papers = $archive->papers()->with(['user', 'reviewer', 'category.langs' => function($query) {
            $query->lang();
        }])->get();

        return view('admin.archive.papers.index', [
            'archive' => $archive,
            'papers' => $papers,
            'back' => action('Admin\ArchiveController@index'),
            'title' => trans('static.archive') . ': ' . $archive->name . ' ' . trans('static.menu-papers')
        ]);
    }

    public function showPapers($archive, $paper)
    {
        $archive = Archive::findOrFail($archive);
        $paper = $archive->papers()
             ->with([
                 'category.langs' => function($query) { $query->lang(); },
                 'criteria.langs' => function($query) { $query->lang(); },
                 'criteria.options.langs' => function($query) { $query->lang(); },
             ])
            ->where('id', $paper)->first();
        return view('admin.archive.papers.show', [
            'archive' => $archive,
            'paper' => $paper
        ]);
    }
}
