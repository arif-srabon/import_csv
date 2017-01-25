<?php

namespace App\Http\Requests;

class SelectionCriteriaRequest extends Request
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
            'criteria_name' => 'required|unique_with:selection_criterias, criteria_name,allowance_program_id'.($this->id == null?"":",".$this->id),
            'selection_criterias_related_id' => 'required|unique_with:selection_criterias,selection_criterias_related_id,allowance_program_id'.($this->id == null?"":",".$this->id),
            'allowance_program_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'criteria_name.required' => 'Provide criteria name',
            'selection_criterias_related_id.required' => 'Provide related to',
            'allowance_program_id.required' => 'Provide allowance program',
        ];
    }
}
