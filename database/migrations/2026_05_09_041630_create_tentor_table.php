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
        Schema::create('tentor', function (Blueprint $table) {

            $table->id();

            // RELASI USER
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained('users')
                  ->onDelete('cascade');

            // BIODATA
            $table->string('nama');

            $table->enum('jenis_kelamin', [
                'Laki-laki',
                'Perempuan'
            ]);

            $table->string('no_hp')->unique();

            $table->string('email')->nullable();

            $table->text('alamat')->nullable();

            // DATA AKADEMIK
            $table->enum('pendidikan_terakhir', [
                'D3',
                'D4',
                'S1',
                'S2'
            ]);

            $table->string('jurusan')->nullable();

            // DATA TAMBAHAN
            $table->date('tanggal_bergabung')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tentor');
    }
};