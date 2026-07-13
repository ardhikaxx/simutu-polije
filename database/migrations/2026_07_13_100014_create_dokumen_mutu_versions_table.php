<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_mutu_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokumen_mutu_id')->constrained('dokumen_mutu')->cascadeOnDelete();
            $table->string('nomor_versi');
            $table->string('file_path');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->text('catatan_revisi')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_mutu_versions');
    }
};
