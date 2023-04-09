<?php

namespace App\Http\Requests;

class PointRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'score_component' => ['required'],
            'score_test'      => ['required'],
            'score_final'     => ['required'],
            'id_user'         => ['required'],
            'id_class'        => ['required'],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'score_component.required' => 'Điểm thành phần không được bỏ trống!',
            'score_test.required'      => 'Điểm thi không được bỏ trống!',
            'score_final.required'     => 'Điểm tổng kết không được bỏ trống!',
            'id_user.required'         => 'Mã sinh viên không được bỏ trống!',
            'id_class.required'        => 'Lớp học phần không được bỏ trống!',
        ];
    }
}
