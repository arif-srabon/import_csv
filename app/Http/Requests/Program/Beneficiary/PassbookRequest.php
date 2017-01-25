<?php

namespace App\Http\Requests\Program\Beneficiary;

use App\Http\Requests\Request;

class PassbookRequest extends Request
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
            'beneficiary_id' => 'required|unique:passbooks,beneficiary_id,'.$this->id,
            'book_no' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'beneficiary_id.required' => 'Provide beneficiary ID',
            'book_no.required' => 'Provide Book No.'
        ];
    }
}
