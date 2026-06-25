<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hafalan_setorans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('surah_id')->constrained('surahs')->cascadeOnDelete();
            $table->integer('ayat_mulai');
            $table->integer('ayat_selesai');
            $table->string('status');
            $table->text('catatan_santri')->nullable();
            $table->timestamp('disetor_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('hafalan_setorans');
    }
};