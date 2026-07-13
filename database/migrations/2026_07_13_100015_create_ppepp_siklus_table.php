<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppepp_siklus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('standar_mutu_id')->constrained('standar_mutu')->cascadeOnDelete();
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik')->cascadeOnDelete();
            $table->enum('tahap_sekarang', ['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'])->default('penetapan');
            $table->enum('status_siklus', ['Berjalan', 'Selesai'])->default('Berjalan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppepp_siklus');
    }
};
