<?php

namespace ObeliskAdmin\Http\Requests;

use ObeliskAdmin\Http\Requests\Request;

class PasswordRequest extends Request
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
            'old_password' => 'required|password:' . $this->input('old_password'),
            'new_password' => 'required|different:old_password',
            'new_password_confirm' => 'required|same:new_password'
        ];
    }
    
    public function messages()
    {
        return [
            'old_password.required' => 'Password Lama tidak boleh kosong',
            'old_password.password' => 'Password Lama salah',
            'new_password.required' => 'Password Baru tidak boleh kosong',
            'new_password.different' => 'Password Baru tidak boleh sama dengan Password Lama',
            'new_password_confirm.required' => 'Konfirmasi Password Baru tidak boleh kosong',
            'new_password_confirm.same' => 'Konfirmasi Password Baru tidak sama'
        ];
    }
}
