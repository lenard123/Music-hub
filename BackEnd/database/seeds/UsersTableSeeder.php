<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Lenard Mangay-ayam';
        $user->email = 'lenard.mangayayam@gmail.com';
        $user->password = bcrypt('admin');
        $user->save();
    }
}
