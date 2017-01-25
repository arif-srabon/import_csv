<?php
/**
 * Front End: ADR Request
 *
 * @author  Mayeenul Islam
 * @package adr_dgda/web
 * @since   1.0.0
 */

namespace App\Http\Requests\Web;

use App\Http\Requests\Request;

class ADRRequest extends Request
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
            'experienced_by'           => 'required',
            'patient_name'             => 'required',
            'patient_gender'           => 'required',
            'patient_age'              => 'required',
            'patient_weight'           => 'required',
            'patient_height'           => 'required',
            'event_starting_dt'        => 'required',
            'event_stop_dt'            => 'required',
            'event_reporting_dt'       => 'required',
            'suspected_medicine'       => 'required',
            'manufacturer'             => 'required',
            'dose_start_dt'            => 'required',
            'dose_stop_dt'             => 'required',
            'adverse_effects'          => 'required',
            'is_medicine_three_months' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'experienced_by.required'           => 'You should choose who experienced the adverse effect',
            'patient_name.required'             => 'Please provide the name of the patient',
            'patient_gender.required'           => 'Gender of the patient is required',
            'patient_age.required'              => 'Age of the patient is required',
            'patient_weight.required'           => 'Weight of the patient is required',
            'patient_height.required'           => 'Height of the patient is required',
            'event_starting_dt.required'        => 'Event starting date is required',
            'event_stop_dt.required'            => 'The date event stopped is required',
            'event_reporting_dt.required'       => 'The date event was reported is required',
            'suspected_medicine.required'       => 'Please provide the name of the medicine',
            'manufacturer.required'             => 'Name of the manufacturer is required',
            'dose_start_dt.required'            => 'Starting date of the dose is required',
            'dose_stop_dt.required'             => 'Date the dose stopped is required',
            'adverse_effects.required'          => 'Adverse Effects field is required',
            'is_medicine_three_months.required' => 'You must mention whether any medicine is taken in three months'
        ];
    }
}
