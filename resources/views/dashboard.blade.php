@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid mt-4">
    <!-- Row Kartu Statistik -->
    <div class="row">
        <!-- Pendapatan Bulanan -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow border-left-primary h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pendapatan (Bulanan)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($monthlyEarnings, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendapatan Harian -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow border-left-success h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pendapatan (Harian)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($dailyEarnings, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laba Bulanan -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow border-left-warning h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Laba (Bulanan)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($monthlyProfit, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laba Harian -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow border-left-info h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Laba (Harian)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($dailyProfit, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row Grafik Chart -->
    <div class="row">
        <!-- Grafik Barang yang Sering Dibeli -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Barang yang Sering Dibeli</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="chartBarangSeringDibeli"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Pendapatan Harian -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">Pendapatan Harian</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="chartPendapatanHarian"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Grafik Barang yang Sering Dibeli
        fetch("{{ route('transaksi.chartData') }}")
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('chartBarangSeringDibeli').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.map(item => item.nama_barang),
                        datasets: [{
                            label: 'Jumlah Terjual',
                            data: data.map(item => item.total_qty),
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    }
                });
            });

        // Grafik Pendapatan Harian
        fetch("{{ route('transaksi.getAreachart') }}")
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('chartPendapatanHarian').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(item => item.tanggal),
                        datasets: [{
                            label: 'Total Pendapatan',
                            data: data.map(item => item.total_pendapatan),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            tension: 0.4
                        }]
                    }
                });
            });
    });
</script>
@endsection
