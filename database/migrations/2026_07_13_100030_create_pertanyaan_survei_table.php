<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertanyaan_survei', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survei_id')->constrained('survei')->cascadeOnDelete();
            $table->text('teks_pertanyaan');
            $table->enum('tipe_jawaban', ['skala_likert', 'pilihan_ganda', 'esai'])->default('skala_likert');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_survei');
    }
};
