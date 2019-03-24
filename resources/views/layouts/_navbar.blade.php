<header class="header">
    <nav class="navbar">
        <!-- Search Box-->
        <div class="search-box">
            <button class="dismiss"><i class="icon-close"></i></button>
            <form id="searchForm" action="#" role="search">
                <input type="search" placeholder="What are you looking for..." class="form-control">
            </form>
        </div>
        <div class="container-fluid" id="notif-app">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <!-- Navbar Header-->
                <div class="navbar-header">
                <!-- Navbar Brand --><a href="index.html" class="navbar-brand d-none d-sm-inline-block">
                    <div class="brand-text d-none d-lg-inline-block"><span>Faza </span><strong>User</strong></div>
                    <div class="brand-text d-none d-sm-inline-block d-lg-none"><strong>BD</strong></div></a>
                <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
                </div>
                <!-- Navbar Menu -->
                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    <!-- Search-->
                    <li class="nav-item d-flex align-items-center"><a id="search" href="#"><i class="icon-search"></i></a></li>
                    <!-- Notifications-->
                    <li class="nav-item dropdown"> 
                        <a v-on:click="getNotif" id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">
                            <i class="fa fa-bell-o"></i>
                            @if(notification()->getNotReadCount() != 0)
                                <span class="badge bg-red badge-corner">{{ notification()->getNotReadCount() }}</span>
                            @endif
                        </a>
                        <ul aria-labelledby="notifications" class="dropdown-menu">
                            <div v-if="loading">
                                <div style="text-align: center;">Getting Information...</div>
                            </div>
                            <div v-if-else="!notif === null">
                                <li v-for="(item, i) in notif"><a  rel="nofollow" v-bind:href="item.url" class="dropdown-item"> 
                                    <div class="notification">
                                        <div class="notification-title"><strong>@{{ item.title }}</strong></div>
                                        <div class="notification-content">@{{ item.content }}</div>
                                        <div class="notification-time">@{{ item.created_at }}</div>
                                    </div></a></li>
                                <div style="text-align:center;" v-if="notif === null || (Array.isArray(notif) && notif.length == 0)">
                                    Tidak Ada Notifikasi.
                                </div>
                                <div v-else>
                                    <li><a rel="nofollow" href="{{ route('user.notifikasi') }}" class="dropdown-item all-notifications text-center"> <strong>Lihat semua</strong></a></li>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <!-- Messages                        -->
                    <li class="nav-item dropdown"> <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-envelope-o"></i><span class="badge bg-orange badge-corner">10</span></a>
                        <ul aria-labelledby="notifications" class="dropdown-menu">
                        <li><a rel="nofollow" href="#" class="dropdown-item d-flex"> 
                            <div class="msg-profile"> <img src="{{ asset('assets/dist/img/avatar-1.jpg') }}" alt="..." class="img-fluid rounded-circle"></div>
                            <div class="msg-body">
                                <h3 class="h5">Jason Doe</h3><span>Sent You Message</span>
                            </div></a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item d-flex"> 
                            <div class="msg-profile"> <img src="{{ asset('assets/dist/img/avatar-2.jpg') }}" alt="..." class="img-fluid rounded-circle"></div>
                            <div class="msg-body">
                                <h3 class="h5">Frank Williams</h3><span>Sent You Message</span>
                            </div></a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item d-flex"> 
                            <div class="msg-profile"> <img src="{{ asset('assets/dist/img/avatar-3.jpg') }}" alt="..." class="img-fluid rounded-circle"></div>
                            <div class="msg-body">
                                <h3 class="h5">Ashley Wood</h3><span>Sent You Message</span>
                            </div></a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>Read all messages   </strong></a></li>
                        </ul>
                    </li>
                    <!-- Languages dropdown    -->
                    <li class="nav-item dropdown"><a id="languages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle"><img src="{{ asset('assets/dist/img/flags/16/GB.png') }}" alt="English"><span class="d-none d-sm-inline-block">English</span></a>
                        <ul aria-labelledby="languages" class="dropdown-menu">
                        <li><a rel="nofollow" href="#" class="dropdown-item"> <img src="{{ asset('assets/dist/img/flags/16/DE.png') }}" alt="English" class="mr-2">German</a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item"> <img src="{{ asset('assets/dist/img/flags/16/FR.png') }}" alt="English" class="mr-2">French                                         </a></li>
                        </ul>
                    </li>
                    <!-- Logout    -->
                    <li class="nav-item"><a onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{ route('logout') }}" class="nav-link logout"> <span class="d-none d-sm-inline">Logout</span><i class="fa fa-sign-out"></i></a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                </ul>
            </div>
        </div>
    </nav>
</header>

@push('meta')
    <meta name="notif-api" content="{{ route('user.notifikasi.action') }}">    
    <meta name="assets" content="{{ asset('assets') }}">
@endpush

@push('js')
    <script>
    const notifApi = $("meta[name='notif-api']").attr("content");
    // Vue Instance
    var notifApp = new Vue({
        el: '#notif-app',
        data: {
            loading: true,
            notif: null,
        },
        methods: {
            getNotif: function(){
                if (notifApp.notif == null) {
                    notifApp.loading = true;
                    axios.post('', {action: 'getnavbar'}, {baseURL: notifApi}).then(function(res){
                        if (res.data.status == 'success') {
                            if (res.data.result.length == 0) {
                                notifApp.notif = null;
                            } else {
                                notifApp.notif = res.data.result;
                            }
                        }
                    }).catch(function(error){
                    });
                    notifApp.loading = false;
                }
            }
        },
        mounted(){
        }
    });
    </script>
@endpush