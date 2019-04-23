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

                    <!-- Languages dropdown    -->
                    <li class="nav-item dropdown">
                        <a id="languages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle"><img class="img-fluid rounded-circle" style="max-height: 32px;" src="{{ Auth()->user()->avatar === null ? asset('assets/dist/img/avatar.png') : asset('assets/images/100x100/'.Auth()->user()->avatar->path) }}">
                            <span class="d-none d-sm-inline-block">{{ Auth()->user()->nama }}</span>
                        </a>
                        <ul aria-labelledby="languages" class="dropdown-menu">
                            <li>
                                <a onclick="event.preventDefault();document.getElementById('logout-form').submit();" rel="nofollow" href="#" class="dropdown-item">
                                    <i class="fa fa-sign-out" style="color: #000!important;background: transparent !important;"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Logout    -->
                    <!-- <li class="nav-item"><a onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{ route('logout') }}" class="nav-link logout"> <span class="d-none d-sm-inline">Logout</span><i class="fa fa-sign-out"></i></a></li> -->
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
