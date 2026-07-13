<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('standar_mutu_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('standar_mutu_id')->constrained('standar_mutu')->cascadeOnDelete();
            $table->string('nomor_versi');
            $table->longText('konten_lengkap');
            $table->text('file_pendukung')->nullable();
            $table->text('alasan_revisi')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('standar_mutu_versions');
    }
};
