<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';

    protected $fillable = [
        'struktur_kode',
        'uraian',
    ];

    public function struktur()
    {
        return $this->belongsTo(Struktur::class, 'struktur_kode', 'kode');
    }
}
