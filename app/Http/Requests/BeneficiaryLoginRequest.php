<?php

namespace App\Http\Requests;

class BeneficiaryLoginRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'beneficiary_id' => 'required',
            'password' => 'required'
        ];
    }
}
