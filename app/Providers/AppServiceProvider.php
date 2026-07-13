<?php

namespace App\Providers;

use App\Models\DokumenMutu;
use App\Models\JadwalAudit;
use App\Models\PpeppSiklus;
use App\Models\StandarMutu;
use App\Models\TindakLanjutTemuan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
        Route::bind('standar_mutu', fn ($value) => StandarMutu::findOrFail($value));
        Route::bind('dokumen_mutu', fn ($value) => DokumenMutu::findOrFail($value));
        Route::bind('jadwal_audit', fn ($value) => JadwalAudit::findOrFail($value));
        Route::bind('tindak_lanjut', fn ($value) => TindakLanjutTemuan::findOrFail($value));
        Route::bind('ppepp', fn ($value) => PpeppSiklus::findOrFail($value));
    }
}
