<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AllocationRequest extends Request
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
            'allocation_program_id' => 'required|integer|unique_with:allocation_allotment, installment_id' . ($this->id == null ? "" : "," . $this->id),
            'installment_id' => 'required|integer',
            'cheque_scan_copy' => 'image|mimes:png,jpeg|image_size:<=600',
            'main_bank_id' => 'integer',
            'monthly_amount' => 'numeric'
        ];
    }
}
