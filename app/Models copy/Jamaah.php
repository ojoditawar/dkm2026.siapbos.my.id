<?php

namespace App\Models;

use App\Enums\JenisPekerjaan;
use Illuminate\Database\Eloquent\Model;

class Jamaah extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'telpon',
        'email',
        'pekerjaan',
        'status',
        'foto',
        'keterangan',
    ];

    protected $casts = [
        'pekerjaan' => JenisPekerjaan::class,
        'status' => 'boolean',
    ];
}
