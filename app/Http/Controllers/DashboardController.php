<?php

namespace App\Http\Controllers;

use App\Models\Profil;

class DashboardController extends Controller
{
    public function index()
    {
        $data = Profil::all();
        return view('dashboard', compact('data'));
    }
}