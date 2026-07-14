<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('standar_mutu_id')->constrained('standar_mutu');
            $table->string('nama_template');
            $table->string('deskripsi')->nullable();
            $table->string('jenis_file')->default('pdf');
            $table->unsignedInteger('ukuran_file')->nullable()->comment('dalam KB');
            $table->unsignedInteger('downloads')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_dokumen');
    }
};
