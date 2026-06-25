<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jurnal_ibadahs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('santri_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->date('tanggal');

            $table->tinyInteger('shalat_subuh')->default(0);
            $table->tinyInteger('shalat_dzuhur')->default(0);
            $table->tinyInteger('shalat_ashar')->default(0);
            $table->tinyInteger('shalat_maghrib')->default(0);
            $table->tinyInteger('shalat_isya')->default(0);

            $table->boolean('puasa_sunnah')->default(false);
            $table->integer('tilawah_halaman')->default(0); 
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['santri_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_ibadahs');
    }
};
