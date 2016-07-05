<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Template;
use App\EmailTemplate;
use App\UserType;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ConferenceBaseController;
use Illuminate\Support\Facades\Mail;

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

        EmailTemplate::create(['department_id' => $departmentId] + $request->all());
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

        $template->update(['department_id' => $departmentId] + $request->all());
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

    public function getEmail()
    {
        $departmentId = null;
        if ($this->systemAdmin) {
            if (session('department_filter_id')) {
                $departmentId = session('department_filter_id');
            }
        } else {
            $departmentId = auth()->user()->department_id;
        }

        $users = $templates = [];
        if ($departmentId) {
            $users = simpleSelect(User::where('department_id', $departmentId)->get());
            $templates = simpleSelect(EmailTemplate::where('department_id', $departmentId)->where('system', 0)->get(), true);
        }

        return view('admin.template.email', [
            'departments' => getNomenclatureSelect($this->getDepartmentsAdmin(), true),
            'user_types'  => simpleSelect(UserType::active()->get(), true, 'title'),
            'users'       => $users,
            'templates'   => $templates,
        ]);
    }

    public function postEmail(Request $request, Mailer $mailer)
    {
        $this->validate($request, [
            'template_id' => 'required|exists:email_template,id',
        ]);


        $departmentId = auth()->user()->department_id;
        if ($request->get('department_id')) {
            $departmentId = $request->get('department_id');
        }

        $users = [];
        if ($request->get('user_type')) {
            $users = array_merge(User::where('department_id', $departmentId)->where('user_type_id', $request->get('user_type'))->get()->toArray());
        }

        if ($request->get('users')) {
            $users = array_merge($users, User::whereIn('id', $request->get('users'))->get()->toArray());
        }

        $emailTemplate = EmailTemplate::find($request->get('template_id'));

        if (strpos($emailTemplate->body, '[name]')) {
            $template = new Template();
            foreach ($users as $user) {
                $body = $template->parser($emailTemplate->body, ['name' => $user['name']]);

                $mailer->send('layouts.partials.email', ['body' => $body], function ($message) use ($emailTemplate, $user) {
                    $message->subject($emailTemplate->subject);
                    $message->to($user['email']);
                });
            }
        } else {
            $emails = array_column($users, 'email');
            $emails = array_unique($emails);
            $mailer->send('layouts.partials.email', ['body' => $emailTemplate->body], function ($message) use ($emailTemplate, $emails) {
                $message->subject($emailTemplate->subject);
                $message->to($emails);
            });
        }

        return redirect()->action('Admin\EmailTemplateController@getEmail')->with('success', 'emails-send');
    }
}
