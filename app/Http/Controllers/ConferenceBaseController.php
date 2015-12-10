<?php

namespace App\Http\Controllers;

use App\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ConferenceBaseController extends Controller
{
    public function getDepartment()
    {
        $department = null;
        $departments = $this->getDepartments();
        foreach ($departments as $dept) {
            if ($dept->keyword == app()->request->segment(2)) {
                $department = $dept;
                break;
            }
        }
        return $department;
    }

    public function getDepartments()
    {
        if (!Cache::has('departments')) {
            $departments = Department::active()
                ->sort()
                ->with('langs')
                ->get();
            $departments->each(function ($department) {
                $department->dbLangs = $department->langs->keyBy('lang_id');
                $department->addVisible('dbLangs');
            });
            Cache::put('departments', $departments, Carbon::now()->addHour());
        } else {
            $departments = Cache::get('departments');
        }
        return $departments;
    }

    public function getCategories()
    {
        return $this->getDepartment()
            ->categories()
            ->with(['langs' => function($query) {
                $query->lang();
            }])->get();
    }

}
