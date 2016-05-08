<?php

namespace App\Http\Requests;

use app\Classes\CriteriaType;
use App\Http\Requests\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CriteriaRequest extends Request
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
     *
     * @return array
     */
    public function rules()
    {
        $types = new CriteriaType();
        $rules = ['type_id' => 'required'];
        foreach (LaravelLocalization::getSupportedLocales() as $short => $locale) {
            $rules['title_' . $short] = 'required|min:2|max:254';
        }
        $rules['sort'] = 'digits_between:1,100000';
        return $rules;
    }
}
