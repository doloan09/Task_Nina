<?php

namespace App\Http\Requests;

class ResetPassRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => 'required', 'min:8', 'confirmed',
        ];
    }

    public function messages()
    {
        return [
            'token.required' => 'Token không được bỏ trống!',
            'email.required' => 'Email không được bỏ trống!',
            'email.email' => 'Email không đúng định dạng!',
            'password.required' => 'Mật khẩu không được bỏ trống!',
            'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự!',
            'password.confirmed' => 'Mật khẩu phải trùng nhau!',
        ];
    }

}
