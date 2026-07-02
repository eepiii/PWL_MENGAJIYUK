<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hafalan_setorans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('users')->onDelete('cascade');
            $table->string('surah');
            $table->string('audio_path');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hafalan_setorans');
    }
};