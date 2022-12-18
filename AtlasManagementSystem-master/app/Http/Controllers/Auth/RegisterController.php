<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

use App\Models\Users\Subjects;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

     //ユーザー登録画面

    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }


    public function registerPost(Request $request)
    {

$rules = [
        'over_name'=> 'required|string|max:10',
        'under_name'=> 'required|string|max:10',
        'over_name_kana'=> 'required|string|max:30|regex:[ァ-ヴー]',
        'under_name_kana'=> 'required|string|max:30|regex:[ァ-ヴー]',
        'mail_address'=> 'required|string|email|max:100|unique:users',
        'sex'=> 'required|regex:[男性.女性.その他]',
        'birth_day'=> 'required|',
        'role'=> 'required|',
        'password'=> 'required|confirmed|min:8|max:30|',
];
$message = [

        //姓
        'over_name.required' => '姓は入力必須です',
        'over_name.string' => 'その文字は使用できません',
        'over_name.max' => '姓は10文字以内です',
        //名
        'under_name'=> 'required|string|max:10',
        'under_name.required' => '名は入力必須です',
        'under_name.string' => 'その文字は使用できません',
        'under_name.max' => '名は10文字以内です',
         //セイ
        'over_name_kana'=> 'required|string|max:30',
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
        //役職
        'role.required' => '役職を選択してください',
        //パスワード
        'password.required' => 'パスワードは入力必須です',
        'password.confirmed' => 'パスワードが一致しません',
        'password.min' => 'パスワードは8文字以上、30文字以内です',
        'password.max' => 'パスワードは8文字以上、30文字以内です',

];
 $validator = Validator::make($request->all(), $rules, $message);
 if($validator->fails()) {

   return redirect("/register")
    ->withErrors($validator)
     ->withInput();
 }
 else {
        DB::beginTransaction();
        try{
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $request->subject;

            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);



            $user = User::findOrFail($user_get->id);
            $user->subjects()->attach($subjects);
            DB::commit();
            return view('auth.login.login');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('loginView');
        }
    }}
}
