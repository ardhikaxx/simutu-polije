<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eviden', function (Blueprint $table) {
            $table->id();
            $table->string('eviden_able_type');
            $table->unsignedBigInteger('eviden_able_id');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file_path')->nullable();
            $table->string('tipe_file')->nullable();
            $table->foreignId('diunggah_oleh')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['eviden_able_type', 'eviden_able_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eviden');
    }
};
