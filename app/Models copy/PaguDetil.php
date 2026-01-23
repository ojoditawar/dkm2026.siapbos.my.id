<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaguDetil extends Model
{
    protected $table = 'pagu_detils';
    protected $fillable = [
        'pagu_id',
        'uraian_detail',
        'jumlah',
        'satuan',
        'harga',
        'total',

    ];

    public function pagu()
    {
        return $this->belongsTo(Pagu::class);
    }
}
