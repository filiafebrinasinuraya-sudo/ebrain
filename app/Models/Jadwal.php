<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'periode_id',
        'kelas_id',
        'mata_pelajaran_id',
        'tentor_id',
        'ruangan_id',
        'sesi_id',   // ✅ TAMBAH INI
        'hari',
    ];

    /*
    |----------------------------------------------------------------------
    | RELASI
    |----------------------------------------------------------------------
    */

    public function periode()
    {
        return $this->belongsTo(PeriodeJadwal::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function tentor()
    {
        return $this->belongsTo(Tentor::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function quiz()
    {
        return $this->hasMany(Quiz::class);
    }
}