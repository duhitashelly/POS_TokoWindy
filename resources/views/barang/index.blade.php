@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')
<div class="container mt-4">
    <!-- Card Container -->
    <div class="card shadow">
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
            <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>

        <!-- Body -->
        <div class="card-body">
            <!-- Filter dan Pencarian -->
            <div class="row mb-4">
                <!-- Form Pencarian -->
                <div class="col-md-4 mb-2">
                    <form method="GET" action="{{ route('barang.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari Barang..." value="{{ request()->query('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Filter Kategori -->
                <div class="col-md-4 mb-2">
                    <form method="GET" action="{{ route('barang.index') }}">
                        <div class="input-group">
                            <select name="kategori_id" class="form-control">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($kategori as $category)
                                    <option value="{{ $category->id }}" {{ $kategoriId == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Filter Jumlah Data -->
                <div class="col-md-4 mb-2 text-right">
                    <form method="GET" action="{{ route('barang.index') }}">
                        <div class="input-group">
                            <select name="per_page" class="form-control">
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Data Barang -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataBarang as $key => $item)
                            <tr>
                                <td>{{ $dataBarang->firstItem() + $key }}</td>
                                <td>{{ $item->kode_barang }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}</td>
                                <td>{{ number_format($item->harga_beli, 2) }}</td>
                                <td>{{ number_format($item->harga_jual, 2) }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>
                                    <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('barang.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between">
                <div>
                    Menampilkan {{ $dataBarang->firstItem() }} - {{ $dataBarang->lastItem() }}
                </div>
                <div>
                    {{ $dataBarang->links() }} 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
