<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checklist_audit_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_audit_template_id')->constrained('checklist_audit_template')->cascadeOnDelete();
            $table->text('pertanyaan');
            $table->decimal('bobot_skor', 5, 2)->default(1);
            $table->foreignId('indikator_mutu_id')->nullable()->constrained('indikator_mutu')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_audit_item');
    }
};
