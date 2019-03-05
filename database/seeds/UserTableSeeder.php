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

        echo "Create Pelanggan Account...\n";
        $user_level = \App\Models\Pelanggan::create([]);
        $user = new \App\User();
        $user->nama = 'Customer Demo';
        $user->username = 'viandwi';
        $user->email = 'user@mail.com';
        $user->password = bcrypt('user');
        $user_level->user()->save($user);

        echo "Create Kurir Account...\n";
        $user_level = \App\Models\Kurir::create([]);
        $user = new \App\User();
        $user->nama = 'Kurir Demo';
        $user->username = 'kurir';
        $user->email = 'kurir@mail.com';
        $user->password = bcrypt('kurir');
        $user_level->user()->save($user);

        echo "Create Investor Account...\n";
        $user_level = \App\Models\Investor::create([]);
        $user = new \App\User();
        $user->nama = 'investor Demo';
        $user->username = 'investor';
        $user->email = 'investor@mail.com';
        $user->password = bcrypt('investor');
        $user_level->user()->save($user);

        echo "Create Pengepak Account...\n";
        $user_level = \App\Models\Pengepak::create([]);
        $user = new \App\User();
        $user->nama = 'pengepak Demo';
        $user->username = 'pengepak';
        $user->email = 'pengepak@mail.com';
        $user->password = bcrypt('pengepak');
        $user_level->user()->save($user);

        echo "Create Supervisor Account...\n";
        $user_level = \App\Models\Supervisor::create([]);
        $user = new \App\User();
        $user->nama = 'supervisor Demo';
        $user->username = 'supervisor';
        $user->email = 'supervisor@mail.com';
        $user->password = bcrypt('supervisor');
        $user_level->user()->save($user);

        echo "Create Petani Account...\n";
        $user_level = \App\Models\Petani::create([]);
        $user = new \App\User();
        $user->nama = 'Petani Demo';
        $user->username = 'petani';
        $user->email = 'petani@mail.com';
        $user->password = bcrypt('petani');
        $user_level->user()->save($user);
    }
}
