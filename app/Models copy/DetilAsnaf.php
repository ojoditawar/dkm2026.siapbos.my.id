<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetilAsnaf extends Model
{
    protected $table = 'detil_asnafs';
    protected $fillable = [
        'asnaf_id',
        'nama',
        'jenis',
        'alamat',
        'hp',
        'satuan',
        'ktp',
        'rekening',
        'bank',
        'foto',
        'keterangan',
        'status',
    ];

    public function asnaf()
    {
        return $this->belongsTo(Asnaf::class);
    }
}
