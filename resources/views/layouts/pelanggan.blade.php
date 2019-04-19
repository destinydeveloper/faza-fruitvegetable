@extends('layouts.materialize')
@section('page-title')
    @yield('title')
@stop



@section('content-header')
    {{-- HeaderNavbar:start --}}
    @include('layouts.pelanggan._navbar')
    {{-- HeaderNavbar:end --}}

    {{-- Body:start --}}
    <div id="app">
    @yield('content')
    </div>
    {{-- Body:end --}}

     <!-- START FOOTER -->
    <footer class="page-footer cyan">
        <div class="footer-copyright">
            <div class="container" style="width:98%;">
            <span class="left left-align">Copyright © 2019 Kampoengmalang All rights reserved.</span>
            <span class="right"> Design and Developed by Team IT Destiny Indonesia</span>
            </div>
        </div>
    </footer>
@stop

@push('css')
<style>
body{
    background: whitesmoke;
}
.side-nav.leftside-navigation .user-details {
  background: url({{ asset('assets/dist/img/carousel/bg.jpg') }}) no-repeat center center;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  /*overflow: hidden;*/
  
  margin-bottom: 15px;
  padding: 15px 0px 0px 15px;
}
.user-details .row {
  margin: 0;
}
.user-task,
.user-time {
  margin: 0;
  font-size: 13px;
  color: #fff;
}
.side-nav.leftside-navigation .profile-btn {
  margin: 0;
  text-transform: capitalize;
  padding: 0;
  text-shadow: 1px 1px 1px #444;
  font-size: 15px;
}
.user-roal {
  color: #fff;
  margin-top: -16px;
  font-size: 13px;
  text-shadow: 1px 1px 1px #444;
}
.bold > a {
  font-weight: bold;
}
nav.top-nav {
  height: 122px;
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
}
nav.top-nav a.page-title {
  line-height: 122px;
  font-size: 48px;
}
    .navi{
        height: 0px !important;
        line-height: 45px !important;
        font-size: 2rem !important;
        text-align: center !important;
    }
    .fontnav{
        position: relative;
        top: 12px;
    }
    .search:focus{
        color: black !important;
        background: white !important;
    }
    .search{
        display: block !important;
        background: rgba(255,255,255,0.3)!important;
        -webkit-transition: all 200ms ease!important;
        transition: all 200ms ease!important;
        border: none!important;
        font-size: 16px!important;
        font-weight: 400!important;
        outline: none!important;
        border-radius: 3px!important;
    }
    .a{
        top: 64px !important;
        width: 200px !important;
        overflow: hidden;
       
    }
    .harpa{
        padding: 0px 5px !important;
    }
    .logotext{
        font-size: 22px !important;
    }
    .card-title{
        font-size: 18px !important;    
    }
    .sidenav li>a{
        padding: 0px 10px !important;
    }
    #products{
        margin-bottom: -30px !important;
    }
    @media only screen and (max-width: 992px){
    .logotext{
        font-size: 17px !important;
    }
    .sora_aio{
      font-size: 16px !important;
      line-height: 16px !important;
      font-weight: bold !important;
    }
    }
    @media only screen and (max-width: 450px){
    .acfix{
       width: 100% !important;
    }
    .judtex{
    padding: 0px !important;
    }
    .gambarmob{
        height: 125px !important;

    }
    .card-title{
        font-size: 13px !important;  
        line-height: 20px !important;  
    }
    #products{
        padding:0px 2px !important;
        margin-bottom: -22px !important;
    }
    .product{
        padding:5px !important;    
        }
    .colmob{
        padding: 0px !important;
    }
    .colmob1{
        padding-left:4px !important; 
    }
    .harpa{
        padding: 0px !important;
    }    
    }
    .b{
        line-height: 45px !important;
    height: 10px !important;
    text-align: center !important;
    }
    .bad1{
    display: block !important;
    position: absolute !important;
    top: 32px !important;
    left: 22px !important;
    width: 22px !important;
    height: 22px !important;
    line-height: 22px !important;
    }
    .hitomi{
      color: rgba(0,0,0,0.87);
    display: block;
    font-size: 14px;
    font-weight: 500;
    height: 48px;
    line-height: 48px;
    padding: 0 32px;
    }
    .kat1{
      color: rgba(0,0,0,0.87);
    display: block;
    font-size: 14px;
    font-weight: 500;
    height: 48px;
    line-height: 30px;
    padding: 0px 10px !important;
    position: absolute;
    left: 14px;
    }
    .mz-expand>span,
    figure>span,
    figure.mz-figure>span{
        display: none !important;
    }
    figure>span{
        display: none !important;
    }
    figure>img{
        height: 300px !important;
        min-height: 300px !important;
        text-align: center !important;
        width: 300px !important;
        min-width: 300px !important;
        max-width: 300px !important;
    }
    .form-control{
        position: relative;
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    width: 1% !important;
    margin-bottom: 0;
    }
    .input-group{
        position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-box-align: stretch;
    -ms-flex-align: stretch;
    align-items: stretch;
    width: 100%;
    }
</style>
@endpush

@push('js')
    <script>
    $(document).ready(function(){$('.sidenav').sidenav();});
    $(".dropdown-trigger").dropdown({});
    $('.carousel.carousel-slider').carousel({
        fullWidth: true,
        indicators: true,
        duration: 100,
    }); 
    autoplay()   
    function autoplay() {
        $('.carousel').carousel('next');
        setTimeout(autoplay, 4500);
    } 
    </script>
@endpush