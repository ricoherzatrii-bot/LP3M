<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';
    protected $guarded = [];

    protected $casts = [
        'tanggal_arsip' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Accessor untuk URL gambar fitur
     */
    public function getGambarFiturUrlAttribute(): ?string
    {
        if ($this->gambar_fitur) {
            if (str_starts_with($this->gambar_fitur, 'http://') || str_starts_with($this->gambar_fitur, 'https://')) {
                return $this->gambar_fitur;
            }
            return asset('storage/' . $this->gambar_fitur);
        }
        return asset('images/gedung-poljam.png');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($artikel) {
            if (empty($artikel->slug)) {
                $artikel->slug = Str::slug($artikel->judul . '-' . uniqid());
            }
        });
        static::updating(function ($artikel) {
            if (empty($artikel->slug)) {
                $artikel->slug = Str::slug($artikel->judul . '-' . uniqid());
            }
        });
    }
}
