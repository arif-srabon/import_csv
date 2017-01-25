<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ImportFileRequest extends Request
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

            'type' => 'required',
//            'import_file' => 'required|mimes:csv',

        ];
    }
    public function messages()
    {
        return [
//            'type.required' => 'Select File Type',
//            'name.required' => 'Provide Bank Branch name',
        ];
    }
}
