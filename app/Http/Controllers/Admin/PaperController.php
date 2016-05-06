<?php

namespace App\Http\Controllers\Admin;

use App\Classes\PaperClass;
use App\Classes\PaperStatus;
use App\Department;
use App\Http\Controllers\ConferenceBaseController;
use App\Paper;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaperController extends ConferenceBaseController
{
    private $systemAdmin;

    public function __construct()
    {
        $departments = [];
        $this->systemAdmin = false;
        $this->paper = new PaperClass();
        $statuses = new PaperStatus();
        $select = [0 => trans('static.select')];

        if (systemAccess(100)) {
            $this->systemAdmin = true;
            $departments = getNomenclatureSelect($this->getDepartmentsAdmin(), true);
        }
        view()->share([
            'categories' => getNomenclatureSelect($this->getCategories(), true),
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
        if ($this->systemAdmin) {
            $papers = Paper::with('reviewer', 'user')->get();
        } else {
            $papers = Paper::with('reviewer', 'user')
                ->where('department_id', auth()->user()->department_id)
                ->get();
        }

        return view('admin.paper.index', [
            'papers' => $papers,
            'title' => trans('static.menu-papers'),
            'url' => action('Admin\PaperController@create')
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
        $status = $request->get('status_id') ? : 1;
        if ($request->get('reviewer_id')) {
            $status = 2;
        }

        $paperData = [
            'department_id' => $departmentId,
            'category_id'   => $request->get('category_id'),
            'status_id'     => $status,
            'reviewer_id'   => $request->get('reviewer_id'),
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
        $department = null;
        if (!$this->systemAdmin) { #if not system admin get department users
            $department = auth()->user()->department_id;
        }

        return view('admin.paper.edit', [
            'paper' => $paper,
            'authors' => simpleSelect(User::getAuthors($department), true),
            'reviewers' => simpleSelect(User::getReviewers($department), true)
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

        $paperData = [
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

        $this->paper->setUrl($paper->department->keyword);
        if ($request->file('paper')) {
            $paperData['source'] = $this->paper->buildFileName();
            $this->paper->deleteFile();
        }

        if ($request->file('payment_source')) {
            $paperData['payment_source'] = $this->paper->buildInvoiceName();
            $this->paper->deleteInvoice();
        }

        $this->paper->upload();
        $paper->update($paperData);

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
}
