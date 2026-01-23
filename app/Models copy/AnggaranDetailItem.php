<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnggaranDetailItem extends Model
{
    protected $table = 'anggaran_detail_items';

    protected $fillable = [
        'anggaran_id',
        'uraian_detail',
        'jumlah',
        'satuan',
        'harga',
        'total',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-calculate total before saving
        static::saving(function ($model) {
            $model->total = $model->jumlah * $model->harga;
        });
    }

    public function anggaran(): BelongsTo
    {
        return $this->belongsTo(Anggaran::class);
    }

    public function buktis()
    {
        return $this->hasMany(Bukti::class, 'anggaran_id');
    }
}
