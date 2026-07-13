<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indikator_mutu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('standar_mutu_id')->constrained('standar_mutu')->cascadeOnDelete();
            $table->string('nama_indikator');
            $table->text('definisi_operasional')->nullable();
            $table->string('satuan')->nullable();
            $table->text('formula_perhitungan')->nullable();
            $table->text('sumber_data')->nullable();
            $table->enum('frekuensi_pengukuran', ['Semester', 'Tahunan'])->default('Semester');
            $table->string('penanggung_jawab_role')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indikator_mutu');
    }
};
