<?php

namespace App\Http\Requests;

class CityCorpPaurasavaRequest extends Request
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
            'name' => 'required|unique_with:city_corp_paurasavas, division_id,district_id,type'.($this->id == null?"":",".$this->id),
            'name_bn' => 'required|unique_with:city_corp_paurasavas,division_id,district_id,type'.($this->id == null?"":",".$this->id),
            'geo_code' => 'required|unique_with:city_corp_paurasavas,geo_code,division_id,district_id,type'.($this->id == null?"":",".$this->id),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Provide name full name',
        ];
    }
}
