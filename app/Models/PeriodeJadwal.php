<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeJadwal extends Model
{
    protected $table = 'periode_jadwal';

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}