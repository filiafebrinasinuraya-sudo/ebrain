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
        Schema::table('jadwal', function (Blueprint $table) {

            // hanya tambah kalau belum ada
            if (!Schema::hasColumn('jadwal', 'sesi_id')) {
                $table->foreignId('sesi_id')
                    ->after('hari')
                    ->constrained('sesi')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {

            // 🔁 balikin jam manual
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();

            // ❌ hapus sesi
            $table->dropForeign(['sesi_id']);
            $table->dropColumn('sesi_id');
        });
    }
};