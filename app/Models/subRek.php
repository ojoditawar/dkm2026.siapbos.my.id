<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class subRek extends Model
{
    // Jika primary key-nya bukan 'id', tentukan di sini
    protected $table = 'sub_reks';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'rek_id',
        'kode',
        'kelompok',
        'nama',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->rek_id && !$model->kode) {
                $rek = \App\Models\Rek::find($model->rek_id);
                if ($rek) {
                    $model->kode = $rek->kode;
                    $model->kelompok = $model->kode . '.' . $model->kelompok;
                }
            }
        });
    }


    public function rek()
    {
        return $this->belongsTo(Rek::class, 'rek_id', 'id');
    }

    public function rekenings(): HasMany
    {
        // Sesuaikan foreign key jika Anda menggunakan string
        return $this->hasMany(Rekening::class, 'sub_rek_id', 'id');
    }

    // public function rekenings(): HasMany
    // {
    //     // Karena relasi menggunakan string 'akun' dan 'kelompok'
    //     return $this->hasMany(Rekening::class, 'kelompok', 'kelompok')
    //         ->where('akun', $this->akun);
    // }
}
