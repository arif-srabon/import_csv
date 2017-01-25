<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MedicinecodeRequest extends Request
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
            //'medicine_id' => 'required|unique_with:medicine_id,batch_lot_no'.($this->id == null?"":",".$this->id),
            'medicine_id' => 'required',
            'batch_lot_no' => 'required',
            'generate_date' => 'required',
            'total_codes' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
