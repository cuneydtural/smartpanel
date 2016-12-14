<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'    => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Lütfen geçerli bir e-mail adresi yazınız.',
            'email.required' => 'E-Mail gereklidir.',
            'password.required' => 'Şifre gereklidir.'
        ];
    }

    public function forbiddenResponse()
    {
        return abort(503);
    }

}
