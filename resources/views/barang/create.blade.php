@extends('layouts.app')

@section('title','Form Barang')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Barang</h6>
                </div>
                <div class="card-body">
                    <!-- Tampilkan Error Validasi -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Tambah Barang -->
                    <form action="{{ route('barang.store') }}" method="POST">
                        @csrf

                        <!-- Input Kode Barang -->
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="kode_barang" id="kode_barang" readonly>

                        </div>

                        <!-- Input Nama Barang -->
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}" required>
                        </div>

                        <!-- Dropdown Kategori -->
                        <div class="form-group">
                            <label for="kategori_id">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach ($kategori as $category)
                                    <option value="{{ $category->id }}" {{ old('kategori_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            

                        <!-- Input Harga Beli -->
                        <div class="form-group">
                            <label for="harga_beli">Harga Beli <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="harga_beli" id="harga_beli" value="{{ old('harga_beli') }}" required>
                        </div>

                        <!-- Input Harga Jual -->
                        <div class="form-group">
                            <label for="harga_jual">Harga Jual <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') }}" required>
                        </div>

                        <!-- Input Stok -->
                        <div class="form-group">
                            <label for="stok">Stok <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="stok" id="stok" value="{{ old('stok') }}" required>
                        </div>

                        <!-- Tombol Simpan -->
                        <div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ url('barang') }}" class="btn btn-success">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.getElementById('kategori_id').addEventListener('change', function () {
        const kategoriId = this.value; 

        if (kategoriId) {
            // Panggil endpoint untuk generate kode barang
            fetch(`/barang/generate-kode?kategori_id=${kategoriId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Kode Barang:', data.kode_barang); // Debugging untuk memastikan data diterima
                    document.getElementById('kode_barang').value = data.kode_barang || '';
                })
                .catch(error => {
                    console.error('Error fetching kode_barang:', error); // Log jika ada error
                });
        } else {
            console.log('Kategori tidak dipilih');
            document.getElementById('kode_barang').value = ''; // Kosongkan input jika kategori tidak dipilih
        }
    });
</script>
@endsection
