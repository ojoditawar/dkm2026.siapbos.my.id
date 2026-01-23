<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagu extends Model
{
    protected $table = 'pagus';

    protected $fillable = [
        'tahun',
        'user_id',
        'masjid_id',
        'rek_id',
        'sub_rek_id',
        'rekening_id',
        'rekening',
        'uraian',
        // 'jumlah',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    public function rek()
    {
        return $this->belongsTo(Rek::class, 'rek_id', 'id');
    }

    public function subRek()
    {
        return $this->belongsTo(SubRek::class, 'sub_rek_id', 'id');
    }
    public function reken()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id', 'id');
    }

    public function paguDetils()
    {
        return $this->hasMany(PaguDetil::class);
    }
}
