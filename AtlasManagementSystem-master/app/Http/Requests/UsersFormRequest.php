<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersFormRequest extends FormRequest
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

    public function getValidatorInstance()
    {
    //生年月日取得
    $old_year = $this->input('old_year');
    $old_month = $this->input('old_month');
    $old_day = $this->input('old_day');
    //データの統合
    $birth_day = ( $old_year.'-'.$old_month .'-'. $old_day );

    //$birth_dayを使えるようにする。
    $this->merge(['datetime_validation' => $birth_day,]);

         return parent::getValidatorInstance();

    }

    public function rules()
    {   
        $day = date("2000-1-1");

        return [

        'over_name'=> 'required|string|max:10',
        'under_name'=> 'required|string|max:10',
        'over_name_kana'=> 'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
        'under_name_kana'=> 'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
        'mail_address'=> 'required|string|email|max:100|unique:users',
        'sex'=> 'required|in: 1,2,3',
        'datetime_validation' => 'required|date|after_or_equal:'.$day .'|before:now',
        'role'=> 'required|in: 1,2,3,4',
        'password'=> 'required|confirmed|min:8|max:30|',
        'password_confirmation'=> 'required|min:8|max:30|',

        ];
    }

     public function messages(){
        return [
         //姓
        'over_name.required' => '姓は入力必須です',
        'over_name.string' => 'その文字は使用できません',
        'over_name.max' => '姓は10文字以内です',
        //名
        'under_name.required' => '名は入力必須です',
        'under_name.string' => 'その文字は使用できません',
        'under_name.max' => '名は10文字以内です',
         //セイ
        'over_name_kana.required' => 'セイは入力必須です',
        'over_name_kana.string' => 'その文字は使用できません',
        'over_name_kana.max' => 'セイは30文字以内です',
        'over_name_kana.regex' => 'セイは全角カナのみです',
        //メイ
        'under_name_kana.required' => 'メイは入力必須です',
        'under_name_kana.string' => 'その文字は使用できません',
        'under_name_kana.max' => 'メイは30文字以内です',
        'under_name_kana.regex' => 'メイは全角カナのみです',
        //メールアドレス
        'mail_address.required'=> 'メールアドレスは入力必須です',
        'mail_address.string'=> 'その文字は使用できません',
        'mail_address.email' => 'メールアドレスの形式ではありません',
        'mail_address.unique' => 'このメールアドレスは既に登録されています',
        'mail_address.max' => 'メールアドレスは100文字以内です',
        //性別
        'sex.required'=>'性別を選択してください',
        'sex.in'=>'男性、女性、その他の中から選んでください。',
        //生年月日
        'datetime_validation.required' => '生年月日を選択してください',
        'datetime_validation.after_or_equal' => '2000年1月1日以降で入力してください',
        'datetime_validation.before' => '今日より以前の日付を選択してください',
        'datetime_validation.date'  => '存在しない日付です',
        //役職
        'role.required' => '役職を選択してください',
        'role.in' =>'教師、生徒の中から選んでください',
        //パスワード
        'password.required' => 'パスワードは入力必須です',
        'password.confirmed' => 'パスワードが一致しません',
        'password.min' => 'パスワードは8文字以上、30文字以内です',
        'password.max' => 'パスワードは8文字以上、30文字以内です',
         //確認用パスワード
        'password_confirmation.required' => 'パスワードは入力必須です',
        'password_confirmation.min' => 'パスワードは8文字以上、30文字以内です',
        'password_confirmation.max' => 'パスワードは8文字以上、30文字以内です',
        ];
    }
}
