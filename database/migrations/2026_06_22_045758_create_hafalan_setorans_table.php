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
            $table->foreignId('surah_id')->constrained('surahs')->onDelete('cascade');
            $table->unsignedInteger('ayat_mulai');
            $table->unsignedInteger('ayat_selesai');
            $table->string('audio_path'); // hasil rekaman mic santri
            $table->text('catatan')->nullable(); // catatan dari santri saat submit
            $table->string('status')->default('menunggu'); // menunggu | dinilai
            $table->timestamps();

            $table->index(['santri_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hafalan_setorans');
    }
};