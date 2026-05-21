<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriVideo extends Model
{
    protected $fillable = [
        'judul',
        'link_youtube',
        'deskripsi',
        'slug'
    ];
}
