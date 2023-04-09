<?php

namespace App\Http\Requests;

class SubjectRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_subject'      => ['required'],
            'code_subject'      => ['required'],
            'number_of_credits' => ['required', 'numeric'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'name_subject.required'      => 'Tên môn học không được bỏ trống!',
            'code_subject.required'      => 'Mã môn học không được bỏ trống!',
            'number_of_credits.required' => 'Số tín chỉ không đúng định dạng!',
            'number_of_credits.numeric' => 'Số tín chỉ không đúng định dạng!',
        ];
    }
}
