<?php

namespace App\Http\Requests;

class ForgotPassRequest extends BaseRequest
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
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được bỏ trống!',
            'email.email' => 'Email không đúng định dạng!',
        ];
    }

}
