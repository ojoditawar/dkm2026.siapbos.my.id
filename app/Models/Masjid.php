<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Masjid extends Model
{
    protected $table = 'masjids';
    protected $fillable = [
        'nama',
        'alamat',
        'image',
    ];
    protected $casts = [
        'image' => 'array',
    ];

    // Configure UUID primary key  
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    // Auto-generate UUID when creating new records
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }
    public function bendaharas()
    {
        return $this->hasMany(Bendahara::class);
    }
}
