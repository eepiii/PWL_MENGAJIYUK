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
        Schema::create('nilai_hafalans', function (Blueprint $table) {
            $table->foreignId('setoran_id')
              ->constrained('hafalan_setoran')
              ->onDelete('cascade');
            $table->foreignId('guru_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('santri_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->tinyInteger('nilai');       
            $table->enum('kategori', [
                'lancar', 
                'cukup', 
                'perlu_ulang'
            ])->default('cukup');
            $table->text('catatan_guru')->nullable();
            $table->timestamp('dinilai_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_hafalans');
    }
};
