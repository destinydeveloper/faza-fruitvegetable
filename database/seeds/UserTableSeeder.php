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
        $user->nama = 'MASTER ADMIN';
        $user->username = 'adminnya';
        $user->email = 'admin@mail.com';
        $user->password = bcrypt('admin');
        $user_level->user()->save($user);

        echo "Create Customer Account...\n";
        $user_level = \App\Models\Pelanggan::create([]);
        $user = new \App\User();
        $user->nama = 'Customer Demo';
        $user->username = 'viandwi';
        $user->email = 'user@mail.com';
        $user->password = bcrypt('user');
        $user_level->user()->save($user);
    }
}
