<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterRequest extends Request
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
            'email' => 'required|min:2|unique:users,email,'.$this->id,
            'full_name' => 'required|min:5',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5',
            'profession'  => 'required|min:2',
            'mobile'  => 'required|min:6',
            'district_id'=> 'required|integer',
            'upazilla_id'=> 'required|integer',
            'address'  => 'required|min:3',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
