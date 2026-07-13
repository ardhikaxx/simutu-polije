<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tindak_lanjut_temuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('temuan_audit_id')->constrained('temuan_audit')->cascadeOnDelete();
            $table->foreignId('penanggung_jawab_id')->constrained('users')->cascadeOnDelete();
            $table->text('rencana_tindak_lanjut')->nullable();
            $table->date('target_selesai')->nullable();
            $table->enum('status', ['Open', 'On Progress', 'Need Revision', 'Verified', 'Closed'])->default('Open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut_temuan');
    }
};
