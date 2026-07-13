<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('jurusan_id')->references('id')->on('fakultas_jurusan')->nullOnDelete();
            $table->foreign('program_studi_id')->references('id')->on('program_studi')->nullOnDelete();
            $table->foreign('unit_kerja_id')->references('id')->on('unit_kerja')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropForeign(['program_studi_id']);
            $table->dropForeign(['unit_kerja_id']);
        });
    }
};
