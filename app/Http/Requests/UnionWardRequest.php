<?php

namespace App\Http\Requests;

class UnionWardRequest extends Request
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
            'name' => 'required',
            'geo_code' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Provide name',
        ];
    }
}
