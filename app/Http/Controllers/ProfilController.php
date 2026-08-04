<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Helpers\HtmlSanitizer;

class ProfilController extends Controller
{
    /**
     * Fitur Pencarian Global
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|max:255',
        ]);

        $query = $request->input('q');
        
        $results = Profil::where('judul', 'LIKE', '%' . $query . '%')
            ->orWhere('isi_konten', 'LIKE', '%' . $query . '%')
            ->get();

        $allProfil = Profil::all();

        return view('pages.search', compact('results', 'query', 'allProfil'));
    }

    public function artikelIndex()
    {
        $allProfil = Profil::all();
        
        $kategoris = [
            [
                'nama' => 'Berita', 
                'slug' => 'berita', 
                'count' => \App\Models\Artikel::where('kategori', 'Berita')->count()
            ],
            [
                'nama' => 'Kegiatan', 
                'slug' => 'kegiatan', 
                'count' => \App\Models\Artikel::where('kategori', 'Kegiatan')->count()
            ],
            [
                'nama' => 'Profil', 
                'slug' => 'profil', 
                'count' => Profil::count()
            ],
        ];
        
        return view('pages.artikel.index', compact('allProfil', 'kategoris'));
    }

    /**
     * Menangani Halaman Artikel - Per Kategori
     */
    public function artikelKategori($kategori)
    {
        $allProfil = Profil::all();
        
        $title = ucfirst($kategori);
        $items = collect();

        if ($kategori === 'berita' || $kategori === 'kegiatan') {
            $articles = \App\Models\Artikel::where('kategori', $title)
                ->latest('updated_at')
                ->paginate(6);
            
            $articles->getCollection()->transform(function ($article) {
                $dateObj = $article->updated_at ?? $article->created_at ?? now();
                $imageUrl = null;

                if ($article->gambar_fitur) {
                    if (str_starts_with($article->gambar_fitur, 'http://') || str_starts_with($article->gambar_fitur, 'https://')) {
                        $imageUrl = $article->gambar_fitur;
                    } else {
                        $storagePath = public_path('storage/' . ltrim($article->gambar_fitur, '/'));
                        if (file_exists($storagePath)) {
                            $imageUrl = asset('storage/' . ltrim($article->gambar_fitur, '/'));
                        }
                    }
                }

                return (object)[
                    'judul' => $article->judul,
                    'tanggal' => $dateObj->translatedFormat('d F Y'),
                    'hits' => 0,
                    'deskripsi' => Str::limit(strip_tags($article->isi_konten), 150),
                    'slug' => $article->slug,
                    'gambar' => $imageUrl
                ];
            });
            $items = $articles;
        } elseif ($kategori === 'profil') {
            $profils = Profil::latest('created_at')->paginate(6);
            $profils->getCollection()->transform(function ($p) {
                return (object)[
                    'judul' => $p->judul,
                    'tanggal' => $p->created_at ? $p->created_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y'),
                    'hits' => $p->hits ?? 0,
                    'deskripsi' => Str::limit(strip_tags($p->isi_konten), 150),
                    'slug' => $p->slug,
                    'gambar' => null
                ];
            });
            $items = $profils;
        }

        $data = [
            'title' => $title,
            'items' => $items
        ];
        
        return view('pages.artikel.kategori', compact('allProfil', 'data', 'kategori'));
    }

    /**
     * Menangani Menu Profil Dinamis (Visi Misi, Job Desk, Artikel, dll)
     */
    public function show($slug)
    {
        // 1. Ambil SEMUA data profil untuk dropdown di Navbar
        $allProfil = Profil::all(); 

        // 2. Cari data spesifik berdasarkan slug
        $profil = Profil::where('slug', $slug)->first();

        // Cek jika data tidak ada
        if (!$profil) {
            return "Data dengan slug ($slug) tidak ditemukan di database.";
        }

        // 3. Ambil juga semua item pendukung dalam kategori yang sama jika ada
        $profilList = Profil::where('kategori', $profil->kategori)
            ->where('id', '!=', $profil->id)
            ->get();
            
        $prev = Profil::where('id', '<', $profil->id)->orderBy('id', 'desc')->first();
        $next = Profil::where('id', '>', $profil->id)->orderBy('id', 'asc')->first();
        $prevUrl = $prev ? route('profil.show', $prev->slug) : null;
        $nextUrl = $next ? route('profil.show', $next->slug) : null;

        // 4. Kirim variabel ke view
        return view('pages.profil.show', compact('profil', 'allProfil', 'profilList', 'prevUrl', 'nextUrl'));
    }

