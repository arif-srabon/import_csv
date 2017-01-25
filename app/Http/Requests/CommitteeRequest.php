<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CommitteeRequest extends Request
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
            'allowance_programs_id'=>'required',
            'committee_template'=>'required',
            //sprintf( 'committee_role_id.%d', 0 )=>'required',
        ];

    }
    public function messages(){
        return [
            'allowance_programs_id.required' => 'Please select allowance programe',
            'committee_template.required' => 'Provide committee template'
        ];
    }
}
