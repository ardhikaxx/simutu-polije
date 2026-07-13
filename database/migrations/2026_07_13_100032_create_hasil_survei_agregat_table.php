<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_survei_agregat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survei_id')->constrained('survei')->cascadeOnDelete();
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studi')->nullOnDelete();
            $table->decimal('indeks_kepuasan', 5, 2)->nullable();
            $table->integer('jumlah_responden')->default(0);
            $table->timestamp('dihitung_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_survei_agregat');
    }
};
