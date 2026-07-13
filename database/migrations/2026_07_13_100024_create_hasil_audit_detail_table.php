<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_audit_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hasil_audit_id')->constrained('hasil_audit')->cascadeOnDelete();
            $table->foreignId('checklist_audit_item_id')->constrained('checklist_audit_item')->cascadeOnDelete();
            $table->decimal('skor_diberikan', 5, 2)->nullable();
            $table->text('catatan_auditor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_audit_detail');
    }
};
