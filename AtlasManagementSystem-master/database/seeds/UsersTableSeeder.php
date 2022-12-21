<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
         [
          'id' => '1',
          'over_name' => '春山',
          'under_name' => '泰星',
          'over_name_kana' => 'ﾊﾙﾔﾏ',
          'under_name_kana'=> 'ﾀｲｾｲ',
          'mail_address' => 'taisei@Compass.com',
          'sex' => '1',
          'birth_day' => '20020209',
          'role' => '1',
          'password' => bcrypt('123456789'),
 
            ],


          ]);
        }
}
