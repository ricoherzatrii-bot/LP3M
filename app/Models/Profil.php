<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> f4da9032c9988bdd8d4d0196b006066481a9cda5
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
<<<<<<< HEAD
    //
}
=======
    use HasFactory;

    protected $table = 'profils';

    protected $fillable = [
        'judul',
        'isi'
    ];
}
>>>>>>> f4da9032c9988bdd8d4d0196b006066481a9cda5
