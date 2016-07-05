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
        $settings = $this->getDepartment()->settings()->key('user_data');
        $disabled = '';
        if (isset($settings->value) && $settings->value) {
            session()->put('warning', 'lock-data');
            $disabled = 'disabled';
        }
        if (auth()->user()->is_reviewer || systemAccess(2)) {
            $data['reviewer'] = true;
            $data['selectedCategories'] = auth()->user()->categories()->lists('id')->toArray();
        }
        $data['disabled'] = $disabled;

        return view('conference.profile', $data);
    }

    public function postProfile(Requests\ProfileUpdateRequest $request)
    {
        $settings = $this->getDepartment()->settings()->key('user_data');
        if (isset($settings->value) && $settings->value) {
            return redirect()->back()->with('error', 'access-denied');
        }

        DB::transaction(function () use ($request) {
            auth()->user()->update($request->all());
            if (auth()->user()->is_reviewer || systemAccess(2)) {
                auth()->user()->categories()->sync((array)$request->get('categories'));
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
}
