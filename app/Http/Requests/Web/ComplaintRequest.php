<?php
/**
 * Front End: Complaint Request
 *
 * @author  Mayeenul Islam
 * @since   1.0.0
 */

namespace App\Http\Requests\Web;

use App\Http\Requests\Request;

class ComplaintRequest extends Request
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
            'complaint_type_id' => 'required',
            'full_name'         => 'required',
            'profession'        => 'required',
            'district_id'       => 'required',
            'upazilla_id'       => 'required',
            'email'             => 'required',
            'phone'             => 'required',
        ];
    }

    public function messages()
    {
        return [
            'complaint_type_id.required' => 'Please select a type of your complaint',
            'full_name.required'         => 'Provide the Name Please',
            'profession.required'        => 'Please enter your Profession',
            'district_id.required'       => 'Select a District Please',
            'upazilla_id.required'       => 'Select an Upazilla Please',
            'email.required'             => 'Your email address is required',
            'phone.required'             => 'Your phone number is required',
        ];
    }
}
