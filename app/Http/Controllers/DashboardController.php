<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard.
     */
    public function index()
    {
        $today = Carbon::today();

        // Hitung pendapatan harian
        $dailyEarnings = Transaksi::whereDate('created_at', $today)->sum('sub_total');

        // Hitung pendapatan bulanan
        $monthlyEarnings = Transaksi::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->sum('sub_total');

        // Hitung jumlah transaksi bulan ini
        $monthlyTransactions = Transaksi::whereMonth('created_at', now()->month)
                                         ->whereYear('created_at', now()->year)
                                         ->count();

        // Hitung total pendapatan sepanjang waktu
        $totalEarnings = Transaksi::sum('sub_total');

        // Hitung total transaksi sepanjang waktu
        $totalTransactions = Transaksi::count();

        // Kirim data ke view
        return view('dashboard', compact(
            'dailyEarnings', 
            'monthlyEarnings', 
            'monthlyTransactions', 
            'totalEarnings', 
            'totalTransactions'
        ));
    }
}