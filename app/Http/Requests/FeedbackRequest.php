<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_email'=>'required|email',
            'message'=> 'required|min:5',
        ];
    }

    public function messages()
    {
        return [
            'user_email.required'=>'Vui lòng nhập email để gửi tin nhắn.',
            'user_email.email'=> 'Email bạn nhập chưa đúng định dạng.',
            'message.required' => 'Bạn chưa nhập nội dung tin nhắn.',
            'message.min' => 'Tin nhắn bạn quá ngắn.',
        ];
    }
}
