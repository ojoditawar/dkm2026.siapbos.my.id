<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkunLevel3 extends Model
{
    protected $table = 'akun_level3s';
    protected $primaryKey = 'id';
    protected $fillable = [
        'akun1',
        'akun2',
        'akun3',
        'jenis',
        'keterangan',
    ];
    public function akunLevel1()
    {
        return $this->belongsTo(AkunLevel1::class, 'akun1', 'akun1');
    }
    public function akunLevel2()
    {
        return $this->belongsTo(AkunLevel2::class, 'akun2', 'akun2');
    }
}
