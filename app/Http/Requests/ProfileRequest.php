<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfileRequest extends Request
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
            'full_name' => 'required|min:5',
            'designation_id' => 'required|integer',
            'user_photo' => 'image|mimes:png,jpeg|image_size:<=600',
            'mobile'  => 'min:3',
            'national_id'  => 'min:13'
        ];
    }
}
