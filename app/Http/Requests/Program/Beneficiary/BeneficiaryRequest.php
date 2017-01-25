<?php

namespace App\Http\Requests\Program\Beneficiary;

use App\Http\Requests\Request;

class BeneficiaryRequest extends Request
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
            'allowance_program_id' => 'required',
            'cc_gender_id' => 'required',
            'validity_id' => 'required|unique:beneficiaries,validity_id,'.$this->id,
            'form_sl_no' => 'unique_with:beneficiaries, allowance_program_id'.($this->id == null?"":",".$this->id),
            'bank_account_no' => 'unique_with:beneficiaries, bank_id, bank_branch_id'.($this->id == null?"":",".$this->id),
        ];
    }

    public function messages()
    {
        return [
            'allowance_program_id.required' => 'Select Program',
            'bank_account_no.unique_with' => 'This combination of Account No., Bank, Branch already exists.',
        ];
    }
}
