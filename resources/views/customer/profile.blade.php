<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ '@'.$user->username }} - Profil | Faza </title>
</head>
<body>
    <b>user yang dicari :</b>
    <div>Nama : {{ $user->name }}</div>
    <div>Email : {{ $user->email }}</div>
    <div>Username : {{ $user->username }}</div>
</body>
</html>