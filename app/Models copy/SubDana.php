<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubDana extends Model
{
    protected $table = 'sub_danas';
    protected $fillable = [
        'sumber',
        'sub',
        'nama',
        'keterangan',
    ];
    public function sumberDana()
    {
        return $this->belongsTo(SumberDana::class, 'sumber', 'kode');
    }
}
