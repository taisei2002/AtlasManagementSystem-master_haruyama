<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class main_categoryRequest extends FormRequest
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

            //メイン
             'main_category_name' => 'required|max:100|string|'
        ];
    }

    public function messages(){
        return [
             //メインカテゴリー
            'main_category_name.max' => 'メインカテゴリー名は100文字以内で入力してください。',
            'main_category_name.required' => 'メインカテゴリー名を入力してください。',
            'main_category_name.string' => '正しい文字列で入力してください。',
            'main_category_name.unique' => 'そのカテゴリーは既に登録されています。',
            'main_category_name.between' => ' ーは既に登録されています。',


        ];
    }

}
