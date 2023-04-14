<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id_class' => 'required',
            'id_user'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id_class.required' => 'Lớp học phần không được bỏ trống!',
            'id_user.required'  => 'Giảng viên không được bỏ trống!',
        ];
    }
}
