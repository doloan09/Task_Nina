<?php

namespace App\Http\Requests;

class ClassRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_class'  => ['required', 'unique:classes'],
            'code_class'  => ['required'],
            'id_subject'  => ['required'],
            'id_semester' => ['required'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'name_class.required'   => 'Tên lớp học phần không được bỏ trống!',
            'name_class.unique'   => 'Tên lớp học phần phải là duy nhất!',
            'code_class.required' => 'Mã lớp học phần không được bỏ trống!',
            'id_subject.required' => 'Mã môn học không được bỏ trống!',
            'id_semester.required' => 'Mã kỳ học không được bỏ trống!',
        ];
    }
}
