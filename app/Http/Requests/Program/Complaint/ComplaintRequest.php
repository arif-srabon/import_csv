<?php

namespace App\Http\Requests\Program\Complaint;

use App\Http\Requests\Request;

class ComplaintRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tracking_number' => 'unique:complaints,tracking_number,'.$this->id,
            'division_id' => 'required',
            'district_id' => 'required',
            'complaint_type_id' => 'required',
            'complaint_title' => 'required',
            'complaint_details' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'division_id.required' => 'Provide Division.',
            'district_id.required' => 'Provide District.',
            'complaint_type_id.required' => 'Provide Complaint Type.',
            'complaint_title.required' => 'Provide Complaint Title',
            'complaint_details.required' => 'Provide Complaint Details'
        ];
    }
}
