<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AllowanceProgramRequest extends Request
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
            'program_code' => 'required|min:2|unique:allowance_programs,program_code,'.$this->id,
            'name' => 'required|min:3|unique:allowance_programs,name,'.$this->id
        ];
    }

    public function messages()
    {
        return [
            'center_name.required' => 'Provide program code',
            'division_id.integer' => 'Provide name',
        ];
    }
}
