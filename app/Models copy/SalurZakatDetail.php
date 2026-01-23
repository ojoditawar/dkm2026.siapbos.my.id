<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalurZakatDetail extends Model
{
    protected $fillable = [
        'salur_zakat_id',
        'detil_asnaf_id',
        'jenis',
        'satuan',
        'alamat',
        'keterangan',
    ];

    protected $casts = [
        'satuan' => 'decimal:2',
    ];

    public function salurZakat(): BelongsTo
    {
        return $this->belongsTo(SalurZakat::class);
    }

    public function detilAsnaf(): BelongsTo
    {
        return $this->belongsTo(DetilAsnaf::class);
    }
}
