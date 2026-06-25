<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('surahs', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_surah')->unique();
            $table->string('nama_arab');
            $table->string('nama_latin');
            $table->string('arti');
            $table->integer('jumlah_ayat');
            $table->string('jenis');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('surahs');
    }
};