<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Events\ReviewerPaperSet;
use App\Http\Controllers\ConferenceBaseController;
use App\Paper;
use App\Settings;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingsController extends ConferenceBaseController
{
    public function __construct()
    {
        $this->middleware('departmentAccess:8');
    }

    public function display()
    {
        $settings = new \App\Classes\Settings;
        $departments = $this->getDepartmentsAdmin();
        $settingsRecords = [];

        if (session('department_filter_id')) {
            $settingsDB = Settings::where('department_id', session('department_filter_id'))->get();
        } else {
            $settingsDB = Settings::all();
        }

        foreach ($settingsDB as $setting) {
            $settingsRecords[$setting['department_id']][$setting['key']] = $setting['value'];
        }

        $departmentId = null;
        if (systemAccess(100)) {
            if (session('department_filter_id')) {
                $departmentId = session('department_filter_id');
            }
        } else {
            $departmentId = auth()->user()->department_id;
        }

        if ($departmentId) {
            $userDepartment = [];
            foreach ($departments as $department) {
                if ($department->id == $departmentId) {
                    $userDepartment = $department;
                    break;
                }
            }
            $departments = [$userDepartment];
        }
        $settings = $settings->getSettings($departments);
        return view('admin.settings.display', compact('settings', 'departments', 'settingsRecords'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $departments = $request->get('department');
        foreach ($departments as $id => $department) {
            Settings::where('department_id', $id)->delete();
            foreach ($department as $key => $value) {
                Settings::create(['department_id' => $id, 'key' => $key, 'value' => $value]);
            }
        }
        return redirect()->action('Admin\SettingsController@display')->with('success', 'updated');
    }

    private function findCandidate($paper, $users) {
        $reviewer = null;
        $ids = [];
        if ($paper->requests) {
            $ids = $paper->requests->pluck('id')->toArray();
        }

        if ($ids) {
            foreach ($users as $user) {
                if (in_array($user->id, $ids)) { #get the user with lowest papers for review (his requests)
                    $reviewer = $user->id;
                    break;
                }
            }
        }

        if (!$reviewer) {
            foreach ($users as $user) {
                if ($paper->user_id == $user->id) { #if article uploader == reviewer skip
                    continue;
                }

                if (in_array($paper->category_id, (array)explode(' ', $user->categories))) {
                    $reviewer = $user->id;
                    break;
                }
            }
        }
        return $reviewer;
    }

    public function auto(Request $request)
    {
        $department = Department::findOrFail($request->get('department_id'));
        $users = collect(User::getReviewers($department->id))->sortBy('papers')->keyBy('id')->toArray(); //sort user array by num papers
        $papers = $department->papers()->with('requests')->archived()->where('status_id', '<', 3)->get();

        foreach ($papers as $paper) {
            $reviewerId = $this->findCandidate($paper, $users);
            $paper->reviewer_id = $reviewerId;
            $paper->status_id = 2;
            $paper->save();
            if ($reviewerId) {
                $users[$reviewerId]->papers++;
                $users = collect($users)->sortBy('papers')->toArray();
                event(new ReviewerPaperSet($paper));
            }
        }
        return json_encode(['status' => true, 'message' => trans('messages.auto-success')]);
    }
}
