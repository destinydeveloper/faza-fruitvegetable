<?php

namespace App\Helpers;

use App\User;

class Account {
    public function make($name, $username, $email, $password, $role)
    {
        $user = new User();
        $user->nama = $name;
        $user->username = $username;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();
        $user_id = $user->id;
        $user->assignRole($role);

        return (object) ["id" => $user_id];
    }
}