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

            $table->foreignId('hafalan_setoran_id')
                ->constrained('hafalan_setorans')
                ->onDelete('cascade');

            $table->foreignId('guru_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->unsignedTinyInteger('kelancaran'); // 0-100
            $table->unsignedTinyInteger('tajwid');      // 0-100
            $table->unsignedTinyInteger('makhraj');     // 0-100
            $table->unsignedTinyInteger('nilai_total');

            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->unique('hafalan_setoran_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_hafalans');
    }
};