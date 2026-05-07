<?php

namespace App\Http\Controllers;

use App\Models\Spmi;
use Illuminate\Http\Request;

class SpmiController extends Controller
{
    public function index()
    {
        $data = Spmi::all();
        return view('spmi.index', compact('data'));
    }
}