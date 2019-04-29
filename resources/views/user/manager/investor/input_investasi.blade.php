@extends('layouts.user')
@section('title', 'User \ Investor')
@section('page-header', 'Input Investasi')

@section('content')
<div class="row m-3 justify-content-center text-center" style="background: white">
    <div class="col-md-5 col-xs-12">
        @error('nominal')
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @enderror
        <div class="m-3 mb-5" style="display: inline inline-block">
            <h2 class="">Input Investasi</h2>
        </div>
        <form action="{{ route('user.investor.input_save') }}" method="post" class="form-group text-left">
            @csrf
            <label for="nominal">Input Nominal Investasi</label>
            <input type="number" name="nominal" id="nominal" class="form-control mb-3" value="{{old('nominal')}}" placeholder="Masukan nominal investasi" min="50000" step="50000" size="11" autofocus=on required>
            <input type="submit" value="Simpan" class="btn btn-success form-control mb-3" onclick="return confirm('Apakah nominal yang anda inputkan sudah benar ?')">
        </form>
    </div>
</div>
@endsection
