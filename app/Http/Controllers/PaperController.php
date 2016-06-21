<?php

namespace App\Http\Controllers;

use App\Classes\PaperClass;
use App\Classes\PaperStatus;
use App\Criteria;
use App\CriteriaPaper;
use App\Department;
use App\Events\PaperWasCreated;
use App\Events\PaperWasUpdated;
use App\Paper;
use Carbon\Carbon;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpSpec\Exception\Exception;

class PaperController extends ConferenceBaseController
{
    private $department;
    private $paper;

    public function __construct()
    {
        $this->department = $this->getDepartment();
        $this->middleware('paperArchive', ['except' => ['index', 'create', 'store']]);
        $this->middleware('lockPaper:' . $this->department->id, ['only' => ['create', 'store', 'edit', 'update', 'destroy', 'getInvoice', 'postInvoice']]);

        $this->paper = new PaperClass();
        $statuses = new PaperStatus();
        view()->share([
            'categories' => getNomenclatureSelect($this->getCategories(), true),
            'statuses' => $statuses->getStatuses()
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $papers = Paper::where('department_id', $this->department->id);
        if (request()->get('requests')) {
            $requests = auth()->user()->requests->pluck('id');
            $papers->where('reviewer_id', null)
                ->whereNotIn('id', $requests)
                ->where('status_id', 1); #available papers
        } else {
            $papers->where(function($query){
                $query->where('user_id', auth()->user()->id)
                    ->orWhere('reviewer_id', auth()->user()->id);
            });
        }
        $settings = $this->department->settings()->key('papers');
        $papers = $papers->archived()
            ->orderBy('created_at')
            ->paginate(10);

        return view('conference.papers.index', ['papers' => $papers, 'lock' => isset($settings->value) ? $settings->value : 0]);
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
            $paper = Paper::create($paperData);
        } catch(Exception $e) {
            return redirect()->back()->with('error', 'error');
        }
        $this->paper->upload($name);
        event(new PaperWasCreated($paper));

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
        if ($paper->isAuthor() || $paper->isReviewer() || systemAccess(13)) {
            $paper->load([
                'criteria.langs' => function($query) { $query->lang(); },
                'criteria.options.langs' => function($query) { $query->lang(); },
            ]);
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
            event(new PaperWasUpdated($paper));

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
            event(new PaperWasUpdated($paper));

            return redirect()->action('PaperController@index', [$department->keyword])->with('success', 'saved');
        }
        return redirect()->back()->with('error', 'access-denied');
    }

    /**
     * @param Department $department
     * @param int paper
     * get reviewer evaluation view
     * @return \Illuminate\Http\Response
     */
    public function getEvaluate(Department $department, $paper)
    {
        $paper = Paper::findOrFail($paper);
        if (auth()->user()->id != $paper->reviewer_id || !$paper->canEvaluate()) {
            return redirect()->action('PaperController@index', [$department->keyword])->with('error', 'access-denied');
        }

        $criteria = $department->criteria()->with([
            'langs' => function($query) { $query->lang(); },
            'options' => function($query) {$query->sort(); },
            'options.langs' => function($query) { $query->lang(); },
            'papers' => function($query) use ($paper) {
                $query->where('criteria_paper.paper_id', $paper->id);
            }
        ])->where('admin', 0)
            ->sort()
            ->get();

        return view('conference.papers.evaluate', ['paper' => $paper, 'criteria' => $criteria]);
    }

    /**
     * @param Department $department
     * @param int paper
     * save reviewer evaluation
     * @return \Illuminate\Http\Response
     */
    public function postEvaluate(Department $department, $paper)
    {
        $paper = Paper::findOrFail($paper);
        if (auth()->user()->id != $paper->reviewer_id || !$paper->canEvaluate()) {
            return redirect()->action('PaperController@index', [$department->keyword])->with('error', 'access-denied');
        }

        $criteriaPaper = $rules = $params = $errors = [];
        $criteria = $department->criteria()->with(['langs' => function($query) {
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
            $paper->update(['status_id' => 3, 'reviewed_at' => Carbon::now()]);
            $paper->criteria()->sync($criteriaPaper);

        });
        return redirect()->action('PaperController@index', [$department->keyword])->with('success', 'paper-evaluated');
    }

    public function request(Department $department, $paper)
    {
        if (!systemAccess(13)) {
            return redirect()->action('PaperController@index', [$department->keyword])->with('error', 'access-denied');
        }

        $paper = Paper::findOrFail($paper);
        $paper->requests()->attach(auth()->user()->id);

        return redirect()->action('PaperController@index', [$department->keyword])->with('success', 'request-send');
    }
}
