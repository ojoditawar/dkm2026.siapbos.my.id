<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailMutasi extends Model
{
    protected $fillable = [
        'mutasi_id',
        'level2_id',
        'kolom',
        'jumlah',
    ];

    public function mutasi()
    {
        return $this->belongsTo(Mutasi::class);
    }

    public function level2()
    {
        return $this->belongsTo(Level2::class);
    }
}