    /**
     * Menangani Menu SPMI Dinamis
     */
    public function showSpmi($slug)
    {
        $allProfil = Profil::all();
        
        // Cari di tabel Profil dulu, siapa tau ada
        $profil = Profil::where('slug', $slug)->first();
        
        if (!$profil) {
            // Jika tidak ada, cari di tabel Spmi (dengan penanganan jika tabel tidak ada)
            $spmi = null;
            try {
                if (Schema::hasTable('spmis') || Schema::hasTable('spmi')) {
                    $spmi = \App\Models\Spmi::where('slug', $slug)->first();
                }
            } catch (\Exception $e) {
                // Tabel spmis tidak ada, lanjut ke fallback
            }
            
            if ($spmi) {
                $profil = (object)[
                    'judul' => $spmi->judul,
                    'created_at' => $spmi->created_at,
                    'hits' => 0,
                    'isi_konten' => $spmi->deskripsi,
                ];
            } else {
                // Fallback untuk link navbar yang belum ada datanya (seperti 'unit', 'rtm', 'dokumen-spmi')
                $judul = str_replace('-', ' ', ucwords($slug));
                if (strtolower($judul) == 'Rtm') $judul = 'RTM';
                if (strtolower($judul) == 'Dokumen Spmi') $judul = 'Dokumen SPMI';
                
                $profil = (object)[
                    'judul' => $judul,
                    'created_at' => now(),
                    'hits' => 0,
                    'isi_konten' => '<p>Content sedang diproses, silahkan kunjungi beberapa saat lagi...</p>',
                ];
            }
        }
        
        return view('pages.profil.show', compact('profil', 'allProfil'));
    }

    /**
     * Menangani Menu Akreditasi
     */
    public function akreditasiIndex() {
        $allProfil = Profil::all();
        $data = \App\Models\Akreditasi::where('kategori', 'Akreditasi')->get();
        return view('akreditasi.index', compact('allProfil', 'data'));
    }

    public function akreditasiDokumen() {
        $allProfil = Profil::all();
        $data = \App\Models\Akreditasi::where('kategori', 'Dokumen Akreditasi')->get();
        return view('akreditasi.dokumen', compact('allProfil', 'data'));
    }

