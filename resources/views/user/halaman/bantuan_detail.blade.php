@extends('layouts.user')
@section('title', 'User \ Halaman \ Bantuan \ Tambah')
@section('page-header', 'Tambah Halaman Bantuan')


@section('content')
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form class="form">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Judul...">
                        </div>

                        <div class="form-group">
                            <textarea id="summernote" name="content"></textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop


@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>
    <script>
        $('#summernote').summernote({
            placeholder: 'Tulis artikel disini...',
            height: 300
        });
    </script>
@endpush