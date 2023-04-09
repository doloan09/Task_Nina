<?php

namespace App\Http\Requests;

class SemesterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_semester'      => ['required'],
            'year_semester'      => ['required'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'name_semester.required'      => 'Tên kỳ không được bỏ trống!',
            'year_semester.required'      => 'Năm học không được bỏ trống!',
        ];
    }
}
