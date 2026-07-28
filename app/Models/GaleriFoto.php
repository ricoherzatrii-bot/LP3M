<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriFoto extends Model
{
    protected $table = 'galeri_foto';

    public const UPDATED_AT = null;

    protected $fillable = [
        'album_id',
        'file_path',
        'judul',
        'deskripsi',
        'keterangan'
    ];

    public function album()
    {
        return $this->belongsTo(GaleriAlbum::class, 'album_id');
    }
}
