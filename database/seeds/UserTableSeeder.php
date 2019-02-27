<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_level = \App\Models\Admin::create([]);
        $user = new \App\User();
        $user->name = 'MASTER ADMIN';
        $user->email = 'admin@mail.com';
        $user->password = bcrypt('admin');
        $user_level->user()->save($user);
    }
}
