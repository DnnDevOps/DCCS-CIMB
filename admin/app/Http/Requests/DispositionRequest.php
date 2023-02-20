<?php

namespace ObeliskAdmin\Http\Requests;

use ObeliskAdmin\Http\Requests\Request;

class DispositionRequest extends Request
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
            'disposition' => 'required|max:45',
            'skip_contact' => 'sometimes|boolean'
        ];
    }
    
    public function messages()
    {
        return [
            'disposition.required' => 'Disposition tidak boleh kosong',
            'disposition.max' => 'Panjang Disposition maksimal 45 karakter'
        ];
    }
}
