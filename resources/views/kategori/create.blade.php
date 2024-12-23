@extends('layouts.app')
@section('title', 'Aplikasi Laravel')
@section('content')

<br>
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Kategori</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <br>
            <form action="{{route('kategori.store')}}" method="POST">
                @csrf
                <div class ="form-group">
                    <label for="kode">Kode Kategori<span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="id" id="id">
                </div>
                <div class ="form-group">
                    <label for="kode">Nama Kategori<span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="nama_kategori" id="nama_kategori">
                </div>
                <br>
                <div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('/kategori') }}" class="btn btn-success">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection