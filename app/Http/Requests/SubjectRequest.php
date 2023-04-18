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
            'name_subject'      => ['required', 'unique:subjects,name_subject,'.$this->route('id') ?? 0],
            'code_subject'      => ['required', 'unique:subjects,code_subject,'.$this->route('id') ?? 0],
            'number_of_credits' => ['required', 'numeric', 'gt:0'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'name_subject.required'      => 'Tên môn học không được bỏ trống!',
            'name_subject.unique'      => 'Tên môn học phải là duy nhất!',
            'code_subject.required'      => 'Mã môn học không được bỏ trống!',
            'code_subject.unique'      => 'Mã môn học phải là duy nhất!',
            'number_of_credits.required' => 'Số tín chỉ không đúng định dạng!',
            'number_of_credits.numeric' => 'Số tín chỉ không đúng định dạng!',
            'number_of_credits.gt' => 'Số tín chỉ phải lớn hơn 0!',
        ];
    }
}
