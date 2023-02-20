<?php

namespace ObeliskAdmin\Http\Requests;

use ObeliskAdmin\Http\Requests\Request;

class UserRequest extends Request
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
        $rules = [
            'username' => 'required|alpha_num|max:20',
            'password' => 'required',
            'fullname' => 'max:100',
            'level' => 'in:Agent,Supervisor,Manager',
            'manual_dial' => 'boolean',
            'active' => 'boolean'
        ];
        
        if ($this->isMethod('put')) {
            unset($rules['password']);
        }
        
        return $rules;
    }
    
    public function messages()
    {
        return [
            'username.required' => 'Username tidak boleh kosong',
            'username.alpha_num' => 'Username hanya boleh alfanumerik saja',
            'username.max' => 'Panjang Username maksimal 20 karakter',
            'password.required' => 'Password tidak boleh kosong',
            'fullname.max' => 'Panjang Full Name maksimal 100 karakter',
            'level.in' => 'Level yang dipilih tidak valid'
        ];
    }
}
