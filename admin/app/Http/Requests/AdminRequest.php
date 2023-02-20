<?php

namespace ObeliskAdmin\Http\Requests;

use ObeliskAdmin\Http\Requests\Request;

class AdminRequest extends Request
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
            'username' => 'required|alpha_num|max:255',
            'password' => 'required',
            'fullname' => 'max:50',
            'role_id' => 'required|exists:roles,id'
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
            'username.max' => 'Panjang Username maksimal 255 karakter',
            'password.required' => 'Password tidak boleh kosong',
            'fullname.max' => 'Panjang Full Name maksimal 50 karakter',
            'role_id.required' => 'Role tidak boleh kosong',
            'role_id.exists' => 'Role yang dipilih tidak valid'
        ];
    }
}
