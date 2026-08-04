<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Pengumuman;
use App\Models\Profil;
use App\Models\Slider;
use App\Helpers\HtmlSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $allProfil = Profil::all();
        $sliders = Slider::orderBy('urutan', 'asc')->get();
        
        $sliderItems = collect();
        if ($sliders->count() > 0) {
            foreach($sliders as $s) {
                $sliderUrl = null;

                if ($s->gambar) {
                    if (str_starts_with($s->gambar, 'http://') || str_starts_with($s->gambar, 'https://')) {
                        $sliderUrl = $s->gambar;
                    } else {
                        $storagePath = public_path('storage/' . ltrim($s->gambar, '/'));
                        $imagePath = public_path('images/' . ltrim($s->gambar, '/'));

                        if (file_exists($storagePath)) {
                            $sliderUrl = asset('storage/' . ltrim($s->gambar, '/'));
                        } elseif (file_exists($imagePath)) {
                            $sliderUrl = asset('images/' . ltrim($s->gambar, '/'));
                        }
                    }
                }

                if ($sliderUrl) {
                    $sliderItems->push((object)[
                        'judul' => $s->judul,
                        'subjudul' => $s->sub_judul,
                        'gambar' => $s->gambar,
                        'gambar_url' => $sliderUrl,
                        'url' => $s->link_url ?? '#',
                        'is_external' => true
                    ]);
                }
            }
        } else {
            // Fallback ke Artikel
            $articles = Artikel::latest()->take(5)->get();
            foreach($articles as $a) {
                $sliderItems->push((object)[
                    'judul' => $a->judul,
                    'subjudul' => Str::limit(strip_tags($a->isi_konten), 100),
                    'gambar' => $a->gambar_fitur,
                    'gambar_url' => $a->gambar_fitur_url,
                    'url' => route('berita.show', $a->slug),
                    'is_external' => false,
                    'created_at' => $a->created_at
                ]);
            }
        }

        $beritaList = Artikel::latest()->paginate(6);
        $pengumumanAktif = Pengumuman::where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('welcome', compact('allProfil', 'sliderItems', 'beritaList', 'pengumumanAktif'));
    }

    public function beritaShow($slug)
    {
        $allProfil = Profil::all();
        $berita = Artikel::where('slug', $slug)->firstOrFail();
        $berita->isi_konten = HtmlSanitizer::sanitize($berita->isi_konten);
        $recentBerita = Artikel::where('id', '!=', $berita->id)->latest()->take(5)->get();
        return view('pages.berita.show', compact('allProfil', 'berita', 'recentBerita'));
    }

    public function spmiIndex()
    {
        return view('pages.spmi.index');
    }

    public function kuesionerIndex()
    {
        return view('pages.kuesioner.index');
    }
}
