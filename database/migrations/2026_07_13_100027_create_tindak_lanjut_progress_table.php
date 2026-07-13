<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tindak_lanjut_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tindak_lanjut_temuan_id')->constrained('tindak_lanjut_temuan')->cascadeOnDelete();
            $table->text('keterangan_progress');
            $table->string('file_bukti')->nullable();
            $table->foreignId('dilaporkan_oleh')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('diverifikasi_oleh')->nullable();
            $table->enum('status_verifikasi', ['Pending', 'Diterima', 'Ditolak'])->default('Pending');
            $table->timestamps();

            $table->foreign('diverifikasi_oleh')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut_progress');
    }
};
