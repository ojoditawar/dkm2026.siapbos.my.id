<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table = 'akun';
    protected $primaryKey = 'kode';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'kode',
        'nama',
        'keterangan',
    ];

    public function kelompoks()
    {
        return $this->hasMany(Kelompok::class, 'kode', 'kode');
    }
}
