<?php

namespace ObeliskAdmin\Http\Requests;

use ObeliskAdmin\Http\Requests\Request;

class TrunkRequest extends Request
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
        $rules =  [
            'trunk' => 'required|alpha_dash|max:79',
            'defaultuser' => 'required|alpha_dash',
            'secret' => 'required',
            'host' => 'required|ip',
            'context' => 'required|max:79'
        ];
        
        if ($this->isMethod('put')) {
            unset($rules['secret']);
        }
        
        return $rules;
    }
    
    public function messages()
    {
        return [
            'trunk.required' => 'Nama Trunk tidak boleh kosong',
            'trunk.alpha_dash' => 'Nama Trunk hanya boleh alfanumerik, underscore(_) dan dash(-)',
            'trunk.max' => 'Panjang Nama Trunk maksimal 79 karakter',
            'defaultuser.required' => 'Username tidak boleh kosong',
            'defaultuser.alpha_dash' => 'Username hanya boleh alfanumerik, underscore(_) dan dash(-)',
            'secret.required' => 'Password tidak boleh kosong',
            'host.required' => 'Host tidak boleh kosong',
            'host.ip' => 'Format Host tidak valid',
            'context.required' => 'Context tidak boleh kosong',
            'context.max' => 'Panjang Context maksimal 79 karakter'
        ];
    }
}
