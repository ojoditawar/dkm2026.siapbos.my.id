<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class Level2 extends Model
{
    use Compoships;
    protected $table = 'level2s';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'akun1',
        'akun2',
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

    public function pagus()
    {
        return $this->hasMany(Pagu::class, 'sdana', 'id');
    }

    public function level3s()
    {
        return $this->hasMany(Level3::class, 'level2_id', 'id');
    }
}
