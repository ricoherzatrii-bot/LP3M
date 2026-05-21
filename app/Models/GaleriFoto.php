<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriFoto extends Model
{
    protected $fillable = [
        'album_id',
        'file_path',
        'keterangan'
    ];

    public function album()
    {
        return $this->belongsTo(GaleriAlbum::class, 'album_id');
    }
}
