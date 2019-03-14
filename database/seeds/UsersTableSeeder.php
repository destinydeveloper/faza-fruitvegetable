<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;

// Use migrate : php artisan migrate:fresh --seeder=UsersTableSeeder

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->makeRole();
        $this->makeDemoAccount();
    }

    private function makeDemoAccount()
    {
        echo "[+] Creating Account \n";
        $this->makeAccount('MASTER ADMIN', 'admin', 'admin@faza.com', 'admin', 'admin');
        $this->makeAccount('SUPERVISOR DEMO', 'supervisor', 'supervisor@faza.com', 'supervisor', 'supervisor');
        $this->makeAccount('PENGEPAK DEMO', 'pengepak', 'pengepak@faza.com', 'pengepak', 'pengepak');
        $this->makeAccount('KURIR DEMO', 'kurir', 'kurir@faza.com', 'kurir', 'kurir');
        $this->makeAccount('INVESTOR DEMO', 'investor', 'investor@faza.com', 'investor', 'investor');
        $this->makeAccount('PETANI DEMO', 'petani', 'petani@faza.com', 'petani', 'petani');
        $this->makeAccount('PELANGGAN DEMO', 'user', 'user@faza.com', 'user', 'pelanggan');
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
        echo "Creating Account> [Name : $name] [Email : $email] [Password : $password] [Role : $role]\n";

    }

    private function makeRole()
    {
        echo "[+] Delete Old cache Role permissions \n";
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        echo "[+] Create Users Role \n";
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'supervisor']);
        Role::create(['name' => 'pengepak']);
        Role::create(['name' => 'kurir']);
        Role::create(['name' => 'investor']);
        Role::create(['name' => 'petani']);
        Role::create(['name' => 'pelanggan']);
    }
}
