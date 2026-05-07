<?php

namespace App\Http\Controllers;

use App\Models\GaleriAlbum;
use Illuminate\Http\Request;

class GaleriAlbumController extends Controller
{
    public function index()
    {
        $data = GaleriAlbum::with('fotos')->get();
        return view('galeri_album.index', compact('data'));
    }
}