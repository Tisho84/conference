<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //TODO conference
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        foreach (LaravelLocalization::getSupportedLocales() as $short => $locale) {
            $rules['name_' . $short] = 'required|min:2|max:100';
        }
        $rules['sort'] = 'digits_between:1,';

        return $rules;
    }
}
