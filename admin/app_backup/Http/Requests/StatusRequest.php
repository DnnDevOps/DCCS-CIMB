<?php

namespace ObeliskAdmin\Http\Requests;

use ObeliskAdmin\Http\Requests\Request;

class StatusRequest extends Request
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
            'status' => 'required|not_in:Not Ready,Ready|max:20'
        ];
    }
    
    public function messages()
    {
        return [
            'status.required' => 'Status tidak boleh kosong',
            'status.not_in' => 'Status tidak valid',
            'status.max' => 'Panjang Status maksimal 20 karakter'
        ];
    }
}
