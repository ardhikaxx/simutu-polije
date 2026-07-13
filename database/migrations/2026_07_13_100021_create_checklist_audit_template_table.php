<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checklist_audit_template', function (Blueprint $table) {
            $table->id();
            $table->string('nama_template');
            $table->foreignId('standar_mutu_id')->nullable()->constrained('standar_mutu')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_audit_template');
    }
};
