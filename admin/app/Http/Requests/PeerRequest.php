<?php

namespace ObeliskAdmin\Http\Requests;

use ObeliskAdmin\Http\Requests\Request;

class PeerRequest extends Request
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
            'peer' => 'required|alpha_dash|max:79'
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Peer tidak boleh kosong',
            'name.alpha_dash' => 'Peer hanya boleh alfanumerik, underscore(_) dan dash(-)',
            'name.max' => 'Panjang Peer maksimal 50 karakter'
        ];
    }
}
