<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Profil;
use App\Models\SocialLink;
use App\Models\BrandAsset;

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
            try {
                $allProfil = Profil::select('judul', 'slug')->get();
                $socialLinks = collect();
                $brandAssets = collect();

                if (Schema::hasTable((new SocialLink)->getTable())) {
                    $socialLinks = SocialLink::select('key', 'url')->get()->keyBy('key');
                }

                if (Schema::hasTable((new BrandAsset)->getTable())) {
                    $brandAssets = BrandAsset::select('key', 'logo_file')->get()->keyBy('key')->map(function ($item) {
                        $path = trim($item->logo_file ?? '');
                        if (!$path) {
                            $item->logo_url = null;
                            return $item;
                        }

                        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                            $item->logo_url = $path;
                        } elseif (str_starts_with($path, 'storage/')) {
                            $item->logo_url = asset($path);
                        } elseif (str_starts_with($path, 'uploads/')) {
                            $item->logo_url = asset('storage/' . $path);
                        } else {
                            $item->logo_url = asset($path);
                        }

                        return $item;
                    });
                }

                $view->with('allProfil', $allProfil);
                $view->with('socialLinks', $socialLinks);
                $view->with('brandAssets', $brandAssets);
            } catch (\Exception $e) {
                $view->with('allProfil', collect());
                $view->with('socialLinks', collect());
                $view->with('brandAssets', collect());
            }
        });
    }
}

