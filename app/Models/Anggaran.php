<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anggaran extends Model
{
    protected $fillable = [
        'tahun_id',
        'level1_id',
        'level2_id',
        'level3_id',
        'sumber_dana_id',
        'sub_dana_id',
        'uraian',
        'keterangan',
        'detail_items',
    ];

    protected $casts = [
        'detail_items' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun_id', 'id');
    }

    public function level1()
    {
        return $this->belongsTo(Level1::class, 'level1_id', 'akun1');
    }
    public function level2()
    {
        return $this->belongsTo(Level2::class, 'level2_id', 'id');
    }
    public function level3()
    {
        return $this->belongsTo(Level3::class, 'level3_id', 'id');
    }
    public function sumber_dana()
    {
        return $this->belongsTo(SumberDana::class, 'sumber_dana_id', 'id');
    }
    public function sub_dana()
    {
        return $this->belongsTo(SubDana::class, 'sub_dana_id', 'id');
    }

    public function detailItems(): HasMany
    {
        return $this->hasMany(AnggaranDetailItem::class);
    }

    /**
     * Calculate grand total from detail items (tidak perlu update ke database)
     */
    public function updateGrandTotal()
    {
        // Method ini tetap ada untuk kompatibilitas, tapi tidak update ke database
        return $this->getCalculatedGrandTotal();
    }

    /**
     * Get calculated grand total from detail items
     */
    public function getCalculatedGrandTotal()
    {
        // Hitung total dari kolom 'total' di detail items
        return $this->detailItems()
            ->sum('total') ?? 0;
    }

    /**
     * Accessor untuk mendapatkan total anggaran
     */
    public function getTotalAnggaranAttribute()
    {
        return $this->getCalculatedGrandTotal();
    }
}
