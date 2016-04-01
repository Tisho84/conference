<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DepartmentRequest extends Request
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
        $imageMax = 500;
        $rules = [
            'keyword' => 'required|max:6|unique:department,keyword',
            'url'     => 'required',
            'image'   => 'required|image|max:' . $imageMax,
            'theme_background_color' => 'required',
            'theme_color' => 'required',
            'sort'    => 'digits_between:1,100000'
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $short => $locale) {
            $rules['name_' . $short] = 'required|min:2|max:100';
            $rules['title_' . $short] = 'required|min:2|max:254';
            $rules['description_' . $short] = 'required|min:2|max:100';
        }

        $id = $this->request->get('id');
        if ($id) { #update request
            $rules['keyword'] .= ',' . $id;
            if (!$this->request->get('image')) {
                $rules['image'] = '';
            }
        }

        return $rules;
    }

    protected function formatErrors(Validator $validator)
    {
        if (count($validator->errors()->getMessages()) > 8) {
            return [trans('messages.many-errors')];
        }
        return $validator->errors()->all();
    }
}
