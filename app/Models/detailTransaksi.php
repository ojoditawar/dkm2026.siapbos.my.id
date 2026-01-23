<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detailTransaksi extends Model
{
    protected $table = 'detail_transaksis';

    protected $fillable = [
        'transaksi_id',
        'uraian',
        'jumlah',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
