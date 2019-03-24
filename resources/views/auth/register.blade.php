<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('material/css/materialize.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('material/fonts/material-icons.css') }}">
    <script src="{{ asset('material/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('material/js/materialize.min.js') }}"></script>
    <style>
           #bg-gggg {
        position: fixed;
        top: 0px;
        left: 0px;

        min-width: 100%;
        min-height: 100%;
        /* The image usedppppppppppppppppppppppppppppppppppppp */
        background-color: yellow;
        background: url("{{ asset('material/img/bg1.jpg') }}") no-repeat;
      

        /* Full height */
        height: 100%; 

        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .card{

      border-color: #FFFFFF00;
      color: #FFF;
    }
    .card a{
      color: torque;
    }

    [type="radio"]+label:before, [type="radio"]+label:after {
        margin-left: 20px;
    }
    [type="radio"]:checked~div{
        
    }
    [type="radio"]:checked+label:after,[type="radio"].with-gap:checked+label:before {
        
    }
    [type="radio"]:checked+label:after, [type="radio"].with-gap:checked+label:after {
        
    }
    .datepicker-table{
        color:deepskyblue;
    }
    .error{
        color: red!important;
    }
    .mar0{
        margin: 0;
    }
    </style>
</head>
<body>
    <div id="bg-gggg"></div>
        <div class="container bg-transparent mb-5">
                <div class="row">
                        <div class="col s12 l12">
                          <div class="card " style="margin-top:30px;">
                            <div class="card-content white-text" style="padding: 0;background: white;">
                              <span class="card-title red" style="padding: 13px;margin: 5px;">{{ __('Register Akun') }}</span>
                                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="frm_insert" style="margin-top:25px;">
                                    @csrf
                              <div class="row" style="margin:0px;">
                                <div class="input-field col s12 l4" style="margin: 0;">
                                    <input id="nama" type="text" class="validate form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" required autofocus>
                                    <label for="nama">{{ __('Nama Lengkap') }}</label>
                                    @if ($errors->has('nama'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                            </div>
                                    <div class="input-field col s12 l4">
                                            <label style="position: relative;left: 0;">Jenis Kelamin</label><br>
                                            <p style="float: left">
                                                    <label>
                                                    <input class="with-gap" name="group1" type="radio" name="jenkel" />
                                                      <span>Laki - Laki</span>
                                                    </label>
                                                  </p>
                                                  <p style="float: left;">
                                                    <label>
                                                      <input class="with-gap" name="group1" type="radio" name="jenkel" />
                                                      <span>Perempuan</span>
                                                    </label>
                                                  </p>
                                    </div>
                                    <div class="input-field col s12 l4">
                                            <label style="position: relative;left: 0;">Tanggal Lahir</label>
                                        <input type="text" class="datepicker" style="height: 20%;" required value="">
                                    </div>
                                    <div class="input-field col s12 l4">
                                            <input id="username" type="text" class="validate" name="username" required value="">
                                            <label for="username">Username</label>
                                    </div>
                                    <div class="input-field col s12 l4">
                                        <input id="password" type="password" class="validate form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                        <label for="password">{{ __('Password') }}</label>
                                        @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    <div class="input-field col s12 l4">
                                        <input id="password-confirm" type="password" class="validate" name="password_confirmation" required value="">
                                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                </div>
                                    <div class="input-field col s12 l4">
                                            <input id="telp" type="number" class="validate" required value="">
                                            <label for="telp">Telp</label>
                                    </div>
                                    <div class="input-field col s12 l4">
                                        <input id="email" type="email" class="validate form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                        <label for="email">{{ __('E-Mail Address') }}</label>
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    <div class="input-field col s12 l4">
                                            <select required value="">
                                                    <option value="">Pilih Provinsi</option>
                                                    <option value="1">Option 1</option>
                                                    <option value="2">Option 2</option>
                                                    <option value="3">Option 3</option>
                                            </select>
                                            <label>Provinsi</label>
                                    </div>
                                    <div class="input-field col s12 l4">
                                            <select required value="">
                                                    <option value="">Pilih Kota Kab</option>
                                                    <option value="1">Option 1</option>
                                                    <option value="2">Option 2</option>
                                                    <option value="3">Option 3</option>
                                            </select>
                                            <label>Kota/Kabupaten</label>
                                    </div>
                                    <div class="input-field col s12 l4">
                                            <input id="kodepos" type="number" class="validate" required value="">
                                            <label for="kodepos">Kode Pos</label></div>
                                    <div class="input-field col s12 l4 offset-l4">
                                        
                                            <input id="alamat" type="text" class="validate" required value="">
                                            <label for="alamat">Alamat</label>
                                    </div>
                                    <div class="input-field col s12 l12">
                                            <div class="file-field input-field">
                                              <div class="btn">
                                                <span>Foto</span>
                                                <input type="file" multiple>
                                              </div>
                                              <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" placeholder="klik atau seret disini">
                                              </div>
                                            </div>
                                          </div>
                                    <input type="hidden" name="form" value="register" readonly>
                                    <div class="input-field col s12 l12">
                                        <button type="submit" class="btn col l12 s12" id="btn_submit"><span>{{ __('Register') }}</span></button>
                                    </div>
                              </div>
                              
                              </form>
                            </div>
                            <div class="card-action" style="background:aliceblue;">
                              <a href="{{ asset('') }}" style="text-transform: none;">Kembali Ke Halaman Login?</a>
                              <a href="#" style="text-transform: none;float:right">Lupa Password?</a>
                            </div>
                          </div>
                        </div>
                      </div>
        </div>
       </div>
        <script type="text/javascript" src="{{ asset('material/js/vendor/popper.min.js') }}"></script>
        <script src="{{ asset('material/js/jquery-validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('material/js/jquery-validation/additional-methods.min.js') }}"></script>
        <script src="{{ asset('material/js/jquery-validation/localization/messages_id.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
            $('.datepicker').datepicker();
            });
            $(document).ready(function(){
            $('select').formSelect();
            });
                       //on submit
                       $('#frm_insert').validate({
                               rules: {
                                   username: {
                                       required: true,
                                       minlength: 5,
                                   },
                                   password: {
                                       required: true,
                                       minlength: 8
                                   },
                               },
                               messages: {
                                   username: {
                                       remote: "Maaf username ini telah digunakan, silakan anda memakai username lain"
                                   },
                                   email: {
                                       remote: "Maaf email ini telah digunakan, silakan anda memakai email lain"
                                   },
                               },errorElement: "small",
                               errorPlacement: function ( error, element ) {
                               // Add the `help-block` class to the error element
                               error.addClass( "text-danger form-control-feedback" );
   
                               // Add `has-feedback` class to the parent div.form-group input-field
                               // in order to add icons to inputs
                               //element.parents( ".col-sm-12" ).addClass( "has-danger" );
   
                               if ( element.prop( "type" ) === "checkbox" ) {
                                   error.insertAfter( element.parent( "label" ) );
                               } else {
                                   error.insertAfter( element );
                               }
   
                               // Add the span element, if doesn't exists, and apply the icon classes to it.
                               //if ( !element.next( "i" )[ 0 ] ) {
                               //  $( "<i class='fa fa-times-circle form-control validate-feedback' aria-hidden='true'></i>" ).insertAfter( element );
                               //}
                               },
                               success: function ( label, element ) {
                                       // Add the span element, if doesn't exists, and apply the icon classes to it.
                                       //if ( !$( element ).next( "i" )[ 0 ] ) {
                                       //  $( "<i class='fa fa-check-circle ' aria-hidden='true'></i>" ).insertAfter( $( element ) );
                                       //}
                               },
                               highlight: function(element, errorClass, validClass) {
                                   $(element).parents(".col s12").addClass("has-danger").removeClass("has-success");
                                   $('.form-control').addClass('form-control-danger');
                               },
                               unhighlight: function(element, errorClass, validClass) {
                                   $(element).parents(".col s12").addClass("has-success").removeClass("has-danger");
                                   $('.form-control').removeClass('form-control-danger');
                               },
                   });
       
       </script>
</body>
</html>

