<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_audit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_audit_id')->constrained('jadwal_audit')->cascadeOnDelete();
            $table->foreignId('checklist_audit_template_id')->constrained('checklist_audit_template')->cascadeOnDelete();
            $table->decimal('total_skor', 10, 2)->nullable();
            $table->text('kesimpulan')->nullable();
            $table->enum('status', ['Draft', 'Submitted', 'Reviewed', 'Approved'])->default('Draft');
            $table->string('berita_acara_file')->nullable();
            $table->json('ditandatangani_oleh')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_audit');
    }
};
