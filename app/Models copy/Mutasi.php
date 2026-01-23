<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $fillable = [
        'nomor',
        'tanggal',
        'uraian',
        // 'kolom',
        'file_bukti',
        'kode',
    ];

    public function detailMutasis()
    {
        return $this->hasMany(DetailMutasi::class);
    }
}
