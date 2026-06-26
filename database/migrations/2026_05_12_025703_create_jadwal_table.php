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
        Schema::create('jadwal', function (Blueprint $table) {

            $table->id();

            // PERIODE
            $table->foreignId('periode_id')
                  ->constrained('periode_jadwal')
                  ->onDelete('cascade');

            // KELAS
            $table->foreignId('kelas_id')
                  ->constrained('kelas')
                  ->onDelete('cascade');

            // MATA PELAJARAN
            $table->foreignId('mata_pelajaran_id')
                  ->constrained('mata_pelajaran')
                  ->onDelete('cascade');

            // TENTOR
            $table->foreignId('tentor_id')
                  ->constrained('tentor')
                  ->onDelete('cascade');

            // RUANGAN
            $table->foreignId('ruangan_id')
                  ->constrained('ruangan')
                  ->onDelete('cascade');

            // HARI
            $table->string('hari');

            // JAM
            $table->time('jam_mulai');

            $table->time('jam_selesai');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
