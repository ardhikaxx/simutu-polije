<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('capaian_indikator', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indikator_mutu_id')->constrained('indikator_mutu')->cascadeOnDelete();
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik')->cascadeOnDelete();
            $table->foreignId('program_studi_id')->constrained('program_studi')->cascadeOnDelete();
            $table->decimal('nilai_capaian', 10, 2);
            $table->enum('status_warna', ['hijau', 'kuning', 'merah']);
            $table->enum('sumber_input', ['Manual', 'Otomatis'])->default('Manual');
            $table->timestamp('dihitung_pada')->nullable();
            $table->unsignedBigInteger('dihitung_oleh')->nullable();
            $table->timestamps();

            $table->foreign('dihitung_oleh')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('capaian_indikator');
    }
};
