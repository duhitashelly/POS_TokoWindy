<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'barang';
    protected $primaryKey = 'id';
    // Menentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = ['nama_barang', 'kode_barang', 'kategori_id', 'harga_beli', 'harga_jual', 'stok'];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
