<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MappingRekening extends Model
{
    protected $table = 'mapping_rekenings';

    protected $fillable = [
        'mapping',
        'transaksi',
        'bayar',
        'jurnal',
        'kolom',
        'keterangan',
    ];

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'mapping', 'jenis');
    }
}
