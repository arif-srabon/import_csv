<?php

namespace App\Http\Requests;

class BankBranchRequest extends Request
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
            'name' => 'required|unique_with:bank_branches, bank_id'.($this->id == null?"":",".$this->id),
            'name_bn' => 'unique_with:bank_branches, bank_id'.($this->id == null?"":",".$this->id),
            'contact_person' => 'required',
            'bank_id' => 'required|integer',
            'division_id' => 'required|integer',
            'district_id' => 'required|integer',
            'location_type_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Provide Bank Branch name',
            'name.unique_with' => 'This combination of Name (English), Bank already exists.',
            'name_bn.unique_with' => 'This combination of Name (Bangla), Bank already exists.',
            'contact_person.required' => 'Provide Contact Person',
            'bank_id.required' => 'Select Bank',
            'division_id.required' => 'Select Division',
            'district_id.required' => 'Select District',
            'location_type_id.required' => 'Select Location Type',
        ];
    }
}
