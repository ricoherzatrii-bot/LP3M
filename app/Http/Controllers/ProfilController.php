<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profil;

class ProfilController extends Controller
{
    public function index()
    {
        $data = Profil::all();
        return view('profil', compact('data'));
    }

    public function store(Request $request)
    {
        Profil::create([
            'judul' => $request->judul,
            'isi' => $request->isi
        ]);

        return redirect('/profil');
    }
}