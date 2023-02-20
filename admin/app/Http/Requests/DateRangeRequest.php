<?php

namespace ObeliskAdmin\Http\Requests;

use ObeliskAdmin\Http\Requests\Request;

class DateRangeRequest extends Request
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
            'from_date' => 'required_with:to_date|date|before:to_date',
            'to_date' => 'required_with:from_date|date|after:from_date'
        ];
    }
    
    public function messages()
    {
        return [
            'from_date.required_with' => 'Sampai Dengan tidak boleh kosong',
            'from_date.date' => 'Mulai Dari harus berformat tanggal',
            'from_date.before' => 'Mulai Dari tidak boleh lebih dari Sampai Dengan',
            'to_date.required_with' => 'Mulai Dari tidak boleh kosong',
            'to_date.date' => 'Sampai Dengan harus berformat tanggal',
            'to_date.after' => 'Sampai Dengan tidak boleh kurang dari Mulai Dari'
        ];
    }
}
