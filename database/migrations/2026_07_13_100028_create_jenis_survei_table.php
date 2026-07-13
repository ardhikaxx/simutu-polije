<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_survei', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('target_responden', ['mahasiswa', 'dosen', 'alumni', 'mitra_industri', 'tendik']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_survei');
    }
};
