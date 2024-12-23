@extends('layouts.app') 

@section('title', 'Aplikasi Laravel')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <!-- Card Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Kategori</h6>
            <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light text-center">
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th style="width: 15%;">Kode Kategori</th>
                            <th>Nama Kategori</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataKategori as $data)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $data->id }}</td>
                                <td>{{ $data->nama_kategori }}</td>
                                <td class="text-center">
                                    <a href="{{ route('kategori.edit', $data->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('kategori.delete', $data->id) }}" method="post" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Tidak ada data kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
