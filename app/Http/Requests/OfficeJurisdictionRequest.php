<?php

namespace App\Http\Requests;

class OfficeJurisdictionRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'allowance_program_id' => 'required',
            'union_ward_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'allowance_program_id.required' => 'Select Program',
            'union_ward_id.required' => 'Select Select Union/Municipal Ward'
        ];
    }
}
