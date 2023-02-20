<?php

namespace ObeliskAdmin\Http\Requests;

use ObeliskAdmin\Http\Requests\Request;

class CampaignRequest extends Request
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
            'name' => 'required|alpha_dash|max:50',
            'begin_time' => 'required',
            'finish_time' => 'required',
            'screen_pop_url' => 'max:150'
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Nama Campaign tidak boleh kosong',
            'name.alpha_dash' => 'Nama Campaign hanya boleh alfanumerik, underscore(_) dan dash(-)',
            'name.max' => 'Panjang Nama Campaign maksimal 50 karakter',
            'begin_time.required' => 'Waktu Mulai tidak boleh kosong',
            'finish_time.required' => 'Waktu Selesai tidak boleh kosong',
            'screen_pop_url.max' => 'Panjang Screen Pop URL maksimal 150 karakter'
        ];
    }
}
