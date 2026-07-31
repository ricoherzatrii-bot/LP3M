<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'slider';

    protected $fillable = [
        'judul',
        'sub_judul',
        'gambar',
        'link_url',
        'urutan',
        'is_active',
    ];

    /**
     * Accessor untuk URL gambar slider - automatically convert path to asset URL
     */
    public function getGambarUrlAttribute(): ?string
    {
        if (!$this->gambar) {
            return asset('images/gedung-poljam.png');
        }
        
        $path = $this->gambar;
        
        // If it's already a full URL, return as-is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        
        // If it's a relative path, prepend /storage/
        if (!str_starts_with($path, '/storage/')) {
            return asset('storage/' . $path);
        }
        
        return asset($path);
    }
}
