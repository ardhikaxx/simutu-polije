<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('standar_mutu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_standar_id')->constrained('kategori_standar')->cascadeOnDelete();
            $table->string('kode_standar');
            $table->text('nama_standar');
            $table->text('deskripsi')->nullable();
            $table->text('dasar_hukum')->nullable();
            $table->json('unit_terdampak')->nullable();
            $table->enum('status', ['Draft', 'Submitted', 'Reviewed', 'Revision Needed', 'Approved', 'Published', 'Archived', 'Expired'])->default('Draft');
            $table->unsignedBigInteger('versi_aktif_id')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('disahkan_oleh')->nullable();
            $table->date('tanggal_berlaku')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('standar_mutu');
    }
};
