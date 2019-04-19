<!-- START HEADER -->
<header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
        <nav class="cyan">
            <div class="nav-wrapper">                    
                <div class="row">
                    <a href="#" data-target="mobile-demo" class="sidenav-trigger btn-floating btn-small waves-effect waves-light cyan" style="margin: 11px 18px;"><i class="material-icons">menu</i></a>
                    <div class="col l2">
                        <a href="{{ route('homepage') }}" class="brand-logo logotext">Fruit And Vegetables</a>
                    </div>
                    <div class="col l8">
                        <div class="input-field hide-on-med-and-down" style="height:auto;">
                        <input @keyup.enter="search" class="search-barang" id="search" type="search" required v-model="q" style="" class="search">
                        <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                        <i class="material-icons">close</i>
                        </div>
                    </div>
                    <div class="col l2">
                        <ul class="hide-on-med-and-down">
                            @auth
                            <li><a href="sass.html" style="position:relative;"><i class="material-icons">shopping_cart</i><span class="btn red white-text btn-floating bad1">4</span></a></li>
                            <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><i class="material-icons">account_box</i></a></li>
                            @else
                            <li><a title="Login" class="dropdown-trigger" href="#!" data-target="dropdown1"><i class="material-icons">keyboard_tab</i></a></li>
                            <li><a title="Register" class="dropdown-trigger" href="#!" data-target="dropdown1"><i class="material-icons">create</i></a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
                <!-- Dropdown Structure -->
                <ul id="dropdown1" class="dropdown-content a" style="z-index:999;">
                    @auth
                    <li><a href="{{ route('user.profil') }}"><i class="material-icons" style="margin:0px;">account_box</i>Profil</a></li>
                    <li><a href="{{ route('register') }}"><i class="material-icons" style="margin:0px;">help</i>Bantuan?</a></li>
                    <li class="divider"></li>
                    <li><a onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="#!"><i class="material-icons" style="margin:0px;">keyboard_tab</i>Logout</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    @else
                    <li><a href="{{ route('login') }}"><i class="material-icons" style="margin:0px;">keyboard_tab</i>Login</a></li>
                    <li><a href="{{ route('register') }}"><i class="material-icons" style="margin:0px;">create</i>Register</a></li>
                    <li class="divider"></li>
                    <li><a href="#!"><i class="material-icons" style="margin:0px;">help</i>Bantuan?</a></li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
    <!-- end header nav-->
                    
    <div class="card sidenav side-nav leftside-navigation" id="mobile-demo" >
        <div class="card-content" style="padding:0px;">
        <ul id="slide-out" style="margin:0px;">
            <li class="user-details cyan darken-2">
                <div class="row">
                    <div class="col col s4 m4 l4">
                        <img src="{{ asset('assets/dist/img/carousel/3.jpg') }}" alt="" class="circle responsive-img valign profile-image">
                    </div>
                    <div class="col s8 m8 l8">
                        <!-- Dropdown Structure -->
                        <ul id="profile-dropdown" class="dropdown-content a"> 
                            @auth
                            <li><a href="{{ route('user.profil') }}"><i class="material-icons" style="margin:0px;">account_box</i>Profil</a></li>
                            <li><a href="{{ route('register') }}"><i class="material-icons" style="margin:0px;">help</i>Bantuan?</a></li>
                            <li class="divider"></li>
                            <li><a onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="#!"><i class="material-icons" style="margin:0px;">keyboard_tab</i>Logout</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                            @else
                            <li><a href="{{ route('login') }}"><i class="material-icons" style="margin:0px;">keyboard_tab</i>Login</a></li>
                            <li><a href="{{ route('register') }}"><i class="material-icons" style="margin:0px;">create</i>Register</a></li>
                            <li class="divider"></li>
                            <li><a href="#!"><i class="material-icons" style="margin:0px;">help</i>Bantuan?</a></li>
                            @endauth
                        </ul>
                        <a class="dropdown-trigger btn-flat waves-effect waves-light white-text profile-btn" href="#!" data-target="profile-dropdown"><b>Pelanggan</b><i class="material-icons right" style="margin:0px;">arrow_drop_down</i></a>
                        <p class="user-roal">Pengunjung</p>
                    </div>
                </div>
            </li>
            <li class="bold"><a href="{{ route('homepage') }}" class="waves-effect waves-cyan"><i class="material-icons" style="margin:0px;">home</i> Dashboard</a>
            </li>
            <li class="bold"><a class="waves-effect waves-cyan" style="position:relative;"><span class="card-title activator " style="margin:0px;position: absolute;top:8px;width: 100%;"><i class="material-icons left" style="margin:0px;width:100%;color: rgb(117, 117, 117);">dashboard</i><p class="kat1">Kategori</p></span></a>
            </li>
            <li>  </li>
            <li class="bold"><a href="sass.html" style="position:relative;"><i class="material-icons" style="margin:0px;">shopping_cart</i><span class="btn red white-text btn-floating bad1">4</span>Keranjang</a>
            </li>
        </ul>
        </div>
        <!-- kategori list-->
        <ul class="collection card-reveal" style="margin:0px;padding: 0px;">
            <li class="collection-item" style="padding: 0px 0px 10px 0px;margin:0;"><a class="waves-effect waves-light btn btn-small card-title sora_aio" style="margin:0px;width: 100%;line-height: 45px !important;font-weight: bold;"><i class="material-icons left white-text" style="font-weight: bold;">arrow_back</i>Menu Kategori</a></li>
            <li class="collection-item" style="padding:0px" ><a href="{{ route('barang.sayur') }}" class="cyan-text"><i class="material-icons b">dashboard</i>
                <span>Sayur</span></a></li>
            <li class="collection-item" style="padding:0px"><a href="{{ route('barang.buah') }}" class="cyan-text"><i class="material-icons b">dashboard</i>
                <span>Buah</span></a>
            </li>   
        </ul>
        <!--end kategori list-->
    </div>
    <!-- HORIZONTL NAV END-->
