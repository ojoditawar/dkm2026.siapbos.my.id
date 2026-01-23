<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Struktur extends Model
{
    protected $table = 'strukturs';

    protected $fillable = [
        'kode',
        'nama',
        'keterangan',
    ];
    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'struktur_kode', 'kode');
    }
}
