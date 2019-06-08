@extends('layouts.user')
@section('title', 'User \ Notifikasi')
@section('page-header', 'Notifikasi')


@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body" style="padding: 0;">
                    <div class="list-group" v-if="notif == null">
                        @if (count($notifications) == 0)
                            <div style="text-align:center;margin: 15px;">Tidak ada notifikasi.</div>
                        @endif

                        @foreach ($notifications as $item)
                            <a href="{{ $item->url }}" class="list-group-item list-group-item-action
                                @if(!$item->read) bg-primary text-white @endif
                                ">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">{{ $item->title }} </h5>
                                  <small>{{ $item->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">{{ $item->content }}</p>
                              </a>
                        @endforeach
                    </div>
                    <div v-for="(item, i) in notif" class="list-group" v-else>
                        <a v-bind:href="item.url" class="list-group-item list-group-item-action"
                            v-bind:class="getClass(item.read)">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">@{{ item.title }} </h5>
                                <small>@{{ timeDifference(item.created_at) }}</small>
                            </div>
                            <p class="mb-1">@{{ item.content }}</p>
                        </a>
                    </div>

                    @if (count($notifications) != 0)
                    <button style="border-radius: 0;" :disabled="loading" v-on:click="getNotif" class="btn btn-sm btn-block btn-primary" v-if="notif == null">
                        <span v-if="loading">Loading..</span>
                        <span v-else>Tampilkan Semua Notifikasi</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('meta')
    <meta name="api" content="{{ route('user.notifikasi') }}">
    <meta name="assets" content="{{ asset('assets') }}">
@endpush

@push('js')

    <script>
    $('#sidebar-notifikasi').addClass('active');
    // Configuration
    // Vue Instance
    var app = new Vue({
        el: '#app',
        data: {
            notif: null,
            loading: false,
        },
        methods: {
            getClass: function(read){
                return read == 0 ? 'bg-primary text-white' : '';
            },
            getNotif: function(){
                app.loading = true;
                axios.post('', {action: 'getall'}).then(function(res){
                    app.loading = false;
                    if (res.data.status == 'success') {
                        app.notif = res.data.result;
                    }
                }).catch(function(error) {
                    app.loading = false;
                });
            },
            timeDifference: function(time) {
                return time;
            }
        },
        mounted(){
        },
    });
    </script>
@endpush

