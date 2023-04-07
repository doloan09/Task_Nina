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
            'name'          => ['required'],
            'email'         => ['required', 'email', 'unique:users'],
            'code_user'     => ['required', 'unique:users'],
            'date_of_birth' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'          => 'Username không được bỏ trống!',
            'email.required'         => 'Email không được bỏ trống!',
            'email.email'            => 'Email không đúng định dạng!',
            'email.unique'           => 'Email phải là duy nhất!',
            'code_user.required'     => 'Mã sinh viên/ Mã nhân viên không được bỏ trống!',
            'code_user.unique'     => 'Mã sinh viên/ Mã nhân viên phải là duy nhất!',
            'date_of_birth.required' => 'Ngày sinh không được bỏ trống!',
        ];
    }

}
