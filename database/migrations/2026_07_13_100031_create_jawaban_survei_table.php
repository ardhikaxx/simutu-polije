<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban_survei', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survei_id')->constrained('survei')->cascadeOnDelete();
            $table->foreignId('pertanyaan_survei_id')->constrained('pertanyaan_survei')->cascadeOnDelete();
            $table->unsignedBigInteger('responden_id')->nullable();
            $table->integer('nilai_jawaban')->nullable();
            $table->text('teks_jawaban')->nullable();
            $table->timestamps();

            $table->foreign('responden_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_survei');
    }
};
