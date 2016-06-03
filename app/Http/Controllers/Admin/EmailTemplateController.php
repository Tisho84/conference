<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Template;
use App\EmailTemplate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ConferenceBaseController;

class EmailTemplateController extends ConferenceBaseController
{
    private $systemAdmin;

    public function __construct()
    {
        $this->middleware('departmentAccess:3');
        $this->middleware('adminDepartmentObject:EmailTemplate', ['only' => ['edit', 'update', 'delete']]);

        if (systemAccess(100)) {
            $this->systemAdmin = true;
        }
        $temp = new Template();
//        dd($temp->parser('dasa[link], [aa2a], sdadasdda a [name],  ad as ,[name2]', ['name2' => 'Tihomir Kamenov']));
        view()->share(['systemAdmin' => $this->systemAdmin, 'text' => $temp->getParams()]);

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

        $templates = EmailTemplate::with(['department.langs' => function($query){
            $query->lang();
        }]);

        if ($departmentId) {
            $templates->where('department_id', $departmentId);
        }

        $templates = $templates->get();
        return view('admin.template.index', [
            'templates' => $templates,
            'url' => action('Admin\EmailTemplateController@create'),
            'title' => trans('static.templates')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.template.create', ['departments' => getNomenclatureSelect($this->getDepartmentsAdmin(), true)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\EmailTemplateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\EmailTemplateRequest $request)
    {
        $departmentId = auth()->user()->department_id;
        if ($request->has('department_id') && $this->systemAdmin) {
            $departmentId = $request->get('department_id');
        }

        EmailTemplate::create($request->all() + ['department_id' => $departmentId]);
        return redirect()->action('Admin\EmailTemplateController@index')->with('success', 'saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  EmailTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailTemplate $template)
    {
        return view('admin.template.edit', [
            'template' => $template,
            'departments' => getNomenclatureSelect($this->getDepartmentsAdmin(), true)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\EmailTemplateRequest $request
     * @param  EmailTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\EmailTemplateRequest $request, EmailTemplate $template)
    {
        $departmentId = auth()->user()->department_id;
        if ($request->has('department_id') && $this->systemAdmin) {
            $departmentId = $request->get('department_id');
        }

        $template->update($request->all() + ['department_id' => $departmentId]);
        return redirect()->action('Admin\EmailTemplateController@index')->with('success', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EmailTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $template)
    {
        $template->delete();
        return redirect()->action('Admin\EmailTemplateController@index')->with('success', 'deleted');
    }
}
