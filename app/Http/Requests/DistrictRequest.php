<?php

namespace App\Http\Requests;

class DistrictRequest extends Request
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
            'division_id' => 'required',
            'geo_code' => 'required|unique_with:districts,division_id'.($this->id == null?"":",".$this->id),
            'name' => 'required|unique_with:districts,division_id'.($this->id == null?"":",".$this->id),
            'name_bn' => 'unique_with:districts,division_id'.($this->id == null?"":",".$this->id)
        ];
    }

    public function messages()
    {
        return [
            'division_id.required' => 'Select Division',
            'geo_code.required' => 'Provide GEO Code',
            'name.required' => 'Provide district name',
        ];
    }
}
