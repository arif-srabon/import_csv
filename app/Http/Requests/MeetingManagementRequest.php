<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MeetingManagementRequest extends Request
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
            'allowance_program_id'=>'required',
            'committee_id'=>'required',
        ];
    }
    public function messages(){
        return [
            'allowance_program_id.required' => 'Please select allowance programe',
            'committee_id.required' => 'Please select committee'
        ];
    }
}
