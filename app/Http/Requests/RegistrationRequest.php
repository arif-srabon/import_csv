<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegistrationRequest extends Request
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
            'client_id' => 'required|unique_with:jpu_registration,idsc_center_id' . ($this->id == null ? "" : "," . $this->id),
            'registration_date' => 'required',
            'client_name' => 'required|min:3|unique_with:jpu_registration,birth_certificate_no' . ($this->id == null ? "" : "," . $this->id),
            'date_of_birth' => 'required',
            'gender_id' => 'required',
            'house_no' => 'required',
            'district_id' => 'required',
            'upazilla_id' => 'required',
            'post_code' => 'required',
            'mobile' => 'required|min:11',
            'email' => 'email',
            'education_qualification_id' => 'required',
            'professional_id' => 'required',
            'living_house_id' => 'required',
            'family_member' => 'numeric',
            'earning_family_member' => 'numeric',
            'father_name' => 'min:3',
            'husband_name' => 'min:3',
            'mother_name' => 'min:3',
            'guardian_name' => 'min:3',
            'village' => 'min:3',
            'main_problem' => 'min:5',
            'expectation' => 'min:5',
            'national_id' => 'min:13|max:17|unique_with:jpu_registration,client_name,national_id_type' . ($this->id == null ? "" : "," . $this->id),
            'national_id_type' => 'required_with:national_id',
            'client_photo' => 'image|mimes:png,jpeg'
        ];
    }

//    public function all()
//    {
//        $input = parent::all();
//        $input['client_id'] = $input['client_prefix'] . $input['client_id'];
//        return $input;
//    }

    public function messages()
    {
        return [
            'client_id.required' => 'Provide Client Id',
            'client_name.required' => 'Provide Patient Full Name in English',
            'district_id.required' => 'Select District',
            'upazilla_id.required' => 'Select Upazila',
            'post_code.required' => 'Select Post Code',
            'education_qualification_id.required' => 'Select Educational Qualification',
            'professional_id.required' => 'Select Profession or Occupation',
            'living_house_id.required' => 'Select House Type',
        ];
    }
}
