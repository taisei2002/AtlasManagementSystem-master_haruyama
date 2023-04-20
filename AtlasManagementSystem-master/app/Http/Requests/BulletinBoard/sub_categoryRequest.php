<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class sub_categoryRequest extends FormRequest
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

            //サブカテゴリー
             'sub_category_name' => 'required|max:100|string|unique:sub_categories,sub_category|between:0,100',

             'main_category_id' => 'required|exists:main_categories,id',
        ];
    }

    public function messages(){
        return [
            //サブカテゴリー
            'sub_category_name.max' => 'サブカテゴリー名は100文字以内で入力してください。',
            'sub_category_name.required' => 'サブカテゴリー名を入力してください。',
            'sub_category_name.string' => '正しい文字列で入力してください。',
            'sub_category_name.unique' => 'そのカテゴリーは既に登録されています。',
            'sub_category_name.between' => ' ーは既に登録されています。',

            'main_category_id.exists'=> '正しいメインカテゴリーを選択してください。',
        ];
    }

}
