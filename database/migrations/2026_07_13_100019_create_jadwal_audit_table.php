<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_audit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_audit_id')->constrained('periode_audit')->cascadeOnDelete();
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studi')->nullOnDelete();
            $table->foreignId('unit_kerja_id')->nullable()->constrained('unit_kerja')->nullOnDelete();
            $table->date('tanggal_audit');
            $table->enum('jenis_audit', ['Reguler', 'Khusus'])->default('Reguler');
            $table->enum('status', ['Draft', 'Terjadwal', 'Berlangsung', 'Selesai'])->default('Draft');
            $table->foreignId('dibuat_oleh')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_audit');
    }
};
