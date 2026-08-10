<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PilarRenstra extends Model
{
    protected $table = 'pilar_renstra';
    protected $fillable = ['kode', 'judul', 'warna', 'gradient_class', 'urutan'];
}
