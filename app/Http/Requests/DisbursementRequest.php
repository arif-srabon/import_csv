<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DisbursementRequest extends Request
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
            'allocation_program_id' => 'required|integer|unique_with:disbursement_allocation,installment_id,district_id' . ($this->id == null ? "" : "," . $this->id),
            'installment_id' => 'required|integer',
            'district_id' => 'required|integer',
            'bank_id' => 'required|numeric'
        ];
    }
}
