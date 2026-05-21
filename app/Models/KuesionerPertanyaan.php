<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuesionerPertanyaan extends Model
{
    protected $table = 'kuesioner_pertanyaans';

    protected $fillable = [
        'kuesioner_id',
        'pertanyaan',
        'tipe_jawaban',
        'opsi_jawaban',
        'urutan'
    ];

    public function kuesioner()
    {
        return $this->belongsTo(Kuesioner::class);
    }
}
