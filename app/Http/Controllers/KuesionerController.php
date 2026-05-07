<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use Illuminate\Http\Request;

class KuesionerController extends Controller
{
    public function index()
    {
        $data = Kuesioner::all();
        return view('kuesioner.index', compact('data'));
    }
}