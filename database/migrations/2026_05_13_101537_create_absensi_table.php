<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {

            $table->id();

            // RELASI KE JADWAL
            $table->foreignId('jadwal_id')
                ->constrained('jadwal')
                ->onDelete('cascade');

            // RELASI KE SISWA
            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->onDelete('cascade');

            // TANGGAL ABSENSI
            $table->date('tanggal');

            // STATUS KEHADIRAN
            $table->enum('status', [
                'Hadir',
                'Izin',
                'Sakit',
                'Alpha'
            ])->default('Hadir');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};