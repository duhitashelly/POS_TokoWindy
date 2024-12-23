<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
    
        // Jika pengguna belum login, arahkan ke halaman login
        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil nama route saat ini
        $routeName = $request->route() ? $request->route()->getName() : null;
    
        // Jika nama route tidak ditemukan, izinkan melanjutkan tanpa pembatasan
        if (!$routeName) {
            return $next($request);
        }
    
        // Blokir akses ke kategori.tampil-kategori untuk kasir
        if ($routeName === 'kategori.tampil-kategori' && $user->isKasir()) {
            return redirect('/dashboard')->with('error', 'Kasir tidak dapat mengakses halaman kategori.');
        }
    
        // Blokir akses ke barang.edit dan kategori.edit untuk kasir
        if (in_array($routeName, ['barang.edit', 'kategori.edit']) && $user->isKasir()) {
            return redirect('/dashboard')->with('error', 'Kasir tidak dapat mengakses halaman edit.');
        }
    
        // Jika admin mencoba mengakses halaman kasir, blokir akses
        if ($user->isAdmin() && $this->isKasirRoute($routeName)) {
            return redirect('/dashboard')->with('error', 'Admin tidak dapat mengakses halaman kasir.');
        }
    
        // Jika kasir mencoba mengakses halaman admin, blokir akses
        if ($user->isKasir() && $this->isAdminRoute($routeName)) {
            return redirect('/dashboard')->with('error', 'Kasir tidak dapat mengakses halaman admin.');
        }
    
        return $next($request);
    }
    
    

    /**
     * Tentukan apakah route termasuk dalam halaman kasir.
     */
    private function isKasirRoute(string $routeName): bool
    {
        return in_array($routeName, [
            'transaksi.index',   // Halaman daftar transaksi
            'transaksi.create',  // Halaman tambah transaksi
        ]);
    }

    /**
     * Tentukan apakah route termasuk dalam halaman admin.
     */
    private function isAdminRoute(string $routeName): bool
    {
        return in_array($routeName, [
            'laporan.index',
            'barang.index',
            'barang.tampil-barang',
            'kategori.tampil-kategori',
            'barang.create',
            'kategori.create',
            'barang.edit',
            'kategori.edit,'
        ]);
    }
}
