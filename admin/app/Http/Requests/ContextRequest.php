<?php

namespace ObeliskAdmin\Http\Requests;

use ObeliskAdmin\Http\Requests\Request;

class ContextRequest extends Request
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
            'context' => 'required|alpha_dash|max:79|not_in:create,' . $this->route()->parameter('name')
        ];
    }
    
    public function messages()
    {
        return [
            'context.required' => 'Context tidak boleh kosong',
            'context.alpha_dash' => 'Context hanya boleh alfanumerik, underscore(_) dan dash(-)',
            'context.max' => 'Panjang Context maksimal 79 karakter',
            'context.not_in' => 'Context tersebut tidak bisa digunakan'
        ];
    }
}
