<?php

namespace App\Http\Requests;

class OfficeRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'office_code' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'office_code.required' => 'Provide Office Code',
            'name.required' => 'Provide Office Name'
        ];
    }
}
