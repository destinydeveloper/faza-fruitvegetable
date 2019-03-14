@extends('layouts.user')
@section('title', 'User \ Home')
@section('page-header', 'Home')


@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-secondary">tes</div>
                <div class="card-body">tes</div>
            </div>
        </div>
    </section>
@endsection


@push('js')
    <script>$('#sidebar-home').addClass('active');</script>    
@endpush