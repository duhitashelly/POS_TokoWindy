<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProdukExport;
use Illuminate\Foundation\Validation\ValidatesRequests; 
use Illuminate\Support\Facades\Log;


class BarangController extends Controller
{
    //
    
    public function index(Request $request)
    {
        // Ambil query pencarian dari input form
        $searchQuery = $request->input('search');
        $kategoriId = $request->input('kategori_id');  
        $perPage = $request->input('per_page', 10);  
    
        $dataBarang = Barang::with('kategori')
            ->when($searchQuery, function ($query, $searchQuery) {
                return $query->where('nama_barang', 'like', '%' . $searchQuery . '%');
            })
            ->when($kategoriId, function ($query, $kategoriId) {
                return $query->where('kategori_id', $kategoriId);
            })
            ->orderBy('id','asc')
            ->simplePaginate($perPage);
            
      
        $kategori = Kategori::all();
    
        // Kirim data barang dan kategori ke view
        return view('barang.index', [
            'dataBarang' => $dataBarang,
            'kategori' => $kategori,
            'searchQuery' => $searchQuery,
            'kategoriId' => $kategoriId,
            'perPage' => $perPage,
        ]);
    }
    

    public function searchBarang($query)
    {
        // Cari barang yang nama_barangnya mengandung query pencarian
        $barang = Barang::where('nama_barang', 'like', '%' . $query . '%')->get();

        return response()->json($barang);
    }
    
    
    public function create(){
        $kategori = Kategori::all();
        return view('barang.create', compact('kategori'));
    }


    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
        ]);
    
        // Ambil kategori berdasarkan ID
        $kategori = Kategori::find($request->kategori_id);
    
   
        if (!$kategori) {
            return redirect()->back()->withErrors(['kategori_id' => 'Kategori tidak ditemukan.']);
        }
    
        $namaKategori = trim($kategori->nama_kategori); 
    
        // Pisahkan nama kategori menjadi array kata
        $kata = explode(' ', $namaKategori);
    
        // Logika pembentukan prefix
        if (count($kata) == 1) {
            // Jika hanya 1 kata, ambil 2 huruf pertama
            $prefix = strtoupper(substr($kata[0], 0, 2));
        } else {
            $prefix = strtoupper(substr($kata[0], 0, 1) . substr($kata[1], 0, 1));
        }
    
        // Cari barang terakhir dalam kategori untuk menentukan nomor urut
        $lastKodeBarang = Barang::where('kategori_id', $request->kategori_id)
                                ->orderBy('id', 'desc')
                                ->first();
    
        // Ambil 3 angka terakhir dari kode barang terakhir atau set ke 0 jika tidak ada
        $lastNumber = $lastKodeBarang ? (int) substr($lastKodeBarang->kode_barang, -3) : 0;
    
        // Increment nomor urut
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    
        // Gabungkan prefix dan nomor urut untuk membuat kode barang
        $kodeBarang = $prefix . '-' . $newNumber;
    
        // Simpan barang ke database
        Barang::create([
            'kode_barang' => $kodeBarang,
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
        ]);
    
        // Redirect ke halaman indeks barang dengan pesan sukses
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }
    

    public function edit($id){
        $data = Barang::find($id);
        $kategoris = Kategori::all();
        return view('Barang.edit', ['data' => $data, 'kat' => $kategoris]);
    }

    public function update(Request $request, $id) {
        $data = Barang::find($id);
        $data->nama_barang = $request->nama_barang;
        $data->kategori_id= $request->kategori;
        $data->harga_beli = $request->harga_beli;
        $data->harga_jual = $request->harga_jual;
        $data->stok = $request->stok;
        $data->update();
        return redirect('barang/tampil-barang');
    }

    public function destroy($id){
        $data = Barang::find($id);
        $data->delete();
        return redirect('barang/tampil-barang');
    }
   
    public function simpanTransaksi(Request $request){
        
        Log::info('Transaksi data received:', $request->all()); // Log data yang diterima
        dd($request->all()); // Cek apakah data sampai ke controller

        try {
            $items = $request->input('items');
            $jumlahBayar = $request->input('jumlah_bayar');
            $kembalian = $request->input('kembalian');

            foreach ($items as $item) {
                // Cek apakah data item sudah benar
                dd($item);

                $transaksi = new Transaksi();
                $transaksi->barang_id = $item['barang_id'];
                $transaksi->nama_barang = $item['nama_barang'];
                $transaksi->qty = $item['qty'];
                $transaksi->harga_barang = $item['harga_barang'];
                $transaksi->total_harga_barang = $item['total_harga_barang'];
                $transaksi->sub_total = $item['sub_total'];
                $transaksi->jumlah_bayar = $jumlahBayar;
                $transaksi->kembalian = $kembalian;
                $transaksi->save();

                $barang = Barang::find($item['barang_id']);
                if ($barang) {
                    if ($barang->stok >= $item['qty']) {
                        $barang->stok -= $item['qty'];
                        $barang->save();
                    } else {
                        return response()->json(['error' => 'Stok barang tidak mencukupi!'], 400);
                    }
                }
            }

            return response()->json(['message' => 'Transaksi berhasil!'], 200);
        } catch (\Exception $e) {
            // Tangani error jika ada
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function editStok($id)
    {
        $barang = Barang::findOrFail($id); // Mendapatkan barang berdasarkan ID

        return view('barang.edit_stok', compact('barang'));
    }

    public function generateKodeBarang(Request $request)
    {
        $kategoriId = $request->get('kategori_id');
        $kategori = Kategori::find($kategoriId);
    
        if ($kategori) {
            // Buat prefix berdasarkan nama kategori
            $namaKategori = $kategori->nama_kategori;
    
            // Pisahkan kategori menjadi array berdasarkan spasi
            $kata = explode(' ', trim($namaKategori));
    
            if (count($kata) == 1) {
                // Jika hanya 1 kata, ambil 2 huruf pertama
                $prefix = strtoupper(substr($kata[0], 0, 2));
            } else {
                // Jika lebih dari 1 kata, ambil huruf pertama dari 2 kata pertama
                $prefix = strtoupper(substr($kata[0], 0, 1) . substr($kata[1], 0, 1));
            }
    
            // Cari barang terakhir di kategori yang sama
            $lastKode = Barang::where('kategori_id', $kategoriId)
                ->latest('id')
                ->first();
    
            // Tentukan nomor urut dari kode barang terakhir
            $lastNumber = $lastKode ? (int) substr($lastKode->kode_barang, -3) : 0;
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    
            // Gabungkan prefix dan nomor urut
            $kodeBarang = $prefix . '-' . $newNumber;
    
            return response()->json(['kode_barang' => $kodeBarang]);
        }
    
        // Jika kategori tidak ditemukan, return null
        return response()->json(['kode_barang' => null]);
    }
    
}
    