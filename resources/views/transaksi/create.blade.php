@extends('layouts.app')

@section('title', 'Transaksi Kasir')

@section('content')

    <style>
        body {
            color: black !important;
        }


        .btn {
            color: white !important;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .container .alert {
            transition: margin-top 0.5s ease-in-out;
        }

        .container .alert.show {
            margin-top: 20px;
        }

        .container .alert.fade {
            margin-top: 20px;
        }

        .card-header,
        .card-body,
        .list-group-item,
        .form-control {
            color: black !important;
        }

        .pagination {
            justify-content: center;
            display: flex;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            padding: 8px 16px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            height: 40px;
        }

        .card-body {
            padding: 20px;
        }

        .list-group-item {
            padding: 12px 20px;
        }

        .btn-sm {
            padding: 5px 10px;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-container input {
            height: 40px;
        }

        .pagination-btns {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .pagination-btns .btn {
            padding: 8px 16px;
        }

        .qty-input {
            width: 50px;
            height: 30px;
            text-align: center;
        }

        .form-control-sm {
            height: 30px;
        }

        .container {
            transition: margin-top 0.5s ease-in-out;
        }

        .container.hide-content {
            margin-top: -20px;
        }

        /* Style untuk struk */
        .struk {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            text-align: center;
            padding: 20px;
            width: 300px;
            /* Ukuran maksimal struk */
            margin: 0 auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .struk h3 {
            margin: 0;
            padding: 5px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .struk .details p,
        .struk .items span,
        .struk .total p {
            font-size: 14px;
            line-height: 1.5;
        }

        .struk .items {
            text-align: left;
            margin-bottom: 10px;
        }

        .struk .total {
            margin-top: 10px;
            font-weight: bold;
        }

        .card {
            margin-bottom: 10px; 
        }
        .row {
            margin-bottom: 5px; 
        }


    </style>

    <div class="container d-flex flex-wrap">

        <!-- Notifikasi Transaksi Sukses -->
        @if (session('success'))
            <div class="col-12 mb-4" id="notification-container">
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="auto-hide-alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        <!-- Notifikasi Error jika ada masalah -->
        @if (session('error'))
            <div class="col-12 mb-4" id="notification-container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="auto-hide-alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

                <!-- Daftar Barang dengan Pagination -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="search-container mb-3">
                                <form action="{{ route('transaksi.cariBarang') }}" method="GET">
                                    <div class="form-group">
                                        <label for="searchBarang">Cari Barang</label>
                                        <input type="text" name="search" id="searchBarang" class="form-control" placeholder="Cari barang..." value="{{ request()->query('search') }}">
                                    </div>
                                </form>
                            </div>
                        
                            <ul class="list-group">
                                @foreach ($barang as $b)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $b->nama_barang }} - Rp {{ number_format($b->harga_jual) }}</span>
        
                                        <!-- Cek apakah stok barang kosong -->
                                        @if ($b->stok > 0)
                                            <a href="{{ route('transaksi.tambahPesanan', $b->id) }}"
                                                class="btn btn-success btn-sm">Tambah</a>
                                        @else
                                            <span class="text-danger">Stok Habis</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
        
                            <div class="pagination-btns">
                                <!-- Previous Button -->
                                @if ($barang->onFirstPage())
                                    <button class="btn btn-secondary" disabled>Previous</button>
                                @else
                                    <a href="{{ $barang->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                                @endif
        
                                <!-- Next Button -->
                                @if ($barang->hasMorePages())
                                    <a href="{{ $barang->nextPageUrl() }}" class="btn btn-primary">Next</a>
                                @else
                                    <button class="btn btn-secondary" disabled>Next</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
        <!-- Total dan Bayar -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Total dan Pembayaran</h6>
                </div>
                <div class="card-body">
                    <span>Kode Nota: {{ $nota }}</span>
                    <p>Total: Rp
                        <span>{{ number_format($totalHarga) }}</span>
                        <span style="display: none" id="total">{{ $totalHarga }}</span>
                    </p>
                    <form action="{{ route('transaksi.simpanTransaksi') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="bayar">Jumlah Bayar</label>
                            <input type="number" id="bayar" name="bayar" class="form-control"
                                placeholder="Masukkan jumlah bayar" min="0">
                        </div>
                        <div class="form-group">
                            <label for="kembalian">Kembalian</label>
                            <input type="text" id="kembalian" class="form-control" disabled value="0">
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Bayar</button>
                    </form>
                </div>
                
            </div>
        </div>

        <!-- Daftar Pesanan -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Pesanan</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($cart as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    {{ $item['nama_barang'] }} - Rp {{ number_format($item['harga_jual']) }} x
                                    {{ $item['qty'] }}
                                </div>
                                <div>
                                    <strong>Rp {{ number_format($item['harga_jual'] * $item['qty']) }}</strong>
                                </div>
                                <div class="d-flex">
                                    <form action="{{ route('transaksi.updateQty', $item['id']) }}" method="POST"
                                        class="form-inline mr-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="qty" value="{{ $item['qty'] }}" min="1"
                                            class="form-control form-control-sm" style="width: 60px;"
                                            onchange="this.form.submit()">
                                    </form>
                                    <form action="{{ route('transaksi.destroy', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item">Cart kosong!</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500); // Menghapus alert setelah fade selesai
                });
            }, 3000); // 3 detik

            // Fungsi untuk menghitung kembalian
            document.addEventListener("DOMContentLoaded", function() {
                const totalHarga = parseInt(document.getElementById("total").innerText.replace(/\D/g, '')) || 0;
                const bayarInput = document.getElementById("bayar");
                const kembalianInput = document.getElementById("kembalian");

                bayarInput.addEventListener("keyup", function() {
                    const bayar = parseInt(bayarInput.value) || 0;
                    const kembalian = bayar - totalHarga;
                    // Update input kembalian
                    kembalianInput.value = kembalian >= 0 ? "Rp " + kembalian.toLocaleString() : "Rp 0";
                });
            });
        </script>
    @endsection
