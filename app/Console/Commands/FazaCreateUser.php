<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use App\User;

class FazaCreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faza:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make new user with role in faza';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('Full Name');
        $username = $this->ask('Username');
        $email = $this->ask('Email');
        $password = $this->secret('Password');
        $role = $this->anticipate('Role For This User?', ['admin', 'pengepak', 'supervisor', 'kurir', 'petani', 'investor', 'pelanggan']);

        $this->makeAccount($name, $username, $email, $password, $role);
        // $this->info("Creating Account> [Name : $name] [Username : $username] [Email : $email] [Password : $password] [Role : $role]");
    }

    private function makeAccount($name, $username, $email, $password, $role)
    {
        $user = new User();
        $user->nama = $name;
        $user->username = $username;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();
        $user->assignRole($role);
        $this->info("Creating Account> [Name : $name] [Username : $username] [Email : $email] [Password : $password] [Role : $role]");
    }
}
