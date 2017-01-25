<?php

namespace App\Http\Requests;

class ExitCriteriaRequest extends Request
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
            'criteria_name' => 'required|unique_with:exit_criterias, allowance_programs_id'.($this->id == null?"":",".$this->id),
            'allowance_programs_id' => 'required',
            'selection_criterias_related_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'criteria_name.required' => 'Provide Criteria Name',
            'allowance_programs_id.required' => 'Select Allowance Program',
            'selection_criterias_related_id.required' => 'Select Related to'
        ];
    }
}
