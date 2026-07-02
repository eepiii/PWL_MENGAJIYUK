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
        $table->string('surah'); // <-- Pastikan baris ini ada
        $table->string('audio_path');
        $table->text('catatan')->nullable();
        $table->string('audio_path')->nullable()->after('surah');
        $table->text('catatan')->nullable()->after('audio_path');
        $table->timestamps();
    });



}
    public function down(): void
    {
       Schema::table('hafalan_setorans', function (Blueprint $table) {
            $table->dropColumn(['audio_path', 'catatan']);
        });
    }
};