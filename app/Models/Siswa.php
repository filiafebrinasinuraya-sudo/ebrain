<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kelas;
use App\Models\NilaiQuiz;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_hp',
        'agama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_sekolah',
        'kelas_sekolah',
        'ranking',
        'kurikulum',
        'nama_ayah',
        'no_hp_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'no_hp_ibu',
        'pekerjaan_ibu',
        'tanggal_daftar',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'date',
    ];

    protected $attributes = [
        'status' => 'Aktif',
    ];

    /*
    |----------------------------------
    | RELASI
    |----------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ⭐ siswa bisa ambil banyak kelas
    public function kelas()
    {
        return $this->belongsToMany(
            Kelas::class,
            'siswa_kelas',
            'siswa_id',
            'kelas_id'
        );
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function nilaiQuiz()
    {
        return $this->hasMany(NilaiQuiz::class);
    }
}