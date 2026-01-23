<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rek extends Model
{
    protected $fillable = [
        'kode',
        'nama',
    ];
    public function subRek()
    {
        return $this->hasMany(subRek::class, 'rek_id', 'id');
    }

    public function pagu()
    {
        return $this->hasMany(Pagu::class, 'rekening_id', 'id');
    }
}
