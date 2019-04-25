<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProfileRequest extends FormRequest
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
            'name' => 'required',
            'user_name'  => 'required|unique:profiles',
            'key' => 'required|min:1|max:6',
            'age' => 'required|numeric',
            'id_father'=> 'required'
        ];
    }
}