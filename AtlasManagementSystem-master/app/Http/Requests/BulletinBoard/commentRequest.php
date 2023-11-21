<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class commentRequest extends FormRequest
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
            'comment' => 'required|min:10|max:500',
            'post_id' => 'required|exists:posts,id',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => 'コメントは必須です。',
            'comment.min' => 'コメントは10文字以上で入力してください。',
            'comment.max' => 'コメントは500文字以内で入力してください。',
            'post_id.required' => '投稿IDは必須です。',
            'post_id.exists' => '指定された投稿IDは存在しません。',
        ];
    }
}
