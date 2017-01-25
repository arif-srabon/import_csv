<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NewsRequest extends Request
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
            'title' => 'required|min:3|unique:news,title,'.$this->id,
            'published_dt' => 'required',
            'status' => 'required|integer',
            'details' => 'required|min:3',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
