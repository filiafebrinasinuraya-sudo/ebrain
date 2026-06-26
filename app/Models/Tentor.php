<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tentor extends Model
{
    protected $table = 'tentor';

    protected $fillable = [
        'user_id',
        'nama',
        'inisial',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'pendidikan_terakhir',
        'jurusan',
        'status',
        'tanggal_bergabung'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}