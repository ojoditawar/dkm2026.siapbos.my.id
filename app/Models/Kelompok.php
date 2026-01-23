<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    protected $table = 'kelompok';
    protected $primaryKey = 'kelompok';
    // protected $primaryKey = ['kode', 'kelompok'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'kode',
        'kelompok',
        'nama',
        'keterangan',
    ];
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'kode', 'kode');
    }
}
