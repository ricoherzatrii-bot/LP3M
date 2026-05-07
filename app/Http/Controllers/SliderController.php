<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $data = Slider::orderBy('urutan', 'asc')->get();
        return view('slider.index', compact('data'));
    }
}