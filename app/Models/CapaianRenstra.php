<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaianRenstra extends Model
{
    protected $table = 'capaian_renstra';
    protected $fillable = ['program', 'indikator', 'pic', 'target', 'realisasi', 'tahun'];
}
