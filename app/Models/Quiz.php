<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quiz';

    protected $fillable = [
        'jadwal_id',
        'judul',
        'tanggal',
        'is_publish'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI JADWAL
    |--------------------------------------------------------------------------
    */
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI NILAI QUIZ
    |--------------------------------------------------------------------------
    */
    public function nilaiQuiz()
    {
        return $this->hasMany(NilaiQuiz::class);
    }
}