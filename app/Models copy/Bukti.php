<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bukti extends Model
{
    protected $table = 'buktis';
    protected $fillable = [
        'pagudetil_id',
        'nomor',
        'tanggal',
        'uraian',
        'jumlah',
        // 'dana',
        'keterangan',
        'file_bukti',
        'kode',
        'penerima',
    ];

    public function anggaranDetailItem()
    {
        return $this->belongsTo(AnggaranDetailItem::class, 'anggaran_id');
    }

    public function danaLevel3()
    {
        return $this->belongsTo(Level3::class, 'dana', 'id');
    }
    public function paguDetil()
    {
        return $this->belongsTo(PaguDetil::class, 'pagudetil_id', 'id');
    }
}