</header>

<!-- HORIZONTL NAV START aaaaaaaaaaaaaaaaaaaaaaaaaa-->
<div class="navbar-fixed hide-on-med-and-down" style="z-index:990;">
    <nav id="horizontal-nav" class="white hide-on-med-and-down">
        <div class="nav-wrapper">                  
            <ul id="nav-mobile" class="left hide-on-med-and-down">
            <li>
                <a href="{{ route('homepage') }}" class="cyan-text"><i class="material-icons b">home</i>
                <span>Dashboard</span></a>
            </li>
            <li>
                <a href="{{ route('barang.sayur') }}" class="cyan-text"><i class="material-icons b">dashboard</i>
                <span>Sayur</span></a>
            </li>                    
            <li>
                <a href="{{ route('barang.buah') }}" class="cyan-text"><i class="material-icons b">dashboard</i>
                <span>Buah</span></a>
            </li>
            </ul>
        </div>
    </nav>
</div>
<!-- HORIZONTL NAV END-->        
<nav class="hide-on-large-only cyan">
    <div class="nav-wrapper ">
        <form>
        <div class="input-field">
            <input @keyup.enter="search" class="search-barang" id="search" type="search" v-model="q" required>
            <label class="label-icon" for="search"><i class="material-icons">search</i></label>
            <i class="material-icons">close</i>
        </div>
        </form>
    </div>
</nav>


@push('css')
    <style>
        #nav-mobile li a,
        #nav-mobile li,
        #nav-mobile { height: 100%; }
    </style>    
@endpush

@push('js')
    <script>
        var searchApp = new Vue({
            el: '#master-app',
            data: { q: "{{ isset($q) ? $q : '' }}" },
            methods: {
                search: function(){
                    let qCheck = searchApp.q;
                    qCheck = qCheck.replace(" ", "");
                    if (qCheck == "") {
                        return false;
                        // window.location.href = "{{ url('/') }}/";
                    } else {
                        window.location.href = "{{ url('/') }}/search/" + searchApp.q;
                    }
                }
            }
        });
    </script>
@endpush