<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class Level3 extends Model
{
    use Compoships;
    protected $table = 'level3s';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'level2_id',
        // 'akun1',
        // 'akun2',
        'akun3',
        'nama',
        'slug',
        'keterangan',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function level1()
    {
        return $this->belongsTo(Level1::class, 'akun1', 'akun1');
    }

    public function level2()
    {
        //  return Level2::where('akun1', $this->akun1)
        //          ->where('akun2', $this->akun2)
        //          ->first();
        return $this->belongsTo(Level2::class, 'level2_id', 'id');
    }
}
