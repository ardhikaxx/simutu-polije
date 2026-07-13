<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tim_audit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_audit_id')->constrained('jadwal_audit')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('peran_dalam_tim', ['Anggota', 'Ketua Tim'])->default('Anggota');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tim_audit');
    }
};
