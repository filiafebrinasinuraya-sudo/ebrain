<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Program;
use App\Models\Siswa;

class Kelas extends Model
{
    protected $fillable = [
        'program_id',
        'nama_kelas',
        'hari_belajar'
    ];

    /*
    |----------------------------------
    | RELASI
    |----------------------------------
    */

    // Kelas milik 1 program
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    // Kelas punya banyak siswa (many-to-many)
    public function siswa()
    {
        return $this->belongsToMany(
            Siswa::class,
            'siswa_kelas',
            'kelas_id',
            'siswa_id'
        );
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}