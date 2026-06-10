<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    protected $table = 'kuesioners';
    
    protected $fillable = [
        'judul',
        'kategori',
        'prodi',
        'tahun_akademik',
        'isi_artikel',
        'link_embed_grafik',
        'link_google_form',
        'slug',
        'hits'
    ];

    public function pertanyaans()
    {
        return $this->hasMany(KuesionerPertanyaan::class, 'kuesioner_id');
    }
}
