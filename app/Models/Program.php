<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kelas;

class Program extends Model
{
    protected $table = 'programs';

    protected $fillable = [ 'nama_program'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'program_id');
    }
}