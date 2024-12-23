<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TransaksiExport;

class LaporanController extends Controller
{
    /**
     * Menampilkan laporan transaksi berdasarkan tanggal.
     */
    public function index(Request $request)
    {
        // Validasi input
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Query transaksi dengan filter tanggal, jika ada
        $query = Transaksi::query();

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]);
        }

        // Ambil data transaksi
        $transactions = $query->get();

        return view('laporan.index', compact('transactions'));
    }
    /**
     * Mengekspor laporan transaksi ke Excel.
     */
    public function exportExcel(Request $request)
    {
        // Validasi input, namun memungkinkan tanggal kosong
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Jika tanggal tidak ada, ambil semua transaksi
        if ($request->start_date && $request->end_date) {
            $transactions = Transaksi::whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ])->get();
        } else {
            $transactions = Transaksi::all();
        }

        $totalKeseluruhan = $transactions->sum('sub_total');

        // Ekspor ke Excel
        return Excel::download(
            new TransaksiExport($transactions, $totalKeseluruhan, $request->start_date, $request->end_date),
            'Laporan_Transaksi.xlsx'
        );
    }

    /**
     * Mengekspor laporan transaksi ke PDF.
     */
    public function exportToPDF(Request $request)
    {
        // Validasi input, namun memungkinkan tanggal kosong
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
    
        // Jika tanggal tidak ada, ambil semua transaksi
        if ($request->start_date && $request->end_date) {
            $transactions = Transaksi::whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ])->get();
        } else {
            $transactions = Transaksi::all();
        }
    
        $totalKeseluruhan = $transactions->sum('sub_total');
    
        // Generate PDF dan tampilkan di browser
        $pdf = Pdf::loadView('laporan.pdf', [
            'transactions' => $transactions,
            'totalKeseluruhan' => $totalKeseluruhan,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    
        // Gunakan stream untuk menampilkan PDF di browser
        return $pdf->stream('Laporan_Transaksi.pdf');
    }
    
}
