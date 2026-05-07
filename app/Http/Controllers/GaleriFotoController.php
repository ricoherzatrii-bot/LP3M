<?php

namespace App\Http\Controllers;

use App\Models\GaleriFoto;
use Illuminate\Http\Request;

class GaleriFotoController extends Controller
{
    public function index()
    {
        $data = GaleriFoto::latest()->get();
        return view('galeri_foto.index', compact('data'));
    }
}