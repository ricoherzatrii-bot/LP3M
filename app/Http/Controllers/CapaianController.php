<?php

namespace App\Http\Controllers;

use App\Models\Capaian;
use Illuminate\Http\Request;

class CapaianController extends Controller
{
    public function index()
    {
        $data = Capaian::all();
        return view('capaian.index', compact('data'));
    }
}