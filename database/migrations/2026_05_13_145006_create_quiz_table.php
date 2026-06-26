<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * RUN MIGRATIONS
     */
    public function up(): void
    {
        Schema::create('quiz', function (Blueprint $table) {

            $table->id();

            $table->foreignId('jadwal_id')
                ->constrained('jadwal')
                ->cascadeOnDelete();
                
            $table->string('judul');
            $table->date('tanggal');
            $table->boolean('is_publish')
                ->default(true);

            $table->timestamps();

        });
    }

    /**
     * REVERSE MIGRATIONS
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};