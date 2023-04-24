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
            'name_semester' => ['required'],
            'year_semester' => ['required'],
            'start_time'    => ['required'],
            'end_time'      => ['required'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'name_semester.required' => 'Tên kỳ không được bỏ trống!',
            'year_semester.required' => 'Năm học không được bỏ trống!',
            'start_time.required'    => 'Thời gian bắt đầu không được bỏ trống!',
            'end_time.required'      => 'Thời gian kết thúc không được bỏ trống!',
        ];
    }
}
