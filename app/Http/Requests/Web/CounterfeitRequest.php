<?php
/**
 * Front End: Counterfeit Request
 *
 * @author  Mayeenul Islam
 * @since   1.0.0
 */

namespace App\Http\Requests\Web;

use App\Http\Requests\Request;

class CounterfeitRequest extends Request
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
            'incident_aftermath' => 'required',
            'suspected_medicine' => 'required',
            'manufacturer'       => 'required',
            'expiry_dt'          => 'required',
        ];
    }

    public function messages()
    {
        return [
            'incident_aftermath.required' => 'Please choose what the incident aftermath is',
            'suspected_medicine.required' => 'Please provide the name of the medicine',
            'manufacturer.required'       => 'Please provide the name of the manufacturer of the medicine',
            'expiry_dt.required'          => 'Please enter the Date of Expiry of the medicine',
        ];
    }
}
