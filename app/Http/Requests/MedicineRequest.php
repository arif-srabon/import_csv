<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MedicineRequest extends Request
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
            'name' => 'required|min:2|unique:medicine,name,'.$this->id,
            'generic_id' => 'required|integer',
            'medicine_type_id' => 'required|integer',
            'user_photo' => 'image|mimes:png,jpeg|image_size:<=600',
            'price'  => 'numeric',
            'presentation' => 'required',
            'descriptions' => 'required',
            'indications' => 'required',
            'dosage_administration' => 'required',
            'side_effects' => 'required',
            'precaution' => 'required',
        ];
    }

    public function messages()
    {
        return [
            //'name.required' => 'Provide name',
        ];
    }
}
