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
        Schema::create('nilai_quiz', function (Blueprint $table) {

            $table->id();
        
            $table->foreignId('quiz_id')
                ->constrained('quiz')
                ->cascadeOnDelete();

            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->cascadeOnDelete();

            $table->decimal('nilai', 5, 2);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | CEGAH DUPLIKAT
            |--------------------------------------------------------------------------
            */
            $table->unique([
                'quiz_id',
                'siswa_id'
            ]);

        });
    }

    /**
     * REVERSE MIGRATIONS
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_quiz');
    }
};