    /**
     * Menangani Menu Kuesioner
     */
    public function kuesionerDosen(Request $request) {
        $allProfil = Profil::all();
        
        $query = \App\Models\Kuesioner::where('kategori', 'Dosen & Karyawan');
        
        if ($request->has('tahun_akademik') && $request->tahun_akademik != '') {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }
        
        $kuesioner = $query->first();
        
        // Eager-load pertanyaan for dynamic form
        $pertanyaans = collect();
        if ($kuesioner && Schema::hasTable('kuesioner_pertanyaan')) {
            $pertanyaans = \App\Models\KuesionerPertanyaan::where('kuesioner_id', $kuesioner->id)
                ->orderBy('urutan', 'asc')
                ->get();
        }
        
        $tahunList = \App\Models\KuesionerDosenKaryawan::where('kategori', 'Dosen & Karyawan')
                                        ->select('tahun_akademik')
                                        ->whereNotNull('tahun_akademik')
                                        ->distinct()
                                        ->orderBy('tahun_akademik', 'desc')
                                        ->pluck('tahun_akademik');

        // Ambil data untuk grafik
        $chartData = collect();
        $respondenCount = 0;
        try {
            if (Schema::hasTable('kuesioner_dosen_karyawan')) {
                $chartDataQuery = \App\Models\KuesionerDosenKaryawan::query();
                $chartDataQuery->where('kategori', 'Dosen & Karyawan');
                
                if ($request->has('tahun_akademik') && $request->tahun_akademik != '') {
                    $chartDataQuery->where('tahun_akademik', $request->tahun_akademik);
                } elseif ($tahunList->count() > 0) {
                    // Default to latest year if no filter applied
                    $chartDataQuery->where('tahun_akademik', $tahunList->first());
                }
                
                $chartData = $chartDataQuery->get();

                // Calculate respondent count
                if ($kuesioner) {
                    $countFromRespon = \App\Models\KuesionerResponse::where('kuesioner_id', $kuesioner->id)->distinct('session_id')->count();
                    $respondenCount = $countFromRespon > 0 ? $countFromRespon : ($kuesioner->hits ?? 37);
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Table kuesioner_dosen_karyawan is missing or error: ' . $e->getMessage());
        }

        return view('pages.kuesioner.dosen', compact('allProfil', 'kuesioner', 'tahunList', 'pertanyaans', 'chartData', 'respondenCount'));
    }

    public function kuesionerMahasiswa(Request $request) {
        $allProfil = Profil::all();
        
        $query = \App\Models\Kuesioner::where('kategori', 'Mahasiswa');
        
        if ($request->has('prodi') && $request->prodi != '') {
            $query->where('prodi', $request->prodi);
        }
        
        if ($request->has('tahun_akademik') && $request->tahun_akademik != '') {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }
        
        $kuesioner = $query->first();
        
        // Eager-load pertanyaan for dynamic form
        $pertanyaans = collect();
        if ($kuesioner && Schema::hasTable('kuesioner_pertanyaan')) {
            $pertanyaans = \App\Models\KuesionerPertanyaan::where('kuesioner_id', $kuesioner->id)
                ->orderBy('urutan', 'asc')
                ->get();
        }
        
        $prodiFromKuesioner = \App\Models\KuesionerDosenKaryawan::where('kategori', 'Mahasiswa')
                                        ->select('prodi')
                                        ->whereNotNull('prodi')
                                        ->distinct()
                                        ->pluck('prodi');
        
        // Merge with canonical prodis table
        $prodiFromTable = collect();
        try {
            if (Schema::hasTable('prodis')) {
                $prodiFromTable = \App\Models\Prodi::orderBy('nama')->pluck('nama');
            }
        } catch (\Exception $e) {}

        // Also include prodi from akreditasi table
        $prodiFromAkreditasi = collect();
        try {
            if (Schema::hasTable('akreditasi')) {
                $prodiFromAkreditasi = \App\Models\Akreditasi::where('kategori', 'Akreditasi')->pluck('judul');
            }
        } catch (\Exception $e) {}
        
        $prodiList = $prodiFromKuesioner->merge($prodiFromTable)->merge($prodiFromAkreditasi)
            ->map(function ($prodi) { return trim($prodi); })
            ->filter(function ($prodi) { return !empty($prodi); })
            ->unique(function ($prodi) { return strtolower(trim($prodi)); })
            ->sort()
            ->values();
        $aspekList = \App\Models\KuesionerDosenKaryawan::where('kategori', 'Mahasiswa')
                                        ->select('program')
                                        ->whereNotNull('program')
                                        ->distinct()
                                        ->orderBy('program', 'asc')
                                        ->pluck('program');
        $tahunList = \App\Models\KuesionerDosenKaryawan::where('kategori', 'Mahasiswa')
                                        ->select('tahun_akademik')
                                        ->whereNotNull('tahun_akademik')
                                        ->distinct()
                                        ->orderBy('tahun_akademik', 'desc')
                                        ->pluck('tahun_akademik');

        // Ambil data untuk grafik
        $chartData = collect();
        try {
            if (Schema::hasTable('kuesioner_dosen_karyawan')) {
                $chartDataQuery = \App\Models\KuesionerDosenKaryawan::query();
                $chartDataQuery->where('kategori', 'Mahasiswa');
                
                $selectedProdi = $request->prodi;
                if ($selectedProdi && $selectedProdi !== 'all') {
                    $chartDataQuery->where('prodi', $selectedProdi);
                }
                
                $tahunAkademik = $request->tahun_akademik;
                if ($tahunAkademik) {
                    if (is_array($tahunAkademik)) {
                        if (!in_array('all', $tahunAkademik)) {
                            $chartDataQuery->whereIn('tahun_akademik', $tahunAkademik);
                        }
                    } else {
                        if ($tahunAkademik !== 'all' && $tahunAkademik !== '') {
                            $chartDataQuery->where('tahun_akademik', $tahunAkademik);
                        }
                    }
                } else {
                    if (!$request->has('tahun_akademik') && $tahunList->count() > 0) {
                        $chartDataQuery->where('tahun_akademik', $tahunList->first());
                    }
                }

                if ($request->has('aspek') && $request->aspek != '') {
                    $chartDataQuery->where('program', $request->aspek);
                }

                $chartDataQuery->select(
                    'prodi',
                    'program',
                    DB::raw('ROUND(AVG(sangat_setuju), 2) as sangat_setuju'),
                    DB::raw('ROUND(AVG(setuju), 2) as setuju'),
                    DB::raw('ROUND(AVG(tidak_setuju), 2) as tidak_setuju'),
                    DB::raw('ROUND(AVG(sangat_tidak_setuju), 2) as sangat_tidak_setuju')
                )->groupBy('prodi', 'program');

                $chartDataRaw = $chartDataQuery->get();
                
                if (!$selectedProdi || $selectedProdi === 'all') {
                    $chartData = $chartDataRaw->groupBy('prodi');
                } else {
                    $chartData = [$selectedProdi => $chartDataRaw];
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Table kuesioner_dosen_karyawan is missing or error: ' . $e->getMessage());
        }
                                        
        return view('pages.kuesioner.mahasiswa', compact('allProfil', 'kuesioner', 'prodiList', 'tahunList', 'aspekList', 'pertanyaans', 'chartData'));
    }

    /**
     * Menangani Menu Capaian
     */
    public function showCapaian($slug) {
        $allProfil = Profil::all();
        
        // Coba cari di tabel Capaian (dengan penanganan jika tabel tidak ada)
        $capaian = null;
        try {
            if (Schema::hasTable('capaians') || Schema::hasTable('capaian')) {
                $capaian = \App\Models\Capaian::where('slug', $slug)->first();
            }
        } catch (\Exception $e) {
            // Tabel capaians tidak ada, lanjut ke fallback
        }
        // Jika tidak ditemukan berdasarkan slug, beberapa kasus seperti "renop"
        // seharusnya merujuk ke kategori 'Renop' (listing). Untuk kompatibilitas
        // dengan data admin yang mungkin menyimpan banyak entri Renop dengan
        // slug tersendiri, coba fallback ke entri pertama dengan kategori 'Renop'.
        if (!$capaian) {
            try {
                if (strtolower($slug) === 'renop' && (Schema::hasTable('capaians') || Schema::hasTable('capaian'))) {
                    $capaian = \App\Models\Capaian::where('kategori', 'Renop')->orderBy('id','asc')->first();
                }
            } catch (\Exception $e) {
                // ignore
            }
        }

        if ($capaian) {
            $profil = (object)[
                'judul' => $capaian->judul,
                'created_at' => $capaian->created_at,
                'hits' => $capaian->hits ?? 0,
                'isi_konten' => $capaian->deskripsi ?? '<p>Konten capaian ini belum memiliki deskripsi rinci.</p>',
                'link_file' => $capaian->link_file ?? null,
            ];
        } else {
            // Fallback jika belum ada di database
            $judul = str_replace('-', ' ', ucwords($slug));
            $profil = (object)[
                'judul' => $judul,
                'created_at' => now(),
                'hits' => 0,
                'isi_konten' => '<p>Content sedang diproses, silahkan kunjungi beberapa saat lagi...</p>',
                'link_file' => null,
            ];
        }
        
        return view('pages.profil.show', compact('profil', 'allProfil'));
    }

    /**
     * Listing khusus untuk Renop (category = 'Renop')
     */
    public function renopIndex()
    {
        $allProfil = Profil::all();
        $items = [];
        try {
            if (Schema::hasTable('capaians')) {
                $items = \App\Models\Capaian::where('kategori', 'Renop')->orderBy('id','asc')->get();
            }
        } catch (\Exception $e) {
            $items = collect();
        }

        return view('pages.capaian.renop', compact('allProfil', 'items'));
    }

    /**
     * Download or redirect to the actual link for a Capaian entry
     */
    public function downloadCapaian($id)
    {
        try {
            $c = \App\Models\Capaian::findOrFail($id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        $link = $c->link_file ?? null;
        if (!$link) return redirect()->back();

        // If storage local path (no http scheme) -> stream download
        if (!\Illuminate\Support\Str::startsWith($link, ['http://', 'https://'])) {
            $path = ltrim($link, '/');
            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->download($path);
            }
            return redirect()->away(asset('storage/' . $path));
        }

        // Handle Google Drive links by converting to direct download when possible
        if (preg_match('#drive\.google\.com/file/d/([a-zA-Z0-9_-]+)#', $link, $m)) {
            $fileId = $m[1];
            $dl = "https://drive.google.com/uc?export=download&id={$fileId}";
            return redirect()->away($dl);
        }

        // Fallback: just redirect to external URL
        return redirect()->away($link);
    }

    /**
     * Halaman publik Dokumen SPMI
     */
    public function dokumenSpmiPublic(\Illuminate\Http\Request $request)
    {
        $allProfil = Profil::all();

        $query = \App\Models\DokumenSpmi::query();

        // Filter per tahun
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        // Filter per kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $dokumen = $query->orderBy('tahun', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->get();

        // Ambil daftar tahun untuk filter
        $tahunList = \App\Models\DokumenSpmi::select('tahun')
                        ->distinct()
                        ->orderBy('tahun', 'desc')
                        ->pluck('tahun');

        // Ambil daftar kategori untuk filter
        $kategoriList = \App\Models\DokumenSpmi::select('kategori')
                        ->distinct()
                        ->orderBy('kategori')
                        ->pluck('kategori');

        return view('pages.spmi.dokumen', compact('allProfil', 'dokumen', 'tahunList', 'kategoriList'));
    }

    /**
     * Halaman publik Laporan AMI
     */
    public function laporanAmiPublic(\Illuminate\Http\Request $request)
    {
        $allProfil = Profil::all();

        $query = \App\Models\LaporanAmi::query();

        // Filter per tahun
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        // Filter per kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $dokumen = $query->orderBy('tahun', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->get();

        // Ambil daftar tahun untuk filter
        $tahunList = \App\Models\LaporanAmi::select('tahun')
                        ->distinct()
                        ->orderBy('tahun', 'desc')
                        ->pluck('tahun');

        // Ambil daftar kategori untuk filter
        $kategoriList = \App\Models\LaporanAmi::select('kategori')
                        ->distinct()
                        ->orderBy('kategori')
                        ->pluck('kategori');

        return view('pages.capaian.laporan-ami', compact('allProfil', 'dokumen', 'tahunList', 'kategoriList'));
    }

    /**
     * Halaman publik RTM
     */
    public function rtmPublic(\Illuminate\Http\Request $request)
    {
        $allProfil = Profil::all();

        $query = \App\Models\Rtm::query();

        // Filter per tahun
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        // Filter per kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $dokumen = $query->orderBy('tahun', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->get();

        // Ambil daftar tahun untuk filter
        $tahunList = \App\Models\Rtm::select('tahun')
                        ->distinct()
                        ->orderBy('tahun', 'desc')
                        ->pluck('tahun');

        // Ambil daftar kategori untuk filter
        $kategoriList = \App\Models\Rtm::select('kategori')
                        ->distinct()
                        ->orderBy('kategori')
                        ->pluck('kategori');

        return view('pages.capaian.rtm', compact('allProfil', 'dokumen', 'tahunList', 'kategoriList'));
    }

    /**
     * Menangani Menu Galeri
     */
    public function galleryIndex() {
        $allProfil = Profil::all();
        $albums = \App\Models\GaleriAlbum::latest()->get();
        return view('pages.gallery.index', compact('allProfil', 'albums'));
    }

    public function galleryVideo() {
        $allProfil = Profil::all();
        $videos = \App\Models\GaleriVideo::latest()->get();
        return view('pages.gallery.video', compact('allProfil', 'videos'));
    }

    /**
     * Back-end admin methods
     */
    public function index()
    {
        $data = Profil::all();
        return view('profil', compact('data'));
    }

    public function indexAdmin()
    {
        $profils = Profil::all();
        return view('admin.profil.index', compact('profils'));
    }

    public function create()
    {
        $kategoris = [
            'Visi & Misi',
            'Tugas Pokok',
            'Sejarah',
            'Struktur Organisasi',
            'Tim Manajemen',
            'Berita',
            'Kegiatan',
            'Profil',
        ];
        return view('admin.profil.create', compact('kategoris'));
    }

    public function edit($id)
    {
        $profil = Profil::findOrFail($id);
        $kategoris = [
            'Visi & Misi',
            'Tugas Pokok',
            'Sejarah',
            'Struktur Organisasi',
            'Tim Manajemen',
            'Berita',
            'Kegiatan',
            'Profil',
        ];
        return view('admin.profil.edit', compact('profil', 'kategoris'));
    }

    public function saveData(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'isi_konten' => 'required|string',
            'slug' => 'nullable|string|unique:profil,slug',
            'penulis' => 'nullable|string|max:100',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['judul']);
        }

        $validated['isi_konten'] = HtmlSanitizer::sanitize($validated['isi_konten']);

        Profil::create($validated);

        return redirect()->route('admin.profil.index')->with('success', 'Data profil berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $profil = Profil::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'isi_konten' => 'required|string',
            'slug' => 'nullable|string|unique:profil,slug,' . $id,
            'penulis' => 'nullable|string|max:100',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['judul']);
        }

        $validated['isi_konten'] = HtmlSanitizer::sanitize($validated['isi_konten']);
        $profil->update($validated);

        return redirect()->route('admin.profil.index')->with('success', 'Data profil berhasil diupdate!');
    }

    public function destroy($id)
    {
        $profil = Profil::findOrFail($id);
        $profil->delete();

        return redirect()->route('admin.profil.index')->with('success', 'Data profil berhasil dihapus!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'isi_konten' => 'required|string',
        ]);

        $validated['isi_konten'] = HtmlSanitizer::sanitize($validated['isi_konten']);

        Profil::create($validated);

        return response()->json(['message' => 'Data berhasil disimpan'], 201);
    }
}
