<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    protected $table = 'penguruses';
    protected $fillable = [
        'tahun',
        'struktur_id',
        'nama',
        'status',
        'foto',
        'keterangan',
    ];

    public function struktur()
    {
        return $this->belongsTo(Struktur::class, 'struktur_id', 'kode');
    }
}
