@extends('layouts.login.app')

@section('title', 'Ini login')

@section('page-name', 'Ini nama')

@section('page-description', 'Ini deskripsi')

@section('content')

<form method="post" action="" class="form-validate">
    <div class="form-group">
        <input id="login-username" type="text" name="loginUsername" required data-msg="Please enter your username" class="input-material">
        <label for="login-username" class="label-material">User Name</label>
    </div>
    <div class="form-group">
        <input id="login-password" type="password" name="loginPassword" required data-msg="Please enter your password" class="input-material">
        <label for="login-password" class="label-material">Password</label>
    </div><a id="login" href="index.html" class="btn btn-primary">Login</a>
    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
</form><a href="#" class="forgot-pass">Forgot Password?</a><br><small>Do not have an account? </small><a href="register.html" class="signup">Signup</a>
@endsection
