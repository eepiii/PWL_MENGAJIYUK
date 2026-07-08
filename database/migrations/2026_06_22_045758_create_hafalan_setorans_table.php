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
        Schema::create('hafalan_setorans', function (Blueprint $table) {
            $table->id();

            // WAJIB sebutkan nama tabel eksplisit di constrained().
            // Tanpa ini, Laravel akan menebak tabel dari nama kolom:
            // "santri_id" ditebak jadi tabel "santris" (TIDAK ADA), padahal harusnya "users".
            $table->foreignId('santri_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('surah_id')->constrained('surahs')->cascadeOnDelete();

            $table->integer('ayat_mulai');
            $table->integer('ayat_selesai');
            $table->string('audio_path')->nullable();
            $table->text('catatan')->nullable();
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