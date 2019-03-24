


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('material/css/materialize.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('material/fonts/material-icons.css') }}">
    <style>
    #bg-g {
        position: fixed;
        top: 0px;
        left: 0px;
    
        min-width: 100%;
        min-height: 100%;
        /* The image used */
        background-color: yellow;
        background: url("{{ asset('material/img/bg.jpg') }}") no-repeat;
      
    
        /* Full height */
        height: 100%; 
    
        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .card{
      background: white ;
      border-color: #00000000;
      color: #FFF;
    }
    .card a{
      color: yellow;
    }
    .head {
      color: #fff;
      font-size: 32px;
      font-weight: normal;
      text-align: center;
      text-transform: uppercase;
      font-family: fantasy;
      padding: 5px 0px;
    }
    .input-field .prefix.active{
        color: #26a69a !important;
    }
    .cardlah{
        margin-top: 50px;
        height: auto;
        padding: 0;
        margin-bottom: 0;
        background: #6498fe;
    }
    </style>
</head>
<body>
    <div id="bg-g"></div>
        
                <div class="container">
                  <div class="row" style="margin: auto !important;max-width: 450px;">
                    <div class="col s12 l12 card card-login mx-auto cardlah" style="line-height: 30px;">
                  <div class="head"><img src="{{ asset('material/img/bg.jpg') }}" style="height: 75px"><br>Faza Login</div> 
                    </div>
                  <div class="card card-login mx-auto col l12 s12" style="margin-top:0px;padding:  0;">
                    <div class="card-body" style="padding: 10px;">
                        <form method="POST" action="{{ route('login') }}" id="fromlogin">
                            @csrf
                                <div class="row" style="margin: 0">
                                        <div class="input-field col s12">
                                          <i class="material-icons prefix black-text">account_circle</i>
                                          <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                          <label for="email" class="center-align">{{ __('E-Mail Address') }}</label>
                                          @if ($errors->has('email'))
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $errors->first('email') }}</strong>
                                          </span>
                                      @endif
                                        </div>
                                      </div>
                                      <div class="row" style="margin: 0">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix black-text">lock</i>
                                          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                          <label for="password" >{{ __('Password') }}</label>
                                          @if ($errors->has('password'))
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $errors->first('password') }}</strong>
                                          </span>
                                      @endif
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 0">          
                                        <div class="input-field col s12 m12 l12">
                                            <label style="position: relative;">
                                                <input type="checkbox" {{ old('remember') ? 'checked' : '' }}/>
                                                <span>Re-Remember</span>
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                        <input type="hidden" name="form" value="login">
                      <div class="row" style="margin: 0">
                            <div class="input-field col s12">
                                    <input type="submit" class="btn btn-block blue text-dark col s12" style="" value="Masuk">
                                    {{ __('Login') }}
                            </div>
                          </div>
                      </form>
                      <br>
                      <div class="row black-text">
                          <div class="col s8">
                                Belum Punya Akun ?, <a class=" large mt-3 blue-text" href="register.php">Daftar Baru!</a>
                          </div>
                          @if (Route::has('password.request'))
                          <div class="col s4 right-align">
                                <a class="d-block large blue-text" href="{{ route('password.request') }}">
                                    {{ __('Lupa Password ?') }}
                                </a>
                        </div>
                        @endif
                        <div class="col s12 center-align black-text">
                                <a href="" class="blue-text"><i class="fa fa-home"></i> kembali ke Halaman Utama</a>
                            </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              <script src="{{ asset('material/js/jquery-3.2.1.min.js') }}"></script>
              <script src="{{ asset('material/js/materialize.min.js') }}"></script>
</body>
</html>