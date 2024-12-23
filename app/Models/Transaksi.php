<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi penamaan tabel
    protected $table = 'transaksi';

    // Tentukan kolom yang bisa diisi melalui mass assignment
    protected $fillable = [
        'nota',
        'kasir',
        'barang_id',
        'nama_barang',
        'qty',
        'harga_barang',
        'total_harga_barang',
        'sub_total',
        'jumlah_bayar',
        'kembalian'
    ];

    /**
     * Relasi dengan model Barang
     * Setiap transaksi memiliki satu barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
