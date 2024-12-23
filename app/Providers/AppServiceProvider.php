<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;  // <-- Impor View
use App\Models\Barang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cek apakah tabel 'barang' sudah ada
        if (\Schema::hasTable('barang')) {
            $lowStockItems = Barang::where('stok', '<=', 5)->get();
            $lowStockCount = $lowStockItems->count();
    
            // Bagikan data $lowStockItems dan $lowStockCount ke view
            View::composer('layouts.navbar', function ($view) use ($lowStockItems, $lowStockCount) {
                $view->with('lowStockItems', $lowStockItems);
                $view->with('lowStockCount', $lowStockCount);
            });
        }
    }
}    
