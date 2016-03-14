<?php

namespace App\Http\Controllers;

use App\Category;
use App\Department;
use App\UserType;
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
            $departments = $this->loadLangs($departments);
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
            ->with([
                'langs' => function ($query) {
                    $query->lang();
                }
            ])
            ->sort()
            ->get();
    }

    public function getCategoriesAdmin($departmentId)
    {
        if ($departmentId) {
            $categories = Category::with('langs')
                ->where('department_id', $departmentId)
                ->sort()
                ->get();
        } else {
            $categories = Category::with('langs')
                ->sort()
                ->get();
        }
        $categories = $this->loadLangs($categories);
        return $categories;
    }

    public function getDepartmentsAdmin()
    {
        return Department::active()
            ->with([
                'langs' => function($query) {
                    $query->lang();
                }
            ])
            ->sort()
            ->get();
    }

    public function loadLangs($obj)
    {
        $obj->each(function ($type) {
            $type->dbLangs = $type->langs->keyBy('lang_id');
            $type->addVisible('dbLangs');
        });

        return $obj;
    }

    public function getUserTypes($active = false)
    {
        $types = UserType::with('access')->sort();
        return $active ? $types->active()->get() : $types->get();
    }
}
