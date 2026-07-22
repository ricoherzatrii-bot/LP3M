<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akreditasi extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara spesifik sesuai di database SQL kamu
    protected $table = 'akreditasi';

    // Izinkan semua kolom untuk diisi (mass assignment)
    protected $guarded = [];

    // Jika tabel kamu tidak memiliki kolom created_at dan updated_at, aktifkan ini:
    // public $timestamps = false;
}