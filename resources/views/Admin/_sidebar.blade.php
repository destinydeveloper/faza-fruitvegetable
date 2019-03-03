<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        
        <div class="avatar"><img src="{{ Auth()->user()->avatar === null ? asset('assets/dist/img/avatar.png') : 'assets/images/100x100/'.Auth()->user()->avatar->path }}" alt="..." class="img-fluid rounded-circle"></div>
        <div class="title">
            <h1 class="h4">{{ strlen(Auth()->user()->nama) > 12 ? substr(Auth()->user()->nama, 0, 12) . '...' : Auth()->user()->nama  }}</h1>
            <p>{{ strlen(Auth()->user()->email) > 14 ? substr(Auth()->user()->email, 0, 14) . '...' : Auth()->user()->email }}</p>
        </div>
    </div>
    <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled">
        <li class="active"><a href="index.html"> <i class="icon-home"></i>Home </a></li>
        <li><a href="tables.html"> <i class="icon-grid"></i>Tables </a></li>
        <li><a href="charts.html"> <i class="fa fa-bar-chart"></i>Charts </a></li>
        <li><a href="forms.html"> <i class="icon-padnote"></i>Forms </a></li>
        <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Example dropdown </a>
            <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
            <li><a href="#">Page</a></li>
            <li><a href="#">Page</a></li>
            <li><a href="#">Page</a></li>
            </ul>
        </li>
        <li><a href="login.html"> <i class="icon-interface-windows"></i>Login page </a></li>
    </ul>
    <span class="heading">Extras</span>
    <ul class="list-unstyled">
        <li> <a href="#"> <i class="icon-flask"></i>Demo </a></li>
        <li> <a href="#"> <i class="icon-screen"></i>Demo </a></li>
        <li> <a href="#"> <i class="icon-mail"></i>Demo </a></li>
        <li> <a href="#"> <i class="icon-picture"></i>Demo </a></li>
    </ul>
</nav>