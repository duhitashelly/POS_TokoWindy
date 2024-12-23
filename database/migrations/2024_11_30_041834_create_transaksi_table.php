<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();   
            $table->string('nota');                     
            $table->string('kasir');
            $table->unsignedBigInteger('barang_id'); // ID barang yang dibeli
            $table->string('nama_barang');        // Nama barang
            $table->integer('qty');               // Jumlah barang yang dibeli
            $table->integer('harga_barang');      // Harga per barang (tanpa desimal)
            $table->integer('total_harga_barang'); // Total harga barang (harga x qty, tanpa desimal)
            $table->integer('sub_total');         // Sub total transaksi (tanpa desimal)
            $table->integer('jumlah_bayar');      // Jumlah yang dibayar (tanpa desimal)
            $table->integer('kembalian');         // Kembalian (tanpa desimal)
            $table->timestamps();                 // Timestamp untuk created_at dan updated_at

            // Definisikan foreign key dengan kolom yang tepat
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
