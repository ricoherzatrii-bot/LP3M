<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuesionerResponse extends Model
{
    protected $table = 'kuesioner_response';

    protected $fillable = [
        'kuesioner_id',
        'pertanyaan_id',
        'jawaban',
        'session_id',
        'ip_address'
    ];

    public function kuesioner()
    {
        return $this->belongsTo(Kuesioner::class);
    }

    public function pertanyaan()
    {
        return $this->belongsTo(KuesionerPertanyaan::class, 'pertanyaan_id');
    }
}
