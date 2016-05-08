<?php

namespace App\Http\Controllers;

use App\Category;
use App\Classes\Country;
use App\Classes\Rank;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsersController extends ConferenceBaseController
{
    public function getProfile(Rank $rank, Country $country)
    {
        $data = [
            'reviewer' => false,
            'ranks' => $rank->getRanks(),
            'countries' => $country->getCountries(),
            'categories' => getNomenclatureSelect($this->getCategories()),
        ];

        if (auth()->user()->is_reviewer || systemAccess(2)) {
            $data['reviewer'] = true;
            $data['selectedCategories'] = auth()->user()->categories()->lists('id')->toArray();
        }
        return view('conference.profile', $data);
    }

    public function postProfile(Requests\ProfileUpdateRequest $request)
    {
        DB::transaction(function () use ($request) {
            auth()->user()->update($request->all());
            if (auth()->user()->is_reviewer || systemAccess(2)) {
                auth()->user()->categories()->sync($request->get('categories'));
            }

        });

        return redirect()->to(route('department::index', [$request->segment(2)]))->with('success', 'profile-updated');
    }

    public function getChangePassword()
    {
        return view('conference.change_password');
    }

    public function postChangePassword(Request $request, $department)
    {
        $this->validate($request, [
            'password' => 'required',
            'new-password' => 'required|confirmed|min:6',
        ]);

        if (!Hash::check($request->get('password'), auth()->user()->getAuthPassword())) {
            return redirect()->back()->withErrors(trans('auth.password'));
        }


        auth()->user()->fill([
            'password' => Hash::make($request->get('new-password'))
        ])->save();

        return redirect()->to(route('department::index', [$department->keyword]))->with('success', 'profile-updated');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
