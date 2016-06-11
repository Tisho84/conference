<?php

namespace App\Http\Controllers\Admin;

use App\Classes\PaperClass;
use App\Classes\PaperStatus;
use App\Criteria;
use App\Department;
use App\Events\PaperWasFinished;
use App\Events\ReviewerPaperSet;
use App\Http\Controllers\ConferenceBaseController;
use App\Paper;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaperController extends ConferenceBaseController
{
    private $systemAdmin;

    public function __construct()
    {
        $this->middleware('departmentAccess:1', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('paperArchive', ['only' => ['update', 'edit', 'getEvaluate', 'postEvaluate']]);
        $this->middleware('adminDepartmentObject:Paper', ['only' => ['show', 'edit', 'update', 'getEvaluate', 'postEvaluate', 'delete']]);

        $departments = [];
        $this->systemAdmin = false;
        $this->paper = new PaperClass();
        $statuses = new PaperStatus();
        $select = [0 => trans('static.select')];
        $department = auth()->user()->department_id;

        if (systemAccess(100)) {
            $department = null;
            $this->systemAdmin = true;
            $departments = getNomenclatureSelect($this->getDepartmentsAdmin(), true);
        }

        view()->share([
            'categories' => getNomenclatureSelect($this->getCategories($department), true),
            'departments' => $departments,
            'statuses' => $select + $statuses->getStatuses(),
            'systemAdmin' => $this->systemAdmin,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $papers = Paper::with('reviewer', 'user', 'requests');
        $department = null;
        if (!$this->systemAdmin) {
            $department = auth()->user()->department_id;
        } else if (request('department_id') && $this->systemAdmin) {
            $department = request('department_id');
        }

        if ($department) {
            $papers->where('department_id', (int)$department);
        }

        if (request('status_id')) {
            $papers->where('status_id', (int)request('status_id'));
        }

        if (request('category_id')) {
            $papers->where('category_id', (int)request('category_id'));
        }

        if (request('from')) {
            $papers->whereDate('created_at', '>=', Carbon::createFromFormat('m/d/Y', request('from'))->format('Y-m-d'));
        }

        if (request('to')) {
            $papers->whereDate('created_at', '<=', Carbon::createFromFormat('m/d/Y', request('to'))->format('Y-m-d'));
        }

        if (request('title')) {
            $papers->where('title', 'like', '%' . request('title') . '%');
        }

        if (request('user_id')) {
            $papers->where('user_id', (int)request('user_id'));
            $user = User::find((int)request('user_id'));
            session()->set('info-raw', $user->name . ' ' . trans('static.uploaded-papers'));
        }

        if (request('reviewer_id')) {
            $papers->where('reviewer_id', (int)request('reviewer_id'));
            $reviewer = User::find((int)request('reviewer_id'));
            session()->set('info-raw', $reviewer->name . ' ' . trans('static.reviewed-papers'));
        }

        if (session('department_filter_id')) {
            $papers = $papers->where('department_id', session('department_filter_id'));
        }

        $papers = $papers->archived()->get();
        return view('admin.paper.index', [
            'papers' => $papers,
            'title' => trans('static.menu-papers'),
            'url' => action('Admin\PaperController@create'),
            'search' => 1
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = null;
        if (!$this->systemAdmin) { #if not system admin get department users
            $department = auth()->user()->department_id;
        }

        return view('admin.paper.create', [
            'force' => false,
            'authors' => simpleSelect(User::getAuthors($department), true),
            'reviewers' => simpleSelect(User::getReviewers($department), true)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\PaperRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\PaperRequest $request)
    {
        $departmentId = auth()->user()->department_id;
        if ($request->has('department_id') && $this->systemAdmin) {
            $departmentId = $request->get('department_id');
        }
        $department = Department::find($departmentId);
        $this->paper->setUrl($department->keyword);
        if (!in_array($request->get('category_id'), $department->categories->lists('id')->toArray())) {
            return redirect()->back()->with('error', 'department-category');
        }

        $status = $request->get('status_id') ? : 1;
        if ($request->get('reviewer_id')) {
            $status = 2;
        }

        $paperData = [
            'department_id' => $departmentId,
            'category_id'   => $request->get('category_id'),
            'status_id'     => $status,
            'reviewer_id'   => $request->get('reviewer_id') ? : null,
            'user_id'       => $request->get('user_id'),
            'source'        => $this->paper->buildFileName(),
            'title'         => $request->get('title'),
            'description'   => $request->get('description'),
            'authors'       => $request->get('authors'),
            'payment_confirmed'   => 1,
            'payment_description' => $request->get('payment_description'),
            'payment_source'      => $this->paper->buildInvoiceName()
        ];

        try {
            Paper::create($paperData);
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'error');
        }

        $this->paper->upload();
        return redirect()->action('Admin\PaperController@index')->with('success', 'saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  Paper $paper
     * @return \Illuminate\Http\Response
     */
    public function show(Paper $paper)
    {
        $paper->load([
            'criteria.langs' => function($query) { $query->lang(); },
            'criteria.options.langs' => function($query) { $query->lang(); },
        ]);

        return view('admin.paper.show', ['paper' => $paper]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Paper $paper
     * @return \Illuminate\Http\Response
     */
    public function edit(Paper $paper)
    {
        return view('admin.paper.edit', [
            'paper' => $paper,
            'force' => true, #force to set reviewers and categories
            'authors' => simpleSelect(User::getAuthors($paper->department_id), true),
            'reviewers' => simpleSelect(User::getReviewers($paper->department_id, $paper->category_id), true),
            'categories' => getNomenclatureSelect($this->getCategories($paper->department_id), true)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\PaperRequest $request
     * @param  Paper $paper
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\PaperRequest $request, Paper $paper)
    {
        $this->paper->setPaper($paper);
        $status = $request->get('status_id');
        $reviewer = $request->get('reviewer_id') ? : null;
        if (!$paper->reviewer_id && $reviewer) {
            if ($request->get('status_id') < 2) {
                $status = 2;
            }
        }

        $department = Department::find($request->get('department_id'));
        $this->paper->setUrl($department->keyword);
        if (!in_array($request->get('category_id'), $department->categories->lists('id')->toArray())) {
            return redirect()->back()->with('error', 'department-category');
        }

        if ($paper->department_id != $request->get('department_id')) { #if department is changed files must be moved
            $url = $this->paper->prefix();
            $oldPath = $url . '/' . $paper->department->keyword . '/';
            $newPath = $url . '/' . $department->keyword . '/';
            File::move($oldPath . $paper->source, $newPath . $paper->source);
            if ($paper->payment_source) {
                File::move($oldPath . $paper->payment_source, $newPath . $paper->payment_source);
            }
        }

        $paperData = [
            'department_id' => $department->id,
            'category_id'   => $request->get('category_id'),
            'status_id'     => $status,
            'title'         => $request->get('title'),
            'description'   => $request->get('description'),
            'authors'       => $request->get('authors'),
            'user_id'       => $request->get('user_id'),
            'reviewer_id'   => $reviewer,
            'updated_at'    => Carbon::now(),
            'payment_description' => $request->get('payment_description'),
        ];

        if ($request->file('paper')) {
            $paperData['source'] = $this->paper->buildFileName();
            $this->paper->deleteFile();
        }

        if ($request->file('payment_source')) {
            $paperData['payment_source'] = $this->paper->buildInvoiceName();
            $this->paper->deleteInvoice();
        }

        $this->paper->upload();
        $oldReviewer = $paper->reviewer_id;
        $paper->update($paperData);


        if ($oldReviewer != $paper->reviewer_id) { #reviewer changed
            event(new ReviewerPaperSet($paper));
        }

        return redirect()->action('Admin\PaperController@index')->with('success', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Paper $paper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paper $paper)
    {
        $this->paper->setPaper($paper);
        $this->paper->setUrl($paper->department->keyword);
        if (!$this->paper->delete()) {
            return redirect()->back()->with('error', 'error-delete-paper');
        }
        return redirect()->action('Admin\PaperController@index')->with('success', 'deleted');
    }

    /**
     * @param int $paper
     * get reviewer evaluation view
     * @return \Illuminate\Http\Response
     */
    public function getEvaluate($paper)
    {
        $paper = Paper::findOrFail($paper);
        if ($paper->department_id != auth()->user()->department_id || !systemAccess(2)) {
            if (!$this->systemAdmin) {
                return redirect()->action('Admin\PaperController@index')->with('error', 'access-denied');
            }
        }

        $criteria = Criteria::where('department_id', $paper->department_id)->with([
            'langs' => function($query) { $query->lang(); },
            'options' => function($query) {$query->sort(); },
            'options.langs' => function($query) { $query->lang(); },
            'papers' => function($query) use ($paper) {
                $query->where('criteria_paper.paper_id', $paper->id);
            }
        ])->sort()->get();

        return view('admin.paper.evaluate', ['paper' => $paper, 'criteria' => $criteria]);
    }

    /**
     * @param int paper
     * save reviewer evaluation
     * @return \Illuminate\Http\Response
     */
    public function postEvaluate($paper)
    {
        $paper = Paper::findOrFail($paper);
        if ($paper->department_id != auth()->user()->department_id || !systemAccess(2)) {
            if (!$this->systemAdmin) {
                return redirect()->action('Admin\PaperController@index')->with('error', 'access-denied');
            }
        }

        $criteriaPaper = $rules = $params = $errors = [];
        $criteria = Criteria::where('department_id', $paper->department_id)
            ->with(['langs' => function($query) {
                $query->lang();
        }])->get();

        foreach ($criteria as $value) {
            $errors[$value->id] = $value->langs->first()->title;
            if (request()->has($value->id)) {
                $params[$value->id] = request($value->id);
                $criteriaPaper[$value->id] = ['value' => request($value->id)];
            }
            if ($value->required) {
                $rules[$value->id] = 'required';
            }

            if ($value->type_id == 1) {
                $max = 'max:1500';
                if (isset($rules[$value->id])) {
                    $rules[$value->id] .= '|' . $max;
                } else {
                    $rules[$value->id] = $max;
                }
            }
        }

        $validator = Validator::make($params, $rules);
        $validator->setAttributeNames($errors);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::transaction(function() use ($criteriaPaper, $paper) {
            $paper->update(['status_id' => 4, 'reviewed_at' => Carbon::now()]);
            $paper->criteria()->sync($criteriaPaper);

        });

        if (request()->get('email')) {
            event(new PaperWasFinished($paper));
        }

        return redirect()->action('Admin\PaperController@index')->with('success', 'paper-evaluated');
    }
}
