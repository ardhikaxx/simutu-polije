<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppepp_evaluasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ppepp_siklus_id')->constrained('ppepp_siklus')->cascadeOnDelete();
            $table->foreignId('capaian_indikator_id')->constrained('capaian_indikator')->cascadeOnDelete();
            $table->text('catatan_evaluasi')->nullable();
            $table->unsignedBigInteger('dievaluasi_oleh')->nullable();
            $table->timestamps();

            $table->foreign('dievaluasi_oleh')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppepp_evaluasi');
    }
};
