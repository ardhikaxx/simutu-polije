<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('temuan_audit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hasil_audit_id')->constrained('hasil_audit')->cascadeOnDelete();
            $table->enum('kategori_temuan', ['Observasi', 'Minor', 'Mayor']);
            $table->enum('tingkat_risiko', ['Rendah', 'Sedang', 'Tinggi']);
            $table->text('deskripsi_temuan');
            $table->text('rekomendasi')->nullable();
            $table->foreignId('standar_mutu_id')->nullable()->constrained('standar_mutu')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temuan_audit');
    }
};
