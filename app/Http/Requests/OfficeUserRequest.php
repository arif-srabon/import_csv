<?php

namespace App\Http\Requests;

class OfficeUserRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|unique_with:office_users, office_id'.($this->id == null?"":",".$this->id),
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Select User',
        ];
    }
}
