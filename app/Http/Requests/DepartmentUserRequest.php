<?php

namespace App\Http\Requests;

use App\Classes\Country;
use App\Classes\Rank;
use App\Http\Requests\Request;

class DepartmentUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @param Rank $rank
     * @param Country $country
     * @return array
     */
    public function rules(Rank $rank, Country $country)
    {
        $userId = $this->request->has('user_id') ? $this->request->get('user_id') : null;
        $department = $this->request->has('department_id') ? $this->request->get('department_id') : auth()->user()->department_id;
        return [
            'rank_id' => 'in:' . implode(',', array_keys($rank->getRanks())),
            'name' => 'required|max:255|min:4',
            'phone' => 'max:30|min:5|regex:' . config('auth.expressions.phone'),
            'address' => 'required|max:255|min:4',
            'institution' => 'required|max:100|min:4',
            'country_id' => 'required|in:' . implode(',', array_keys($country->getCountries())),
            'user_type_id' => 'required|exists:user_type,id',
            'email' => 'required|email|max:255|unique:users,email,' . $userId  . ',id,department_id,' . $department,
            'email2' => 'email|max:255',
            'password' => $userId ? 'confirmed|min:6' : 'required|confirmed|min:6',
            'categories' => 'exists:category,id'
        ];
    }
}
