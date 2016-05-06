<?php

namespace App\Http\Controllers;

use App\Classes\PaperClass;
use App\Classes\PaperStatus;
use App\Department;
use App\Paper;
use Carbon\Carbon;

use App\Http\Requests;
use Illuminate\Http\Request;
use PhpSpec\Exception\Exception;

class PaperController extends ConferenceBaseController
{
    private $department;
    private $paper;

    public function __construct()
    {
        $this->department = $this->getDepartment();
        $this->paper = new PaperClass();

        $statuses = new PaperStatus();
        view()->share([
            'categories' => [0 => trans('static.select')] + (array)getNomenclatureSelect($this->getCategories()),
            'statuses' => $statuses->getStatuses()
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $papers = Paper::where('user_id', auth()->user()->id)
            ->orWhere('reviewer_id', auth()->user()->id)
            ->orderBy('created_at')
            ->get();
        return view('conference.papers.index', ['papers' => $papers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!systemAccess(1)) {
            return redirect()->back()->with('error', 'access-denied');
        }
        return view('conference.papers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\PaperRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\PaperRequest $request)
    {
        if (!systemAccess(1)) {
            return redirect()->back()->with('error', 'access-denied');
        }

        $name = $this->paper->buildFileName();
        $paperData = [
            'department_id' => $this->department->id,
            'category_id'   => $request->get('category_id'),
            'user_id'       => auth()->user()->id,
            'source'        => $name,
            'title'         => $request->get('title'),
            'description'   => $request->get('description'),
            'authors'       => $request->get('authors'),
        ];

        try {
            Paper::create($paperData);
        } catch(Exception $e) {
            return redirect()->back()->with('error', 'error');
        }
        $this->paper->upload($name);
        return redirect()->action('PaperController@index', [$this->department->keyword])->with('success', 'saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  Department $department
     * @param  Paper $paper
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department, Paper $paper)
    {
        if ($paper->isAuthor() || $paper->isReviewer()) {
            return view('conference.papers.show', ['paper' => $paper]);
        }
        return redirect()->back()->with('error', 'access-denied');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Department $department
     * @param  Paper $paper
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department, Paper $paper)
    {
        if ($paper->canEdit() && $paper->isAuthor()) {
            return view('conference.papers.edit', ['paper' => $paper]);
        }
        return redirect()->back()->with('error', 'access-denied');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\PaperRequest $request
     * @param  Department $department
     * @param  Paper $paper
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\PaperRequest $request, Department $department, Paper $paper)
    {
        if ($paper->canEdit() && $paper->isAuthor()) {
            $this->paper->setPaper($paper);
            $paperData = [
                'category_id'   => $request->get('category_id'),
                'title'         => $request->get('title'),
                'description'   => $request->get('description'),
                'authors'       => $request->get('authors'),
                'updated_at'    => Carbon::now()
            ];

            if ($request->file('paper')) {
                $paperData['source'] = $this->paper->buildFileName();
                $this->paper->deleteFile();
                $this->paper->upload($paperData['source']);
            }
            $paper->update($paperData);

            return redirect()->action('PaperController@index', [$department->keyword])->with('success', 'saved');
        }
        return redirect()->back()->with('error', 'access-denied');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Paper  $paper
     * @param  Department $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department, Paper $paper)
    {
        if ($paper->canEdit()) {
            $this->paper->setPaper($paper);
            if (!$this->paper->delete()) {
                return redirect()->back()->with('error', 'error-delete-paper');
            }
            return redirect()->action('PaperController@index', [$department->keyword])->with('success', 'deleted');
        }
        return redirect()->back()->with('error', 'access-denied');
    }

    /**
     * view for add paper invoice
     *
     * @param Department $department
     * @param int paper
     * @return \Illuminate\Http\Response
     */
    public function getInvoice(Department $department, $paper)
    {
        $paper = Paper::findOrFail($paper);
        if ($paper->canInvoice() && $paper->isAuthor()) {
            return view('conference.papers.invoice', ['paper' => $paper]);
        }
        return redirect()->back()->with('error', 'access-denied');
    }

    /**
     * view for add paper invoice
     *
     * @param Request $request
     * @param Department $department
     * @param int paper
     * @return \Illuminate\Http\Response
     */
    public function postInvoice(Request $request, Department $department, $paper)
    {
        $paper = Paper::findOrFail($paper);
        if ($paper->canInvoice() && $paper->isAuthor()) {
            $source = 'image|max:5000';
            $this->paper->setPaper($paper);
            if (!$paper->payment_confirmed) {
                $source = 'required|image|max:5000';
            }

            $this->validate($request, [
                'payment_description' => 'min:3|max:1000',
                'payment_source' => $source
            ]);

            $paperData = [
                'payment_confirmed' => 1,
                'payment_description' => $request->get('payment_description')
            ];
            if ($request->file('payment_source')) {
                $paperData['payment_source'] = $this->paper->buildInvoiceName();
                $this->paper->deleteInvoice();
                $this->paper->upload($paperData['payment_source']);
            }
            $paper->update($paperData);

            return redirect()->action('PaperController@index', [$department->keyword])->with('success', 'saved');
        }
        return redirect()->back()->with('error', 'access-denied');
    }
}