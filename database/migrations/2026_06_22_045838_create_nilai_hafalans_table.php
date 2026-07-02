<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_hafalans', function (Blueprint $table) {
            $table->id();

            // Relasi ke setoran yang dinilai
            $table->foreignId('hafalan_setoran_id')
                ->constrained('hafalan_setorans')
                ->onDelete('cascade');

            // Guru yang menilai
            $table->foreignId('guru_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Komponen penilaian
            $table->unsignedTinyInteger('kelancaran'); // 0-100
            $table->unsignedTinyInteger('tajwid');      // 0-100
            $table->unsignedTinyInteger('makhraj');     // 0-100

            // Nilai akhir (rata-rata dari 3 komponen di atas)
            $table->unsignedTinyInteger('nilai_total');

            // Catatan/feedback dari guru
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Satu setoran hanya boleh dinilai sekali
            $table->unique('hafalan_setoran_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_hafalans');
    }
};