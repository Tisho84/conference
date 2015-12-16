<?php

namespace App\Http\Controllers;

use App\Category;
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
            ->active()
            ->with(['langs' => function($query) {
                $query->lang();
            }])
            ->sort()
            ->get();
    }

    public function getCategoriesAdmin()
    {
        $categories = Category::with('langs')
            //todo where department id when logged
            ->sort()
            ->get();

        $categories->each(function ($category) {
            $category->dbLangs = $category->langs->keyBy('lang_id');
            $category->addVisible('dbLangs');
        });

        return $categories;
    }

}
