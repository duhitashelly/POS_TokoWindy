@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('content')
<div class="container-fluid mt-4">
    <!-- Card Wrapper -->
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Transaksi
            </a>
        </div>

        <div class="card-body">
            
            <!-- Form Pencarian -->
            <form method="get" action="{{ route('transaksi.index') }}" class="mb-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="date" name="search" class="form-control" placeholder="Cari Tanggal"
                            value="{{ request()->query('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tabel Data Transaksi -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Nota</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Harga Barang</th>
                            <th>Total Harga Barang</th>
                            <th>Sub Total</th>
                            <th>Jumlah Bayar</th>
                            <th>Kembalian</th>
                            <th>Tanggal Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($dataTransaksi->isEmpty())
                            <tr>
                                <td colspan="11" class="text-center text-muted">Data tidak ditemukan untuk tanggal yang dicari.</td>
                            </tr>
                        @else
                            @php($no = 1)
                            @foreach ($dataTransaksi as $row)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-center">{{ $row->nota }}</td>
                                    <td>{{ $row->nama_barang }}</td>
                                    <td class="text-center">{{ $row->qty }}</td>
                                    <td class="text-end">Rp {{ number_format($row->harga_barang, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($row->total_harga_barang, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($row->sub_total, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($row->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($row->kembalian, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $row->created_at->format('d M Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('transaksi.struk', $row->nota) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-receipt"></i> Struk
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showStruk(id) {
        fetch(`/transaksi/${id}/struk`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('kodeStruk').textContent = data.kode_struk;
                document.getElementById('tanggalStruk').textContent = data.tanggal;
                document.getElementById('itemsStruk').innerHTML = data.items.map(item =>
                    `<p>${item.nama_barang} x${item.qty} - Rp ${item.harga}</p>`).join('');
                document.getElementById('subtotalStruk').textContent = `Rp ${data.subtotal}`;
                document.getElementById('totalStruk').textContent = `Rp ${data.total}`;
                document.getElementById('bayarStruk').textContent = `Rp ${data.bayar}`;
                document.getElementById('kembalianStruk').textContent = `Rp ${data.kembalian}`;
            });
    }

    function cetakStruk() {
        var printContents = document.getElementById('strukPrint').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
@endsection
