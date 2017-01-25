<?php
/**
 * ADR Reporting Request
 *
 * @author  Mayeenul Islam
 * @since   1.0.0
 */

namespace App\Http\Requests;

class ADRReportingRequest extends Request
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
            /*'status_id' => 'required',
            'advice_id' => 'required',*/
        ];
    }

    public function messages()
    {
        return [
            /*'status_id.required' => 'Choose a status',
            'advice_id.required' => 'Choose an advice'*/
        ];
    }
}
