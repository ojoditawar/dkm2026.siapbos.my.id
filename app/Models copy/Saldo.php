<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $table = 'saldos';

    protected $fillable = [
        'tahun_id',
        'akun1',
        'level2_id',
        'level3_id',
        'bank',
        'rekening',
        'jumlah',
        'keterangan',
    ];

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun_id', 'id');
    }

    public function akun1()
    {
        return $this->belongsTo(Level1::class, 'akun1', 'akun1');
    }

    public function level2()
    {
        return $this->belongsTo(Level2::class, 'level2_id', 'id');
    }

    public function level3()
    {
        return $this->belongsTo(Level3::class, 'level3_id', 'id');
    }
}
