<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $guarded = [];

    protected $casts = [
        'publish_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
