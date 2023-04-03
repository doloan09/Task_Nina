<?php

namespace App\Http\Requests;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        return [
          'email.required' => 'Email không được bỏ trống!',
          'email.email' => 'Email không đúng định dạng!',
          'password.required' => 'Password không được bỏ trống!',
        ];
    }

}
