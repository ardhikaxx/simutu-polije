<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppepp_pelaksanaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ppepp_siklus_id')->constrained('ppepp_siklus')->cascadeOnDelete();
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studi')->nullOnDelete();
            $table->foreignId('unit_kerja_id')->nullable()->constrained('unit_kerja')->nullOnDelete();
            $table->text('deskripsi_implementasi');
            $table->date('tanggal_pelaksanaan');
            $table->enum('status', ['Belum', 'Proses', 'Selesai'])->default('Belum');
            $table->foreignId('diisi_oleh')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppepp_pelaksanaan');
    }
};
