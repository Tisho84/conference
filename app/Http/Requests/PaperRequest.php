<?php

namespace App\Http\Requests;

use App\Classes\PaperStatus;
use App\Http\Requests\Request;

class PaperRequest extends Request
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
        $rules = [
            'category_id' => 'required|exists:category,id',
            'title'       => 'required|min:3|max:255',
            'description' => 'min:3|max:1000',
            'paper'       => 'required|max:10000|mimes:pdf,doc,docx',
            'authors'     => 'required|min:3|max:1000',
        ];

        if (isAdminPanel()) {
            $paper = new PaperStatus();
            $rules['user_id'] = 'required|exists:users,id';
            $rules['payment_description'] = 'min:3|max:1000';
            $rules['payment_source'] = 'image|max:5000';
            $rules['status_id'] = 'required|between:1,' . count($paper->getStatuses());
        }

        if ($this->request->get('id')) { #update request1
            if (!$this->request->get('paper')) {
                $rules['paper'] = '';
            }
        }

        return $rules;
    }
}
