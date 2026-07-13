<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_studi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained('fakultas_jurusan')->cascadeOnDelete();
            $table->string('nama_prodi');
            $table->string('kode_prodi');
            $table->enum('jenjang', ['D3', 'D4', 'S2Terapan']);
            $table->string('akreditasi_saat_ini')->nullable();
            $table->unsignedBigInteger('kaprodi_id')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_studi');
    }
};
