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
        $categories = getNomenclatureSelect($this->getCategories(request()->get('department_id')), true);
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
}
