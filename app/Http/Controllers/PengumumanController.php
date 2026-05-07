<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $data = Pengumuman::where('is_active', 1)->latest()->get();
        return view('pengumuman.index', compact('data'));
    }
}