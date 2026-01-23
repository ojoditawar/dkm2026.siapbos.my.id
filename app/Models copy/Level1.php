<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level1 extends Model
{
    protected $table = 'level1s';
    protected $primaryKey = 'akun1';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'akun1',
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

    public function level2s()
    {
        return $this->hasMany(Level2::class, 'akun1', 'akun1');
    }
}
