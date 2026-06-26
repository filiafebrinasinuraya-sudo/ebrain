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
            $table->foreign('sesi_id')
                ->references('id')
                ->on('sesi')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropForeign(['sesi_id']);
        });
    }
};
