<?php

namespace ObeliskAdmin\Http\Requests;

use ObeliskAdmin\Http\Requests\Request;

class ExtensionRequest extends Request
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
            'extension' => 'required|max:79|not_in:extension,edit,include',
            'macro' => 'required|in:dial-trunk,dial-peer,enter-queue'
        ];
    }
    
    public function messages()
    {
        return [
            'extension.required' => 'Extension tidak boleh kosong',
            'extension.max' => 'Panjang Extension maksimal 79 karakter',
            'extension.not_in' => 'Extension tersebut tidak dapat digunakan',
            'macro.required' => 'Macro tidak boleh kosong',
            'macro.in' => 'Macro yang dipilih tidak valid'
        ];
    }
}
