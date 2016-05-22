<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ConferenceBaseController;
use App\Settings;
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
        $settings = $settings->getSettings();
        $departments = $this->getDepartmentsAdmin();
        $settingsRecords = [];
        foreach (Settings::all() as $setting) {
            $settingsRecords[$setting['department_id']][$setting['key']] = $setting['value'];
        }

        if (!systemAccess(100)) {
            $userDepartment = [];
            foreach ($departments as $department) {
                if ($department->id == auth()->user()->department_id) {
                    $userDepartment = $department;
                    break;
                }
            }
            $departments = [$userDepartment];
        }
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
}
