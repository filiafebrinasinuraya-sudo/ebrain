<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa_kelas', function (Blueprint $table) {
            $table->id();

            // relasi ke siswa
            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->onDelete('cascade');

            // relasi ke kelas  
            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_kelas');
    }
};