@extends('layouts.app')

@section('title','form barang')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Barang</h6>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="form-group">
                                <label for="kode">Kode Barang<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="id" id="id">
                        </div>
                        <div class ="form-group">
                            <label for="nama">Nama Barang<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="nama_barang" id="nama_barang">
                        </div>
                        <div class ="form-group">
                            <label for="harga">Harga Beli<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="harga_beli" id="harga_beli">
                        </div>
                        <div class ="form-group">
                            <label for="harga">Harga Jual<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="harga_jual" id="harga_jual">
                        </div>
                        <div class ="form-group">
                            <label for="kode">Stok<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="stok" id="stok">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Basic Card Example</h6>
    </div>
    <div class="card-body">
        The styling for this basic card example is created by using default Bootstrap
        utility classes. By using utility classes, the style of the card component can be
        easily modified with no need for any custom CSS!
    </div>
</div>
