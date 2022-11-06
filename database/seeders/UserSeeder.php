<?php

namespace Database\Seeders;

use App\Models\Account\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('status', Config::get('custom.status.active'))->first();
        if ($user==null){ // if database empty
            $userList = [
                ['username' => 'admin', 'password' => '12345qwerty!', 'first_name' => 'Admin', 'last_name' => '', 'role' => Config::get('custom.role.admin')],
                ['username' => 'user', 'password' => '12345qweAS1!', 'first_name' => 'User', 'last_name' => '1', 'role' => Config::get('custom.role.user')],
            ];

            foreach($userList AS $key => $value):
                User::create($value);
            endforeach;
        }
    }
}
