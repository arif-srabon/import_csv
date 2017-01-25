<?php
/**
 * Manufacturer Request
 *
 * @author  Mayeenul Islam
 * @since   1.0.0
 */

namespace App\Http\Requests;

class ManufacturerRequest extends Request
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
            'code'         => 'required',
            'code_non_bio' => 'required',
            'name'         => 'required',
            'name_bn'      => 'required',
            'division_id'  => 'required',
            'district_id'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required'         => 'Provide a Biological Code Please',
            'code_non_bio.required' => 'Provide a Non-Biological Code Please',
            'name.required'         => 'Provide the Name Please',
            'name_bn.required'      => 'Provide a Bengali name Please',
            'division_id.required'  => 'Select a Division Please',
            'district_id.required'  => 'Select a District Please',
        ];
    }
}
