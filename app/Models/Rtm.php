<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Rtm extends Model
{
    protected $table = 'rtm';

    protected $fillable = [
        'judul',
        'tahun',
        'deskripsi',
        'nama_file',
        'path_file',
        'ukuran_file',
        'tipe_file',
        'kategori',
        'slug',
        'downloads',
    ];

    protected $casts = [
        'tahun'      => 'integer',
        'downloads'  => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * URL publik file dokumen
     */
    public function getFileUrlAttribute(): ?string
    {
        if ($this->path_file) {
            return Storage::url($this->path_file);
        }
        return null;
    }

    /**
     * Ikon berdasarkan tipe file
     */
    public function getIconClassAttribute(): string
    {
        return match($this->tipe_file) {
            'pdf'  => 'fas fa-file-pdf text-red-400',
            'doc', 'docx' => 'fas fa-file-word text-blue-400',
            'xls', 'xlsx' => 'fas fa-file-excel text-green-400',
            'ppt', 'pptx' => 'fas fa-file-powerpoint text-orange-400',
            'zip', 'rar'  => 'fas fa-file-archive text-yellow-400',
            default        => 'fas fa-file-alt text-slate-400',
        };
    }
}
