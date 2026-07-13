<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fakultas_jurusan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jurusan');
            $table->string('kode_jurusan');
            $table->unsignedBigInteger('ketua_jurusan_id')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fakultas_jurusan');
    }
};
