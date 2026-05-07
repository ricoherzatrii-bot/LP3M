<?php

namespace App\Http\Controllers;

use App\Models\Akreditasi;
use Illuminate\Http\Request;

class AkreditasiController extends Controller
{
    public function index()
    {
        $data = Akreditasi::all();
        return view('akreditasi.index', compact('data'));
    }
}