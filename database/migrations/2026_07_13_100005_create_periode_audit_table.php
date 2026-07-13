<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_audit', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik')->cascadeOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['Perencanaan', 'Berjalan', 'Selesai'])->default('Perencanaan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_audit');
    }
};
