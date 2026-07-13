<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_mutu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_dokumen_id')->constrained('kategori_dokumen')->cascadeOnDelete();
            $table->string('nomor_dokumen')->nullable();
            $table->string('judul');
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studi')->nullOnDelete();
            $table->foreignId('unit_kerja_id')->nullable()->constrained('unit_kerja')->nullOnDelete();
            $table->foreignId('standar_mutu_id')->nullable()->constrained('standar_mutu')->nullOnDelete();
            $table->enum('status', ['Draft', 'Submitted', 'Reviewed', 'Revision Needed', 'Approved', 'Published', 'Archived', 'Expired'])->default('Draft');
            $table->unsignedBigInteger('versi_aktif_id')->nullable();
            $table->date('tanggal_berlaku')->nullable();
            $table->date('tanggal_kedaluwarsa')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_mutu');
    }
};
