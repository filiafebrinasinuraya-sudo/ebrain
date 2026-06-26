<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();

            // RELASI USER
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Data pribadi
            $table->string('nama');
            $table->text('alamat');
            $table->string('no_hp');


            $table->enum('agama', [
                'Islam',
                'Kristen Protestan',
                'Katolik',
                'Hindu',
                'Budha',
                'Konghucu'
            ]);

            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');

            // Data sekolah
            $table->string('asal_sekolah');
            $table->string('kelas_sekolah');
            $table->integer('ranking')->nullable();
            $table->enum('kurikulum', ['KTSP', 'K13', 'K13 Revisi', 'SKS', 'Lainnya']);

            // Data orang tua
            $table->string('nama_ayah');
            $table->string('no_hp_ayah');
            $table->string('pekerjaan_ayah')->nullable();

            $table->string('nama_ibu');
            $table->string('no_hp_ibu');
            $table->string('pekerjaan_ibu')->nullable();

            // Data tambahan
            $table->date('tanggal_daftar');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');

            $table->timestamps();

            // (opsional) relasi kelas
            // $table->foreign('kelas_id')
            //     ->references('id')
            //     ->on('kelas')
            //     ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};