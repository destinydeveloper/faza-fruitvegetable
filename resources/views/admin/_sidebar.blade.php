<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="{{ Auth()->user()->avatar === null ? asset('assets/dist/img/avatar.png') : asset('assets/images/100x100/'.Auth()->user()->avatar->path) }}" title="{{ Auth()->user()->avatar->judul }}" alt="{{ Auth()->user()->avatar->judul }}" class="img-fluid rounded-circle"></div>
        <div class="title">
            <h1 class="h4">{{ strlen(Auth()->user()->nama) > 12 ? substr(Auth()->user()->nama, 0, 12) . '...' : Auth()->user()->nama  }}</h1>
            <p>{{ strlen(Auth()->user()->email) > 14 ? substr(Auth()->user()->email, 0, 14) . '...' : Auth()->user()->email }}</p>
        </div>
    </div>
    <span class="heading">Main</span>
    <ul class="list-unstyled">
        <li id="sidebar-home"><a href="{{ route('admin.home') }}"> <i class="fa fa-home"></i>Home </a></li>
    </ul>
    <span class="heading">Manager</span>
    <ul class="list-unstyled">
        <li id="sidebar-manager-user"><a href="{{ route('admin.manager.user') }}"> <i class="fa fa-user"></i>User </a></li>
        <li><a href="{{ route('admin.home') }}"> <i class="fa fa-users"></i>Gaji Karyawan </a></li>
    </ul>
    <span class="heading">Pengaturan</span>
    <ul class="list-unstyled">
        <li id="sidebar-profil"><a href="{{ route('admin.profil') }}"> <i class="fa fa-id-card"></i>Profil </a></li>
    </ul>
</nav>