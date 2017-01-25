<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CommitteeMemberRequest extends Request
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
            'committee_id'=>'required',
            'committee_name'=>'required',
        ];

    }
    public function messages()
    {
        return [
            'committee_id.required' => 'Please select committee template',
            'committee_name.required' => 'Provide committee name'
        ];
    }
}
