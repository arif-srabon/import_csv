<?php

namespace App\Http\Requests;

class BuildAllowanceProgramWiseTableNameRequest extends Request
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
            'allowance_program_id' => 'required|unique:beneficiary_table_names,allowance_program_id'.($this->id == null?"":",".$this->id),
            'table_caption' => 'required|unique_with:beneficiary_table_names,allowance_program_id'.($this->id == null?"":",".$this->id)
        ];
    }

    public function messages()
    {
        return [
            'allowance_program_id.required' => 'Select Program',
            'table_caption.required' => 'Select Program'
        ];
    }
}
