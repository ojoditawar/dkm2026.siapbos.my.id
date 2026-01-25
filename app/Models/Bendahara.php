<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bendahara extends Model
{
    protected $fillable = [
        'masjid_id',
        'bp',
        'nama',
        'keterangan',
    ];

    public function masjid()
    {
        return $this->belongsTo(Masjid::class);
    }
}
