<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:255',
            'email' => 'required|min:8|email',
            'website' => 'required|',
            'message' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'min' => ':attribute không được nhỏ hơn :min',
            'max' => ':attribute không được lớn hơn :max',
            'email' => ':attribute phải điền đúng định dạng email'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Họ Tên',
            'email' => 'Email',
            'website' => 'Website'
            'message' => 'Message'
        ];
    }
}
