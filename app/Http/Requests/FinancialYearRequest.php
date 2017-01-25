<?php

namespace App\Http\Requests;

class FinancialYearRequest extends Request
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
            'year_range' => 'required|unique:financial_years,year_range,'.$this->id
        ];
    }

    public function messages()
    {
        return [
            'criteria_name.required' => 'Provide Criteria Name'
        ];
    }
}
