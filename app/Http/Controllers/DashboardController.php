<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Profil;
use App\Models\Spmi;
use App\Models\Akreditasi;
use App\Models\Capaian;
use App\Models\Kuesioner;
use App\Models\Prodi;

use App\Models\Artikel;
use App\Models\GaleriAlbum;
use App\Models\GaleriVideo;
use App\Models\DokumenSpmi;
use App\Models\CapaianRenstra;
use App\Models\LaporanAmi;
use App\Models\Rtm;

class DashboardController extends Controller
{
    /**
     * Tampilan utama Dashboard dengan statistik real-time dari database
     */
    public function index()
    {
        $countDokumenSpmi = 0;
        $countLaporanAmi = 0;
        $countRtm = 0;
        $countAkreditasiDocs = 0;
        $countAkreditasi = 0;
        $avgIku = 0;
        $totalResponden = 0;

        try {
            $countDokumenSpmi = DokumenSpmi::count();
        } catch (\Exception $e) {}

        try {
            $countLaporanAmi = LaporanAmi::count();
        } catch (\Exception $e) {}

        try {
            $countRtm = Rtm::count();
        } catch (\Exception $e) {}

        try {
            $countAkreditasiDocs = Akreditasi::where('kategori', 'Dokumen Akreditasi')->count();
            $countAkreditasi = Akreditasi::where('kategori', 'Akreditasi')->count();
        } catch (\Exception $e) {}

        $totalMutuDocs = $countDokumenSpmi + $countLaporanAmi + $countRtm + $countAkreditasiDocs;

        try {
            if (Schema::hasTable((new CapaianRenstra)->getTable())) {
                $avgIku = round(CapaianRenstra::whereNotNull('realisasi')->avg('realisasi') ?? 0, 1);
            } elseif (Schema::hasTable((new Capaian)->getTable())) {
                $avgIku = round(Capaian::whereNotNull('persentase_capaian')->avg('persentase_capaian') ?? 0, 1);
            }
        } catch (\Exception $e) {
            $avgIku = 0;
        }

        try {
            $totalResponden = Kuesioner::sum('hits');
        } catch (\Exception $e) {
            $totalResponden = 0;
        }

        try {
            // Merge prodi names from all sources: prodis table + akreditasi table
            $prodiNames = collect();

            if (\Illuminate\Support\Facades\Schema::hasTable((new Prodi)->getTable())) {
                $prodiNames = $prodiNames->merge(Prodi::pluck('nama'));
            }

            $akreditasiProdi = Akreditasi::where('kategori', 'Akreditasi')->pluck('judul');
            $prodiNames = $prodiNames->merge($akreditasiProdi);

            $totalProdi = $prodiNames->map(function ($prodi) { return trim($prodi); })
                ->filter(function ($prodi) { return !empty($prodi); })
                ->unique(function ($prodi) { return strtolower(trim($prodi)); })
                ->count();
        } catch (\Exception $e) {
            $totalProdi = 0;
        }

        $akreditasiUnggul = 0;
        $akreditasiBaik = 0;
        $akreditasiCukup = 0;
        $akreditasiData = collect();
        try {
            $akreditasiQuery = Akreditasi::query();
            if (Schema::hasColumn((new Akreditasi)->getTable(), 'kategori')) {
                $akreditasiQuery->where('kategori', 'Akreditasi');
            }
            $akreditasiData = $akreditasiQuery->get();

            $akreditasiUnggul = $akreditasiData->filter(function ($item) {
                $peringkat = strtolower($item->peringkat ?? '');
                return $peringkat && (str_contains($peringkat, 'unggul') || str_contains($peringkat, 'baik sekali') || $peringkat === 'a');
            })->count();

            $akreditasiBaik = $akreditasiData->filter(function ($item) {
                $peringkat = strtolower($item->peringkat ?? '');
                return $peringkat && (str_contains($peringkat, 'baik') && !str_contains($peringkat, 'sekali')) || $peringkat === 'b';
            })->count();

            $akreditasiCukup = $akreditasiData->filter(function ($item) {
                return $item->peringkat && str_contains(strtolower($item->peringkat), 'cukup');
            })->count();

            if ($akreditasiCukup === 0) {
                $totalAkreditasiStatus = $akreditasiUnggul + $akreditasiBaik + $akreditasiCukup;
                $remaining = max(0, $akreditasiData->count() - $totalAkreditasiStatus);
                if ($remaining > 0) {
                    $akreditasiCukup = $remaining;
                }
            }
        } catch (\Exception $e) {
            $akreditasiUnggul = 0;
            $akreditasiBaik = 0;
            $akreditasiCukup = 0;
        }

        $availableYearsForChart = collect();
        $allProgramStats = collect();
        try {
            $availableYearsForChart = CapaianRenstra::select('tahun')
                ->distinct()
                ->orderBy('tahun', 'asc')
                ->pluck('tahun');

            $allProgramStats = CapaianRenstra::selectRaw('program, tahun, ROUND(AVG(realisasi),2) as avg_realisasi')
                ->groupBy('program', 'tahun')
                ->orderBy('program')
                ->orderBy('tahun')
                ->get()
                ->groupBy('program');
        } catch (\Exception $e) {
            $availableYearsForChart = collect();
            $allProgramStats = collect();
        }

        $kuesionerDosenData = [];
        $kuesionerMahasiswaData = ['labels' => [], 'ss' => [], 's' => [], 'ts' => [], 'sts' => []];
        try {
            $dosenStats = \App\Models\KuesionerDosenKaryawan::where('kategori', 'Dosen & Karyawan')
                ->selectRaw('SUM(sangat_setuju) as ss, SUM(setuju) as s, SUM(cukup_setuju) as cs, SUM(tidak_setuju) as ts, SUM(sangat_tidak_setuju) as sts')
                ->first();
                
            $kuesionerDosenData = [(int)($dosenStats->ss ?? 0), (int)($dosenStats->s ?? 0), (int)($dosenStats->cs ?? 0), (int)($dosenStats->ts ?? 0), (int)($dosenStats->sts ?? 0)];
            $mhsStats = \App\Models\KuesionerDosenKaryawan::where('kategori', 'Mahasiswa')
                ->selectRaw('AVG(sangat_setuju) as ss, AVG(setuju) as s, AVG(cukup_setuju) as cs, AVG(tidak_setuju) as ts, AVG(sangat_tidak_setuju) as sts')
                ->first();

            $kuesionerMahasiswaData = [
                round((float)($mhsStats->ss ?? 0), 1),
                round((float)($mhsStats->s ?? 0), 1),
                round((float)($mhsStats->cs ?? 0), 1),
                round((float)($mhsStats->ts ?? 0), 1),
                round((float)($mhsStats->sts ?? 0), 1)
            ];
        } catch (\Exception $e) {
            $kuesionerDosenData = [0, 0, 0, 0, 0];
            $kuesionerMahasiswaData = [0, 0, 0, 0, 0];
        }

        $recentDocuments = collect();
        try {
            $recentDocuments = $recentDocuments->concat(DokumenSpmi::latest('created_at')->take(4)->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'tahun' => $item->tahun,
                    'kategori' => $item->kategori,
                    'type' => 'Dokumen SPMI',
                    'created_at' => $item->created_at,
                    'link' => $item->path_file ? Storage::url($item->path_file) : null,
                ];
            }));
        } catch (\Exception $e) {}

        try {
            $recentDocuments = $recentDocuments->concat(LaporanAmi::latest('created_at')->take(4)->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'tahun' => $item->tahun,
                    'kategori' => $item->kategori,
                    'type' => 'Laporan AMI',
                    'created_at' => $item->created_at,
                    'link' => $item->path_file ? Storage::url($item->path_file) : null,
                ];
            }));
        } catch (\Exception $e) {}

        try {
            $recentDocuments = $recentDocuments->concat(Rtm::latest('created_at')->take(4)->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'tahun' => $item->tahun,
                    'kategori' => $item->kategori,
                    'type' => 'RTM',
                    'created_at' => $item->created_at,
                    'link' => $item->path_file ? Storage::url($item->path_file) : null,
                ];
            }));
        } catch (\Exception $e) {}

        try {
            $recentDocuments = $recentDocuments->concat(Akreditasi::where('kategori', 'Dokumen Akreditasi')->latest('created_at')->take(4)->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'tahun' => null,
                    'kategori' => $item->kategori,
                    'type' => 'Dokumen Akreditasi',
                    'created_at' => $item->created_at,
                    'link' => null,
                ];
            }));
        } catch (\Exception $e) {}

        $recentDocuments = $recentDocuments
            ->sortByDesc('created_at')
            ->values()
            ->take(6);

        $recentActivities = $recentDocuments->map(function ($item) {
            return [
                'id' => $item['id'],
                'title' => "Unggah {$item['type']} - {$item['judul']}",
                'subtitle' => $item['kategori'] ?? $item['type'],
                'status' => 'Terverifikasi',
                'badgeColor' => 'emerald',
                'time' => optional($item['created_at'])->diffForHumans() ?? 'Beberapa saat lalu',
            ];
        });

        $months = collect(range(1, 12));
        $monthlyUploadCounts = $months->map(function ($month) {
            $year = Carbon::now()->year;
            $count = 0;

            try {
                $count += DokumenSpmi::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            } catch (\Exception $e) {}
            try {
                $count += LaporanAmi::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            } catch (\Exception $e) {}
            try {
                $count += Rtm::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            } catch (\Exception $e) {}
            try {
                $count += Akreditasi::where('kategori', 'Dokumen Akreditasi')->whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            } catch (\Exception $e) {}

            return $count;
        })->toArray();

        $chartLabels = $months->map(function ($month) {
            return Carbon::createFromDate(null, $month, 1)->translatedFormat('M');
        })->toArray();

        return view('dashboard', compact(
            'totalMutuDocs',
            'avgIku',
            'countAkreditasi',
            'countAkreditasiDocs',
            'totalResponden',
            'totalProdi',
            'akreditasiUnggul',
            'akreditasiBaik',
            'akreditasiCukup',
            'availableYearsForChart',
            'allProgramStats',
            'kuesionerDosenData',
            'kuesionerMahasiswaData',
            'recentDocuments',
            'recentActivities',
            'chartLabels',
            'monthlyUploadCounts'
        ));
    }

    /**
     * Mendapatkan pemetaan model dan kueri berdasarkan nama menu/title
     */
    private function getPageMapping($title)
    {
        // 1. Profil Kampus
        $profilSlugs = [
            'Visi Dan Misi' => 'visi-dan-misi',
            'Moto Dan Janji Layanan' => 'moto-dan-janji-layanan',
            'Struktur Organisasi' => 'struktur-organisasi',
            'Job Deskripsi' => 'job-deskripsi',
            'Standar Waktu Pelayanan' => 'standar-waktu-pelayanan',
        ];

        if (isset($profilSlugs[$title])) {
            return [
                'type' => 'table',
                'model' => Profil::class,
                'query' => ['kategori' => $title],
                'fields' => ['judul', 'isi_konten'],
                'defaults' => ['kategori' => $title, 'judul' => $title],
            ];
        }

        // 2. SPMI Items
        $spmiKategori = [
            'Unit' => 'Unit',
            'Dokumen Mutu SPMI' => 'Dokumen Mutu SPMI',
            'e-spmiPoljam' => 'e-spmiPoljam',
        ];

        if (isset($spmiKategori[$title])) {
            return [
                'type' => 'table',
                'model' => Spmi::class,
                'query' => ['kategori' => $spmiKategori[$title]],
                'fields' => ['judul', 'deskripsi', 'nama_file', 'link_eksternal'],
                'defaults' => ['kategori' => $spmiKategori[$title]],
            ];
        }

        if ($title === 'Dokumen SPMI') {
            return [
                'type' => 'table',
                'model' => DokumenSpmi::class,
                'query' => [],
                'fields' => ['judul', 'kategori', 'tahun', 'path_file'],
                'defaults' => [],
            ];
        }

        if ($title === 'Laporan AMI') {
            return [
                'type' => 'table',
                'model' => LaporanAmi::class,
                'query' => [],
                'fields' => ['judul', 'kategori', 'tahun', 'path_file'],
                'defaults' => [],
            ];
        }

        if ($title === 'RTM') {
            return [
                'type' => 'table',
                'model' => Rtm::class,
                'query' => [],
                'fields' => ['judul', 'kategori', 'tahun', 'path_file'],
                'defaults' => [],
            ];
        }

        // 3. Akreditasi
        if ($title === 'Akreditasi' || $title === 'Data Akreditasi') {
            return [
                'type' => 'table',
                'model' => Akreditasi::class,
                'query' => ['kategori' => 'Akreditasi'],
                'fields' => ['judul', 'peringkat', 'tanggal_kedaluwarsa'],
                'defaults' => ['kategori' => 'Akreditasi', 'judul' => 'Data Akreditasi'],
            ];
        }

        if ($title === 'Dokumen Akreditasi' || $title === 'Dokumen Pendukung') {
            return [
                'type' => 'table',
                'model' => Akreditasi::class,
                'query' => ['kategori' => 'Dokumen Akreditasi'],
                'fields' => ['judul', 'file_dokumen', 'foto_logo'],
                'defaults' => ['kategori' => 'Dokumen Akreditasi', 'judul' => 'Dokumen Akreditasi Baru'],
            ];
        }

        // 4. Capaian Kinerja
        if ($title === 'Renop') {
            return [
                'type' => 'table',
                'model' => Capaian::class,
                'query' => ['kategori' => 'Renop'],
                'fields' => ['judul', 'deskripsi', 'link_file'],
                'defaults' => ['kategori' => 'Renop'],
            ];
        }

        $capaianKategori = [
            'Capaian Renstra' => ['kategori' => 'Capaian Renstra'],
            'Kepuasan Dosen & Tendik' => ['kategori' => 'Kepuasan Dosen Dan Tendik'],
        ];

        if (isset($capaianKategori[$title])) {
            return [
                'type' => 'table',
                'model' => Capaian::class,
                'query' => $capaianKategori[$title],
                'fields' => ['judul', 'deskripsi', 'persentase_capaian', 'file_dokumen'],
                'defaults' => $capaianKategori[$title],
            ];
        }

        // 5. Kuesioner
        if ($title === 'Data Statistik Kuesioner' || $title === 'Kuesioner Dosen & Karyawan' || $title === 'Kuesioner Mahasiswa') {
            $category = $title === 'Kuesioner Mahasiswa' ? 'Mahasiswa' : 'Dosen & Karyawan';
            return [
                'type' => 'table',
                'model' => \App\Models\KuesionerDosenKaryawan::class,
                'query' => ['kategori' => $category],
                'fields' => ['tahun_akademik', 'kategori', 'prodi', 'program', 'sangat_setuju', 'setuju', 'cukup_setuju', 'tidak_setuju', 'sangat_tidak_setuju'],
                'defaults' => ['kategori' => $category],
            ];
        }

        if ($title === 'Kuesioner' || $title === 'Konfigurasi Kuesioner' || $title === 'Kuesioner Mahasiswa') {
            return [
                'type' => 'table',
                'model' => Kuesioner::class,
                'query' => ($title === 'Kuesioner Mahasiswa' ? ['kategori' => 'Mahasiswa'] : []),
                'fields' => ['judul', 'kategori', 'tahun_akademik', 'link_google_form', 'link_embed_grafik'],
                'defaults' => ['kategori' => 'Mahasiswa'],
            ];
        }


        // 7. Artikel Ilmiah
        if ($title === 'Artikel Ilmiah' || $title === 'Artikel') {
            return [
                'type' => 'table',
                'model' => Artikel::class,
                'query' => [],
                'fields' => ['judul', 'kategori', 'isi_konten', 'gambar_fitur', 'penulis'],
                'defaults' => ['kategori' => 'Umum', 'judul' => 'Artikel Baru'],
            ];
        }

        // 7B. Pengumuman
        if ($title === 'Pengumuman') {
            return [
                'type' => 'table',
                'model' => \App\Models\Pengumuman::class,
                'query' => [],
                'fields' => ['judul', 'isi_konten', 'gambar', 'status'],
                'defaults' => ['status' => 'aktif', 'judul' => 'Pengumuman Baru'],
            ];
        }

        // 7C. Media Sosial
        if ($title === 'Media Sosial') {
            return [
                'type' => 'table',
                'model' => \App\Models\SocialLink::class,
                'query' => [],
                'fields' => ['key', 'url'],
                'defaults' => [],
            ];
        }

        if ($title === 'Logo Poljam') {
            return [
                'type' => 'table',
                'model' => \App\Models\BrandAsset::class,
                'query' => [],
                'fields' => ['key', 'logo_file'],
                'defaults' => [],
            ];
        }

        // 7E. Program Studi
        if ($title === 'Program Studi') {
            return [
                'type' => 'table',
                'model' => Prodi::class,
                'query' => [],
                'fields' => ['kode', 'nama'],
                'defaults' => [],
            ];
        }

        // 8. Galeri Kampus
        if ($title === 'Dokumentasi Foto' || $title === 'Album Kegiatan') {
            return [
                'type' => 'table',
                'model' => GaleriAlbum::class,
                'query' => [],
                'fields' => ['nama_album', 'sampul_foto'],
                'defaults' => [],
            ];
        }

        if ($title === 'Galeri Video' || $title === 'Video Kegiatan') {
            return [
                'type' => 'table',
                'model' => GaleriVideo::class,
                'query' => [],
                'fields' => ['judul', 'link_youtube', 'deskripsi'],
                'defaults' => [],
            ];
        }

        return null;
    }

    /**
     * Membaca data halaman berdasarkan judul menu
     */
    public function getPageData(Request $request)
    {
        $title = $request->query('title');
        $mapping = $this->getPageMapping($title);

        if (!$mapping) {
            return response()->json([
                'success' => false,
                'message' => 'Modul tidak didukung atau belum terdaftar.'
            ]);
        }

        $modelClass = $mapping['model'];
        
        if ($mapping['type'] === 'single') {
            $record = $modelClass::where($mapping['query'])->first();
            
            if (!$record) {
                // Buat record baru jika belum ada di DB
                $record = $modelClass::create(array_merge($mapping['query'], $mapping['defaults'], [
                    'isi_konten' => '<p>Konten baru untuk halaman ' . $title . '. Silakan edit melalui panel ini.</p>'
                ]));
            }

            return response()->json([
                'success' => true,
                'type' => 'single',
                'data' => $record,
                'fields' => $mapping['fields'],
                'defaults' => $mapping['defaults'] ?? []
            ]);
        } else {
            // Tipe Tabel / List
            $records = $modelClass::where($mapping['query'])->get();

            if ($title === 'Media Sosial' && $records->isEmpty()) {
                $defaults = [
                    ['key' => 'instagram', 'url' => 'https://www.instagram.com/politeknikjambi?igsh=MW1scnJubzYxbXI1OA=='],
                    ['key' => 'tiktok', 'url' => 'https://www.tiktok.com/@politeknikjambi?_r=1&_t=ZS-97xqcpSv8SK'],
                    ['key' => 'youtube', 'url' => 'https://youtube.com/@poltekjambi?si=gP6jTcGudVbPtwB1'],
                    ['key' => 'email', 'url' => 'mailto:lpm@politeknikjambi.ac.id'],
                    ['key' => 'phone', 'url' => 'tel:+62741123456'],
                ];

                foreach ($defaults as $default) {
                    $modelClass::firstOrCreate(['key' => $default['key']], $default);
                }

                $records = $modelClass::where($mapping['query'])->get();
            }

            if ($title === 'Logo Poljam' && $records->isEmpty()) {
                $defaults = [
                    ['key' => 'logo_poljam', 'logo_file' => 'images/logo-poljam.png'],
                ];

                foreach ($defaults as $default) {
                    $modelClass::firstOrCreate(['key' => $default['key']], $default);
                }

                $records = $modelClass::where($mapping['query'])->get();
            }

            return response()->json([
                'success' => true,
                'type' => 'table',
                'data' => $records,
                'fields' => $mapping['fields'],
                'defaults' => $mapping['defaults'] ?? []
            ]);
        }
    }

    /**
     * Check if a field is an image field based on its name
     */
    private function isFileField($field)
    {
        $f = strtolower($field);
        return str_contains($f, 'gambar') || str_contains($f, 'foto') || str_contains($f, 'file') || str_contains($f, 'dokumen');
    }

    /**
     * Menyimpan pembaruan data (Single content editor atau Edit record)
     */
    public function savePageData(Request $request)
    {
        $title = $request->input('title');
        $mapping = $this->getPageMapping($title);

        if (!$mapping) {
            return response()->json(['success' => false, 'message' => 'Modul tidak ditemukan']);
        }

        $modelClass = $mapping['model'];

        if ($mapping['type'] === 'single') {
            $record = $modelClass::where($mapping['query'])->first();
            if (!$record) {
                $record = new $modelClass();
                foreach ($mapping['defaults'] as $col => $val) {
                    $record->$col = $val;
                }
            }
            $record->isi_konten = $request->input('isi_konten');
            $record->save();

            return response()->json(['success' => true, 'message' => 'Konten halaman ' . $title . ' berhasil diperbarui!']);
        } else {
            // Edit entri spesifik dari tabel
            $id = $request->input('id');
            $record = $modelClass::find($id);
            if (!$record) {
                return response()->json(['success' => false, 'message' => 'Record tidak ditemukan']);
            }

            // Track old name for Prodi to cascade updates
            $oldProdiName = null;
            if ($modelClass === \App\Models\Prodi::class) {
                $oldProdiName = $record->nama;
            }

            $updateData = $request->except(['title', 'id', '_token']);

            // Handle file uploads for image fields
            foreach ($updateData as $key => $value) {
                if ($this->isFileField($key)) {
                    if ($request->hasFile($key)) {
                        // Check if document or image based on key
                        $isDoc = str_contains(strtolower($key), 'dokumen')
                            || (str_contains(strtolower($key), 'file') && strtolower($key) !== 'logo_file');
                        $rules = $isDoc ? 'mimes:pdf,doc,docx,xls,xlsx,zip,rar|max:10240' : 'image|mimes:jpg,jpeg,png,webp|max:2048';
                        $request->validate([$key => $rules]);
                        
                        // Delete old file if exists
                        if ($record->$key && \Storage::disk('public')->exists($record->$key) && !str_starts_with($record->$key, 'http://') && !str_starts_with($record->$key, 'https://')) {
                            \Storage::disk('public')->delete($record->$key);
                        }
                        $updateData[$key] = $request->file($key)->store('uploads', 'public');
                    } else {
                        // If it's an image/file field but no file uploaded, check if a text input (such as a URL) was sent
                        if ($request->has($key) && !empty($value)) {
                            $updateData[$key] = $value;
                        } else {
                            unset($updateData[$key]);
                        }
                    }
                }

                // Detect date fields and format them correctly
                if (str_contains(strtolower($key), 'tanggal') || str_contains(strtolower($key), 'date')) {
                    if ($value) {
                        try {
                            $updateData[$key] = \Carbon\Carbon::parse($value)->format('Y-m-d');
                        } catch (\Exception $e) {
                            // Fallback to original value if parsing fails
                        }
                    }
                }
            }
            
            try {
                // Tambahkan auto-slug jika ada judul dan tabel memiliki kolom slug
                $hasSlugColumn = \Schema::hasColumn((new $modelClass)->getTable(), 'slug');
                if ($hasSlugColumn) {
                    if (isset($updateData['judul'])) {
                        $updateData['slug'] = Str::slug($updateData['judul']);
                    } elseif (isset($updateData['nama_album'])) {
                        $updateData['slug'] = Str::slug($updateData['nama_album']);
                    }
                }

                $record->update($updateData);

                // Cascade update if it's Prodi and the name was changed
                if ($modelClass === \App\Models\Prodi::class && $oldProdiName && isset($updateData['nama']) && $oldProdiName !== $updateData['nama']) {
                    $newProdiName = $updateData['nama'];
                    
                    if (\Illuminate\Support\Facades\Schema::hasColumn('kuesioner_dosen_karyawan', 'prodi')) {
                        \DB::table('kuesioner_dosen_karyawan')
                            ->where('prodi', $oldProdiName)
                            ->update(['prodi' => $newProdiName]);
                    }
                    if (\Illuminate\Support\Facades\Schema::hasColumn('kuesioners', 'prodi') || \Illuminate\Support\Facades\Schema::hasTable('kuesioner')) {
                        $kuesionerTable = \Illuminate\Support\Facades\Schema::hasTable('kuesioners') ? 'kuesioners' : 'kuesioner';
                        if (\Illuminate\Support\Facades\Schema::hasColumn($kuesionerTable, 'prodi')) {
                            \DB::table($kuesionerTable)
                                ->where('prodi', $oldProdiName)
                                ->update(['prodi' => $newProdiName]);
                        }
                    }
                    if (\Illuminate\Support\Facades\Schema::hasColumn('akreditasi', 'judul')) {
                        \DB::table('akreditasi')
                            ->where('kategori', 'Akreditasi')
                            ->where('judul', $oldProdiName)
                            ->update(['judul' => $newProdiName]);
                    }
                }

                return response()->json(['success' => true, 'message' => 'Data entri berhasil diperbarui secara permanen!']);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Upload gambar yang disisipkan melalui editor isi konten.
     */
    public function uploadContentImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        $path = $request->file('upload')->store('content-images', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }

    /**
     * Menambahkan baris entri baru ke tabel basis data
     */
    public function addRow(Request $request)
    {
        $title = $request->input('title');
        $mapping = $this->getPageMapping($title);

        if (!$mapping) {
            return response()->json(['success' => false, 'message' => 'Modul tidak ditemukan']);
        }

        $modelClass = $mapping['model'];
        $insertData = $request->except(['title', '_token']);

        // Handle file uploads for image fields
        foreach ($insertData as $key => $value) {
            if ($this->isFileField($key)) {
                if ($request->hasFile($key)) {
                    // Check if document or image based on key
                    $isDoc = str_contains(strtolower($key), 'dokumen')
                        || (str_contains(strtolower($key), 'file') && strtolower($key) !== 'logo_file');
                    $rules = $isDoc ? 'mimes:pdf,doc,docx,xls,xlsx,zip,rar|max:10240' : 'image|mimes:jpg,jpeg,png,webp|max:2048';
                    $request->validate([$key => $rules]);
                    $insertData[$key] = $request->file($key)->store('uploads', 'public');
                } else {
                    if ($request->has($key) && !empty($value)) {
                        $insertData[$key] = $value;
                    } else {
                        unset($insertData[$key]);
                    }
                }
            }

            // Detect date fields and format them correctly
            if (str_contains(strtolower($key), 'tanggal') || str_contains(strtolower($key), 'date')) {
                if ($value) {
                    try {
                        $insertData[$key] = \Carbon\Carbon::parse($value)->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Fallback to original value if parsing fails
                    }
                }
            }
        }

        try {
            // Gabungkan dengan query filter (agar kategori sesuai otomatis) dan default values
            $finalData = array_merge($mapping['query'], $mapping['defaults'], $insertData);

            // Tambahkan auto-slug hanya jika tabel memiliki kolom slug
            $hasSlugColumn = \Schema::hasColumn((new $modelClass)->getTable(), 'slug');
            if ($hasSlugColumn) {
                if (isset($finalData['judul'])) {
                    $finalData['slug'] = Str::slug($finalData['judul']);
                } elseif (isset($finalData['nama_album'])) {
                    $finalData['slug'] = Str::slug($finalData['nama_album']);
                } else {
                    // Fallback for missing title when generating slug
                    $finalData['slug'] = 'post-' . time() . '-' . rand(100, 999);
                }
            }

            $record = $modelClass::create($finalData);

            return response()->json([
                'success' => true,
                'message' => 'Data entri baru berhasil ditambahkan secara permanen ke basis data!',
                'data' => $record
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Menghapus baris entri dari tabel basis data secara permanen
     */
    public function deleteRow(Request $request)
    {
        $title = $request->input('title');
        $id = $request->input('id');
        $mapping = $this->getPageMapping($title);

        if (!$mapping) {
            return response()->json(['success' => false, 'message' => 'Modul tidak ditemukan']);
        }

        $modelClass = $mapping['model'];
        $record = $modelClass::find($id);

        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Record tidak ditemukan']);
        }

        $record->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data entri berhasil dihapus secara permanen dari basis data!'
        ]);
    }
}