<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="{{ Auth()->user()->avatar === null ? asset('assets/dist/img/avatar.png') : asset('assets/images/100x100/'.Auth()->user()->avatar->path) }}"  class="img-fluid rounded-circle"></div>
        <div class="title">
            <h1 class="h4">{{ strlen(Auth()->user()->nama) > 12 ? substr(Auth()->user()->nama, 0, 12) . '...' : Auth()->user()->nama  }}</h1>
            <p>{{ strlen(Auth()->user()->email) > 14 ? substr(Auth()->user()->email, 0, 14) . '...' : Auth()->user()->email }}</p>
        </div>
    </div>
    <span class="heading">Main</span>
    <ul class="list-unstyled">
            <li id="sidebar-home"><a href="{{ route('user.home') }}"> <i class="fa fa-home"></i>Home </a></li>
            <li id="sidebar-notifikasi"><a href="{{ route('user.notifikasi') }}"> <i class="fa fa-bell"></i>Notifikasi </a></li>
    </ul>
    @hasanyrole('admin|pengepak|supervisor')
    <span class="heading">Manager</span>
    <ul class="list-unstyled">
        @hasanyrole('admin')
            <li id="sidebar-manager-user"><a href="{{ route('user.manager.user') }}"> <i class="fa fa-user"></i>User </a></li>
        @endhasanyrole
        @hasanyrole('admin|pengepak')
            <li id="sidebar-manager-barang"><a href="{{ route('user.manager.barang') }}"> <i class="fa fa-cubes"></i>Barang</a></li>
        @endhasanyrole
        @hasanyrole('admin|pengepak')
            <li id="sidebar-manager-barangmentah"><a href="{{ route('user.manager.barang_mentah') }}"> <i class="fa fa-cube"></i>Barang Mentah</a></li>
        @endhasanyrole
        @hasanyrole('admin|supervisor')
            <li id="sidebar-manager-inputbarangmentah"><a href="{{ route('user.manager.input_barang_mentah') }}"> <i class="fa fa-exchange"></i>Input Barang Mentah</a></li>
        @endhasanyrole
        @hasanyrole('admin')
            <li id="sidebar-manager-gajikaryawan"><a href="{{ route('user.manager.gajikaryawan') }}"> <i class="fa fa-users"></i>Gaji Karyawan </a></li>
        @endhasanyrole
    </ul>
    @endhasanyrole
    <span class="heading">Pengaturan</span>
    <ul class="list-unstyled">
        <li id="sidebar-profil"><a href="{{ route('user.profil') }}"> <i class="fa fa-id-card"></i>Profil </a></li>
    </ul>
</nav>