<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class APIController extends ConferenceBaseController
{
    public function categories()
    {
        $records = [];
        $first = true;
        if (request()->has('first') && request('first') == 0) {
            $first = false;
        }

        $categories = getNomenclatureSelect($this->getCategories(request()->get('department_id')), $first);
        foreach ($categories as $id => $value) {
            $records[] = [$id => $value];
        }

        return $records;
    }

    public function reviewers()
    {
        $records = [];
        $records[] = ['' => trans('static.select')];
        $categoryId = request()->get('category_id');
        $departmentId = auth()->user()->department_id;
        if (request()->has('department_id')) {
            $departmentId = request()->get('department_id');
        }

        $reviewers = User::getReviewers($departmentId, $categoryId);
        foreach ($reviewers as $reviewer) {
            $records[] = [$reviewer->id => $reviewer->name];
        }
        return $records;
    }

    public function authors()
    {
        $records = [];
        $records[] = ['' => trans('static.select')];

        $authors = User::getAuthors(request()->get('department_id'));
        foreach ($authors as $author) {
            $records[] = [$author->id => $author->name];
        }
        return $records;
    }

    public function filter()
    {
        session()->set('department_filter_id', (int)request()->get('department_filter_id'));
        return redirect()->back();
    }
}
