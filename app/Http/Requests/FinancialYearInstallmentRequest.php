<?php

namespace App\Http\Requests;

class FinancialYearInstallmentRequest extends Request
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
            'installment_name' => 'required|unique_with:financial_year_installments, financial_year_id'.($this->id == null?"":",".$this->id),
        ];
    }

    public function messages()
    {
        return [
            'installment_name.required' => 'Provide Name'
        ];
    }
}
