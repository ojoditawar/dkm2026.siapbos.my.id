<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class AkunLevel2 extends Model
{
    protected $table = 'akun_level2s';

    protected $fillable = [
        'akun1',
        'akun2',
        'kelompok',
        'keterangan',
    ];

    protected static function boot()
    {
        parent::boot();

        // Validasi sebelum menyimpan
        static::saving(function ($model) {
            if (empty($model->akun1)) {
                throw ValidationException::withMessages([
                    'akun1' => 'Akun Level 1 tidak boleh kosong'
                ]);
            }
            
            // Pastikan akun1 yang dipilih benar-benar ada di tabel akun_level1s
            if (!AkunLevel1::where('akun1', $model->akun1)->exists()) {
                throw ValidationException::withMessages([
                    'akun1' => 'Akun Level 1 yang dipilih tidak valid'
                ]);
            }
        });
    }

    public function akunLevel1()
    {
        return $this->belongsTo(AkunLevel1::class, 'akun1', 'akun1');
    }
}
