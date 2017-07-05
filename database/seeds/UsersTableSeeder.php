<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::find(1) == null){
            User::create([
                'name'     => 'admin',
                'second_name'   =>   'adminoff',
                'password' => bcrypt('admin'),
                'email' => 'admin@example.com',
                'role_id' => 2,
                'date_birth'=>  Carbon::now(config('app.timezone'))->addYears(random_int(-30,-17)),
            ]);
        }
    }
}
