<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalurZakat extends Model
{
    protected $table = 'salur_zakats';

    protected $fillable = [
        'nomor',
        'tanggal',
        'jenis',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'status' => 'boolean',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(SalurZakatDetail::class);
    }
}
