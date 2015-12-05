<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConferenceBaseController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getDepartment()
    {
        return Department::keyword($this->request->segment(2))
            ->with(['langs' => function ($query) {
                $query->lang();
            }])
            ->first();
    }
}
