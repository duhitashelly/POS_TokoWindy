<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use FPDF; 

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $today = Carbon::today();
    
        $dataTransaksi = Transaksi::when($search, function ($query, $search) {
                // Filter berdasarkan tanggal 
                return $query->whereDate('created_at', '=', $search);
            }, function ($query) use ($today) {
                //Transaksi hari ini
                return $query->whereDate('created_at', '=', $today);
            })->get();
    
        return view('transaksi.index', compact('dataTransaksi', 'search'));
    }
    
    public function create()
    {
        $cart = session('cart', []);
        $totalHarga = collect($cart)->sum(fn($item) => $item['harga_jual'] * $item['qty']);
        $nota = $this->generateNota();

        // Simpan nota ke dalam session
        session(['nota' => $nota]);

        $barang = Barang::paginate(2);
        return view('transaksi.create', compact('cart', 'totalHarga', 'barang', 'nota'));
    }

    public function cariBarang(Request $request)
    {
        $search = $request->input('search');
        $barang = Barang::where('nama_barang', 'like', "%{$search}%")
            ->paginate(2);
        $cart = session('cart', []);
        $totalHarga = collect($cart)->sum(fn($item) => $item['harga_jual'] * $item['qty']);
        $nota = session('nota') ?? $this->generateNota();
        return view('transaksi.create', compact('barang', 'cart', 'totalHarga', 'nota'));
    }
    
    public function tambahPesanan(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $cart = session('cart', []);
    
        // Cek jika stok barang habis
        if ($barang->stok == 0) {
            return redirect()->back()->with('error', 'Stok barang ini habis.');
        }
    
        // Periksa apakah barang sudah ada di dalam cart
        if (isset($cart[$id])) {
            // barang sudah ada di dalam cart
            if ($cart[$id]['qty'] + 1 > $barang->stok) {
                return redirect()->back()->with('error', 'Jumlah barang melebihi stok!');
            }
            $cart[$id]['qty'] += 1;
        } else {
            // barang belum ada di dalam cart
            if (1 > $barang->stok) {
                return redirect()->back()->with('error', 'Jumlah barang melebihi stok!');
            }
            $cart[$id] = [
                'id' => $barang->id,
                'nama_barang' => $barang->nama_barang,
                'harga_jual' => $barang->harga_jual,
                'qty' => 1,
            ];
        }
    
        session(['cart' => $cart]);
        return redirect()->route('transaksi.create')->with('success', 'Barang berhasil ditambahkan ke cart.');
    }
    

    public function updateQty(Request $request, $id)
    {
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            $request->validate([
                'qty' => 'required|integer|min:1',
            ]);

            $barang = Barang::find($cart[$id]['id']);
            if ($barang && $request->qty > $barang->stok) {
                return redirect()->route('transaksi.create')->with('error', 'Jumlah barang melebihi stok!');
            }

            $cart[$id]['qty'] = $request->qty;
            session(['cart' => $cart]);

            return redirect()->route('transaksi.create');
        }

        return redirect()->route('transaksi.create')->with('error', 'Barang tidak ditemukan di cart.');
    }

    public function destroy($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);

        session(['cart' => $cart]);

        return redirect()->route('transaksi.create')->with('success', 'Barang berhasil dihapus dari cart.');
    }

    private function generateNota()
    {
        $prefix = 'NOTA-' . now()->format('Ymd');

        $lastTransaksi = Transaksi::where('nota', 'like', $prefix . '%')
            ->latest('id')
            ->first();

        if ($lastTransaksi) {
            $lastNumber = (int) substr($lastTransaksi->nota, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function simpanTransaksi(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('transaksi.index')->with('error', 'Tidak ada barang dalam cart!');
        }

        $request->validate([
            'bayar' => 'required|numeric|min:0',
        ]);

        $kasir = auth()->user()->name ?? 'admin';//mengambil nama user
        $nota = session('nota') ?? $this->generateNota();

        // Hitung total harga dari keranjang
        $totalHarga = collect($cart)->sum(fn($item) => $item['harga_jual'] * $item['qty']);
        $kembalian = $request->bayar - $totalHarga;

        if ($kembalian < 0) {
            return redirect()->route('transaksi.index')->with('error', 'Jumlah bayar tidak cukup!');
        }

        // Cek stok barang
        foreach ($cart as $item) {
            $barang = Barang::find($item['id']);
            if ($barang && $barang->stok < $item['qty']) {
                return redirect()->route('transaksi.index')->with('error', 'Stok barang tidak cukup untuk: ' . $barang->nama_barang);
            }
        }

        foreach ($cart as $item) {
            // Menyimpan data transaksi ke database
            Transaksi::create([
                'nota' => $nota, 
                'kasir' => $kasir,
                'barang_id' => $item['id'],
                'nama_barang' => $item['nama_barang'],
                'qty' => $item['qty'],
                'harga_barang' => $item['harga_jual'],
                'total_harga_barang' => $item['harga_jual'] * $item['qty'],
                'sub_total' => $totalHarga,
                'jumlah_bayar' => $request->bayar,
                'kembalian' => $kembalian,
            ]);

            // Mengurangi stok barang yang dibeli
            $barang = Barang::find($item['id']);
            if ($barang) {
                $barang->decrement('stok', $item['qty']);
            }
        }
        session(['current_nota' => $nota]);
        // Mengosongkan cart setelah transaksi selesai
        session()->forget('cart');
        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil disimpan.')
            ->with('nota', $nota)
            ->with('bayar', $request->bayar)
            ->with('kembalian', $kembalian);
    }

    public function chartData()
    {
        $data = DB::table('transaksi')
            ->select('nama_barang', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('nama_barang')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        return response()->json($data);
    }

    public function getDashboardData()
    {
        $currentMonth = Carbon::now()->month; 
        $currentDay = Carbon::now()->toDateString(); 
    
        // Pendapatan Bulanan
        $monthlyEarnings = DB::table('transaksi')
            ->whereMonth('transaksi.created_at', $currentMonth) 
            ->sum('sub_total');
    
        // Pendapatan Harian
        $dailyEarnings = DB::table('transaksi')
            ->whereDate('transaksi.created_at', $currentDay)
            ->sum('sub_total');
    
        // Laba Harian
        $dailyProfit = DB::table('transaksi')
            ->join('barang', 'transaksi.barang_id', '=', 'barang.id') 
            ->whereDate('transaksi.created_at', $currentDay)
            ->select(DB::raw('SUM((transaksi.harga_barang - barang.harga_beli) * transaksi.qty) as laba'))
            ->value('laba');
    
        // Laba Bulanan
        $monthlyProfit = DB::table('transaksi')
            ->join('barang', 'transaksi.barang_id', '=', 'barang.id') 
            ->whereMonth('transaksi.created_at', $currentMonth)
            ->select(DB::raw('SUM((transaksi.harga_barang - barang.harga_beli) * transaksi.qty) as laba'))
            ->value('laba');
    
        return view('dashboard', compact('monthlyEarnings', 'dailyEarnings', 'dailyProfit', 'monthlyProfit'));
    }
    
    public function showStruk($id)
    {
        // Retrieve all transactions with the same nota
        $transaksiList = Transaksi::where('nota', $id)->get();

        // Jika tidak ada transaksi ditemukan, kembalikan error
        if ($transaksiList->isEmpty()) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        $firstTransaksi = $transaksiList->first();

        // Calculate total values
        $subtotal = $transaksiList->sum('total_harga_barang');
        $bayar = $firstTransaksi->jumlah_bayar;
        $kembalian = $firstTransaksi->kembalian;

        // Prepare struk data
        $struk = [
            'kode_struk' => $id,
            'tanggal' => $firstTransaksi->created_at->format('d M Y H:i'),
            'kasir' => $firstTransaksi->kasir,
            'items' => $transaksiList->map(function ($transaksi) {
                return [
                    'id' => $transaksi->id,
                    'nama_barang' => $transaksi->nama_barang,
                    'qty' => $transaksi->qty,
                    'harga' => $transaksi->harga_barang, // Sesuaikan dengan view Anda
                    'total_harga' => $transaksi->total_harga_barang
                ];
            })->toArray(),
            'subtotal' => $subtotal,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
            'total_transaksi' => $transaksiList->count()
        ];

        return view('laporan.struk', compact('struk'));
    }

    public function getAreachart()
    {
        // Ambil data pendapatan harian
        $pendapatanHarian = DB::table('transaksi')
            ->selectRaw('DATE(created_at) as tanggal, SUM(sub_total) as total_pendapatan')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Kembalikan data sebagai JSON
        return response()->json($pendapatanHarian);
    }
}
