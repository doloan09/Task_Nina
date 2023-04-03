<?php

namespace App\Http\Requests;

class UserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'     => ['required'],
            'email'    => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Username không được bỏ trống!',
            'email.required'    => 'Email không được bỏ trống!',
            'email.email'       => 'Email không đúng định dạng!',
            'email.unique'      => 'Email phải là duy nhất!',
            'password.required' => 'Password không được bỏ trống!',
            'password.min'      => 'Password phải chứa ít nhất 8 ký tự!',
        ];
    }

}
