<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 
use App\Models\Profil; 

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
        /**
         * Menggunakan View Composer agar variabel $allProfil 
         * tersedia di SEMUA file blade secara otomatis.
         */
        View::composer('*', function ($view) {
            // Gunakan try-catch sederhana untuk menghindari error saat migrasi database
            try {
                $allProfil = Profil::select('judul', 'slug')->get();
                $view->with('allProfil', $allProfil);
            } catch (\Exception $e) {
                $view->with('allProfil', collect());
            }
        });
    }
}

