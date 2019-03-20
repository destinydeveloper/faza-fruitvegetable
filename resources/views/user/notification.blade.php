@extends('layouts.user')
@section('title', 'User \ Notifikasi')
@section('page-header', 'Notifikasi')


@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="list-group">
                        @foreach ($notifications as $item)
                            <a href="{{ $item->url }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">{{ $item->title }} </h5>
                                  <small>{{ $item->created_at }}</small>
                                </div>
                                <p class="mb-1">{{ $item->content }}</p>
                              </a>
                        @endforeach
                    </div>                        
                </div>
            </div>
        </div>
    </section>
@endsection


@push('js')
    <script>$('#sidebar-notifikasi').addClass('active');</script>    
@endpush

