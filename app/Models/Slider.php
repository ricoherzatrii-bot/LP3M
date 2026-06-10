<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'sliders';

    protected $fillable = [
        'judul',
        'sub_judul',
        'gambar',
        'link_url',
        'urutan',
        'is_active',
    ];

    /**
     * URL publik untuk gambar slider
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        return asset('images/gedung-poljam.png');
    }
}
