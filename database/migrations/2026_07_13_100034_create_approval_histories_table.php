<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_histories', function (Blueprint $table) {
            $table->id();
            $table->string('approvable_type');
            $table->unsignedBigInteger('approvable_id');
            $table->integer('step_ke');
            $table->foreignId('actor_id')->constrained('users')->cascadeOnDelete();
            $table->string('aksi');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['approvable_type', 'approvable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_histories');
    }
};
