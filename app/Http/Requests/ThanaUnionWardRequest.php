<?php

namespace App\Http\Requests;

class ThanaUnionWardRequest extends Request
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
            'name' => 'required|unique_with:wards, name,division_id,district_id,thana_upazila_id,union_ward_id'.($this->id == null?"":",".$this->id),
            'name_bn' => 'unique_with:wards, name,division_id,district_id,thana_upazila_id,union_ward_id'.($this->id == null?"":",".$this->id),
            'geo_code' => 'required|unique_with:wards,geo_code,division_id,district_id,thana_upazila_id,union_ward_id'.($this->id == null?"":",".$this->id),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Provide name',
        ];
    }
}
