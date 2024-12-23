@extends('layouts.app')

@section('title','form barang')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Barang</h6>
                    <br>
                    <form action="{{route('barang.update', $data->id)}}" method="POST">
                        @csrf
                        <div class ="form-group">
                            <label for="kode">Kode Barang<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="id" id="id"
                            value="{{$data->id}}">
                        </div>
                        <div class ="form-group">
                            <label for="kode">Nama Barang<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="nama_barang" id="nama_barang"
                            value="{{$data->nama_barang}}">
                        </div>
                        <div class ="form-group">
                            <label class="form-label">Kategori</label>
                            <select class="form-control" id="kategori" name="kategori" value=" {{ $data->kategori_id }}">
                            @foreach ($kat as $cat)
                            <option value="{{ $cat->id }}"
                                                {{ $cat->id == $data->kategori_id ? 'selected' : '' }}>
                                                {{ $cat->nama_kategori }}</option>
                          @endforeach
                          </select>
                        </div>
                        <div class ="form-group">
                            <label for="harga">Harga Beli<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="harga_beli" id="harga_beli"
                            value="{{$data->harga_beli}}">
                        </div>
                        <div class ="form-group">
                            <label for="harga">Harga Jual<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="harga_jual" id="harga_jual"
                            value="{{$data->harga_jual}}">
                        </div>
                        <div class ="form-group">
                            <label for="kode">Stok<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="stok" id="stok"
                            value="{{$data->stok}}">
                        </div>
                        <br>
                        <div>
                            <button type="submit" class="btn btn-primary">Edit</button>
                            <a href="{{ url('barang') }}" class="btn btn-success">Kembali</a>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection