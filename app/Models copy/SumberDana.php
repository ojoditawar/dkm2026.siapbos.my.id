<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SumberDana extends Model
{
    protected $table = 'sumber_danas';
    protected $fillable = [
        'kode',
        'nama',
        'keterangan',
    ];
    public function subDanas()
    {
        return $this->hasMany(SubDana::class, 'sumber', 'kode');
    }
}
