<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'first_last_name'  => 'required',
            'second_last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'country'=> 'required',
            'birthdate' => 'required',
            'phone' => 'required'
        ];
    }
}