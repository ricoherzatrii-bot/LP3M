<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriAlbum extends Model
{
    protected $table = 'galeri_album';

    protected $fillable = [
        'nama_album',
        'slug',
        'sampul_foto'
    ];

    public function fotos()
    {
        return $this->hasMany(GaleriFoto::class, 'album_id');
    }

    public function firstFoto()
    {
        return $this->hasOne(GaleriFoto::class, 'album_id')->oldestOfMany();
    }
}
