<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkunLevel1 extends Model
{
    protected $table = 'akun_level1s';

    protected $fillable = [
        'akun1',
        'nama',
        'keterangan',
    ];

    public function akunLevel2()
    {
        return $this->hasMany(AkunLevel2::class, 'akun1', 'akun1');
    }
}
