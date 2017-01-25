<?php

namespace App\Http\Requests;

class CityCorpZoneRequest extends Request
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
            'zone_name' => 'required|unique_with:city_corp_zones, city_corp_paurasava_id'.($this->id == null?"":",".$this->id),
            'city_corp_paurasava_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'zone_name.required' => 'Provide Zone Name',
            'city_corp_paurasava_id.required' => 'Select City Corp.'
        ];
    }
}
