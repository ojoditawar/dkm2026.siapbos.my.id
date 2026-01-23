<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $fillable = [
        'rek_id',
        'sub_rek_id',
        'akun',
        'kelompok',
        'jenis',
        'nama',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->sub_rek_id) {
                $subRek = \App\Models\subRek::find($model->sub_rek_id);
                if ($subRek) {
                    if (!$model->rek_id) {
                        $model->rek_id = $subRek->rek_id;
                    }
                    if (!$model->akun) {
                        $model->akun = $subRek->kode;
                    }
                    if (!$model->kelompok) {
                        $model->kelompok = $subRek->kelompok;
                    }
                    // Auto-generate jenis as kelompok + '.' + jenis input (only on create)
                    if ($model->jenis && $model->kelompok && !$model->exists) {
                        $model->jenis = $model->kelompok . '.' . $model->jenis;
                    }
                }
            }
        });
    }

    public function subRek()
    {
        return $this->belongsTo(SubRek::class, 'sub_rek_id', 'id');
    }

    public function rek()
    {
        return $this->belongsTo(Rek::class, 'rek_id', 'id');
    }

    public function mappingAkun()
    {
        return $this->hasMany(MappingRekening::class, 'mapping', 'jenis');
    }

    public function buku()
    {
        return $this->hasMany(Buku::class, 'rekening_id', 'id');
    }
}
