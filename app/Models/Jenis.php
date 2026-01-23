<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{

    protected $table = 'jenis';

    protected $fillable = [
        'kode',
        'kelompok',
        'jenis',
        'nama',
        'keterangan',
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'kode', 'kode');
    }

    public function kelompokRelation()
    {
        return $this->belongsTo(Kelompok::class, ['kode', 'kelompok'], ['kode', 'kelompok']);
    }
}
