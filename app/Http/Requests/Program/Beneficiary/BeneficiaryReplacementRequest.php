<?php

namespace App\Http\Requests\Program\Beneficiary;

use App\Http\Requests\Request;

class BeneficiaryReplacementRequest extends Request
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
        return [
            'meeting_id'=>'required',
            'status_id'=>'required',
            'status_changed_date'=>'required',
            'replace_applicant'=>'required',
        ];
    }
}
