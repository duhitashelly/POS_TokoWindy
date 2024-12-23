@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')

<div class="container-fluid mt-4">
    <!-- Card Wrapper -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Transaksi</h6>
        </div>
        <div class="card-body">
            <!-- Form Filter Berdasarkan Tanggal -->
            <div class="mb-4">
                <form action="{{ url('/laporan/transaksi') }}" method="GET" id="filterForm" class="row g-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" 
                               value="{{ request('start_date') }}" 
                               onchange="document.getElementById('filterForm').submit();">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" 
                               value="{{ request('end_date') }}" 
                               onchange="document.getElementById('filterForm').submit();">
                    </div>
                </form>
            </div>

            <!-- Tombol Ekspor -->
            <a href="{{ url('/laporan/excel?start_date=' . request('start_date') . '&end_date=' . request('end_date')) }}" 
            class="btn btn-success me-2">
                <i class="fas fa-file-excel"></i> Ekspor ke Excel
            </a>
            <a href="{{ url('/laporan/transaksi/pdf?start_date=' . request('start_date') . '&end_date=' . request('end_date')) }}" 
            class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Ekspor ke PDF
            </a>

            <!-- Tabel Data Transaksi -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Nota</th>
                            <th>Kasir</th>
                            <th>Total Transaksi</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $transaction)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $transaction->nota }}</td>
                                <td>{{ $transaction->kasir }}</td>
                                <td class="text-end">{{ number_format($transaction->sub_total, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $transaction->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Info Periode dan Total di bawah Tabel (di kanan) -->
            @if($transactions->count() > 0)
            <div class="d-flex justify-content-end mt-3">
                    <!-- Total Keseluruhan -->
                    <div>
                        <strong>Total Keseluruhan: </strong> 
                        <span class="badge bg-primary">
                            {{ number_format($transactions->sum('sub_total'), 0, ',', '.') }}
                        </span>
                    </div>
            </div>
            @endif

        </div>
    </div>
</div>

@endsection
