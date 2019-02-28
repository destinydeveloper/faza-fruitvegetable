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
        echo "Create Admin Account...\n";
        $user_level = \App\Models\Admin::create([]);
        $user = new \App\User();
        $user->name = 'MASTER ADMIN';
        $user->email = 'admin@mail.com';
        $user->password = bcrypt('admin');
        $user_level->user()->save($user);

        echo "Create Customer Account...\n";
        $user_level = \App\Models\Customer::create([]);
        $user = new \App\User();
        $user->name = 'Customer Demo';
        $user->email = 'user@mail.com';
        $user->password = bcrypt('user');
        $user_level->user()->save($user);
    }
}
