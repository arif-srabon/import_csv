<?php

namespace App\Http\Requests\Program\ApplicantVerification;
use App\Http\Requests\Request;

class BeneficiaryApplicantVerificationByUnionWardRequest extends Request
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
            'verified_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'verified_date.required' => 'Provide Date',
        ];
    }
}
