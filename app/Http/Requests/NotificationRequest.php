<?php

namespace App\Http\Requests;

class NotificationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'      => ['required'],
            'content'      => ['required'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'title.required'      => 'Tiêu đề thông báo không được bỏ trống!',
            'content.required'      => 'Nội dung thông báo không được bỏ trống!',
        ];
    }
}
