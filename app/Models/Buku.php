<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'rekening_id',
        'jenis',
        'nama',
        'subjenis',
        'nmsub',
    ];

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id');
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->rekening_id) {
                $rekening = Rekening::find($model->rekening_id);
                if ($rekening) {
                    // Auto-populate jenis and nama from related Rekening
                    if (!$model->jenis) {
                        $model->jenis = $rekening->jenis;
                    }
                    if (!$model->nama) {
                        $model->nama = $rekening->nama;
                    }
                }
            }
        });
    }
}
