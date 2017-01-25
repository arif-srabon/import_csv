<?php

namespace App\Http\Requests\Program\Complaint;

use App\Http\Requests\Request;

class ComplaintResolutionProcessRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'complaint_status_id' => 'required',
            'resolution_date' => 'required',
            'resolution_details' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'resolution_date.required' => 'Provide Resolution Date',
            'complaint_status_id.required' => 'Select Status',
            'resolution_details.required' => 'Provide Resolution Details'
        ];
    }
}
