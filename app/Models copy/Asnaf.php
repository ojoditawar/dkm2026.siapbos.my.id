<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asnaf extends Model
{
    protected $table = 'asnafs';
    protected $fillable = [
        'nama',
        'keterangan',
    ];
    public function detilAsnafs()
    {
        return $this->hasMany(DetilAsnaf::class);
    }
}
