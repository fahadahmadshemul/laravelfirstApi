<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            ['name'=>'Fahad', 'email'=> 'fahad@gmail.com', 'password'=>'123456'],
            ['name'=>'Shemul', 'email'=> 'shemul@gmail.com', 'password'=>'123456'],
            ['name'=>'Rahad', 'email'=> 'rahad@gmail.com', 'password'=>'123456'],
        ];
        User::insert($user);
    }
}
