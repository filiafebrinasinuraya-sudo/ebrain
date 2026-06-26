<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiQuiz extends Model
{
    protected $table = 'nilai_quiz';

    protected $fillable = [
        'quiz_id',
        'siswa_id',
        'nilai'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI QUIZ
    |--------------------------------------------------------------------------
    */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI SISWA
    |--------------------------------------------------------------------------
    */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}