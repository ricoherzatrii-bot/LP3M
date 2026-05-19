<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
     * Menangani Halaman Artikel - Daftar Kategori
     */
    public function artikelIndex()
    {
        $allProfil = Profil::all();
        
        $kategoris = [
            ['nama' => 'Berita', 'slug' => 'berita', 'count' => 6],
            ['nama' => 'Kegiatan', 'slug' => 'kegiatan', 'count' => 4],
            ['nama' => 'Profil', 'slug' => 'profil', 'count' => 27],
        ];
        
        return view('pages.artikel.index', compact('allProfil', 'kategoris'));
    }

    /**
     * Menangani Halaman Artikel - Per Kategori
     */
    public function artikelKategori($kategori)
    {
        $allProfil = Profil::all();
        
        // Data artikel demo per kategori
        $artikelData = [
            'berita' => [
                'title' => 'Berita',
                'items' => [
                    ['judul' => 'PPM STIKES Baiturrahim Jambi melakukan Kegiatan Studi Banding ke LP3M Politeknik Jambi', 'tanggal' => '07 February 2023', 'hits' => 2453, 'deskripsi' => 'Pada Hari Selasa (14/12/2021) Pusat Penjaminan Mutu (PJM) STIKes Baiturrahim Jambi melakukan Kegiatan Studi Banding ke Lembaga Perencanaan Pengembangan dan Penjaminan Mutu Politeknik Jambi (LP3M POLJAM).'],
                    ['judul' => 'Diskusi tentang SPMI Poljam dan STKIP Al Azhar Jambi', 'tanggal' => '07 February 2023', 'hits' => 1573, 'deskripsi' => 'STKIP Al Azhar Jambi melakukan Kegiatan Studi Banding ke Lembaga Perencanaan Pengembangan dan Penjaminan Mutu Politeknik Jambi.'],
                    ['judul' => 'Lokakarya Audit Mutu Internal Politeknik Jambi', 'tanggal' => '07 February 2023', 'hits' => 1038, 'deskripsi' => 'Pada Jumat 13 Maret 2020 dan Sabtu 14 Maret 2020, Lembaga Penjaminan Mutu Politeknik Jambi mengadakan Lokakarya Audit Mutu Internal yang bertempat di Ruang Seminar.'],
                    ['judul' => 'Rapat Koordinasi Pemilihan Ketua AMI 2019-2020 Genap', 'tanggal' => '03 February 2023', 'hits' => 1062, 'deskripsi' => 'Pada hari Kamis 16 Juli 2020 telah diadakan rapat koordinasi pemilihan ketua audit mutu internal periode 2019-2020 genap.'],
                ],
            ],
            'kegiatan' => [
                'title' => 'Kegiatan',
                'items' => [
                    ['judul' => 'Kegiatan Audit Mutu Internal Wakil Direktur I', 'tanggal' => '03 February 2023', 'hits' => 815, 'deskripsi' => 'Salah satu agenda Lembaga Penjaminan Mutu Politeknik Jambi pada bulan Juli dan Agustus 2020 ini adalah kegiatan Audit Mutu Internal.'],
                    ['judul' => 'Kegiatan AMI Prodi Teknik Mesin', 'tanggal' => '03 February 2023', 'hits' => 642, 'deskripsi' => 'Pelaksanaan Audit Mutu Internal di Program Studi Teknik Mesin Politeknik Jambi.'],
                    ['judul' => 'Workshop Penyusunan Standar Mutu Baru', 'tanggal' => '01 February 2023', 'hits' => 534, 'deskripsi' => 'Pelatihan intensif penyusunan dokumen standar mutu untuk seluruh unit kerja di Politeknik Jambi.'],
                ],
            ],
            'profil' => [
                'title' => 'Profil',
                'items' => [
                    ['judul' => 'Visi dan Misi LPM Politeknik Jambi', 'tanggal' => '01 January 2023', 'hits' => 3245, 'deskripsi' => 'Visi dan Misi Lembaga Penjaminan Mutu Politeknik Jambi dalam menjaga standar kualitas pendidikan tinggi.'],
                    ['judul' => 'Struktur Organisasi LPM', 'tanggal' => '01 January 2023', 'hits' => 2876, 'deskripsi' => 'Susunan organisasi Lembaga Penjaminan Mutu Politeknik Jambi beserta tugas dan fungsi masing-masing.'],
                    ['judul' => 'Tugas Pokok dan Fungsi', 'tanggal' => '01 January 2023', 'hits' => 1954, 'deskripsi' => 'Tugas pokok dan fungsi Lembaga Penjaminan Mutu dalam sistem penjaminan mutu internal Politeknik Jambi.'],
                ],
            ],
        ];

        $data = $artikelData[$kategori] ?? ['title' => ucfirst($kategori), 'items' => []];
        
        return view('pages.artikel.kategori', compact('allProfil', 'data', 'kategori'));
    }

    /**
     * Menangani Menu Profil Dinamis (Visi Misi, Job Desk, Artikel, dll)
     */
    public function show($slug)
    {
        // 1. Ambil SEMUA data profil untuk dropdown di Navbar (agar menu tetap ada 10)
        $allProfil = Profil::all(); 

        // 2. Cari data spesifik berdasarkan slug untuk isi konten
        $profil = Profil::where('slug', $slug)->first();

        // Cek jika data tidak ada
        if (!$profil) {
            return "Data dengan slug ($slug) tidak ditemukan di database.";
        }

        // 3. Kirim variabel 'allProfil' ke view
        return view('pages.profil.show', compact('profil', 'allProfil'));
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
            // Jika tidak ada, cari di tabel Spmi
            $spmi = \App\Models\Spmi::where('slug', $slug)->first();
            
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
        $allProfil = Profil::all(); // Tambahkan ini jika navbar butuh data profil
        return view('pages.akreditasi.index', compact('allProfil'));
    }

    public function akreditasiDokumen() {
        $allProfil = Profil::all();
        return view('pages.akreditasi.dokumen', compact('allProfil'));
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
        
        $tahunList = \App\Models\Kuesioner::where('kategori', 'Dosen & Karyawan')
                                        ->select('tahun_akademik')
                                        ->whereNotNull('tahun_akademik')
                                        ->distinct()
                                        ->orderBy('tahun_akademik', 'desc')
                                        ->pluck('tahun_akademik');

        return view('pages.kuesioner.dosen', compact('allProfil', 'kuesioner', 'tahunList'));
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
        
        $prodiList = \App\Models\Kuesioner::where('kategori', 'Mahasiswa')
                                        ->select('prodi')
                                        ->whereNotNull('prodi')
                                        ->distinct()
                                        ->orderBy('prodi', 'asc')
                                        ->pluck('prodi');
                                        
        $tahunList = \App\Models\Kuesioner::where('kategori', 'Mahasiswa')
                                        ->select('tahun_akademik')
                                        ->whereNotNull('tahun_akademik')
                                        ->distinct()
                                        ->orderBy('tahun_akademik', 'desc')
                                        ->pluck('tahun_akademik');
                                        
        return view('pages.kuesioner.mahasiswa', compact('allProfil', 'kuesioner', 'prodiList', 'tahunList'));
    }

    /**
     * Menangani Menu Capaian
     */
    public function showCapaian($slug) {
        $allProfil = Profil::all();
        
        // Coba cari di tabel Capaian
        $capaian = \App\Models\Capaian::where('slug', $slug)->first();
        
        if ($capaian) {
            $profil = (object)[
                'judul' => $capaian->judul,
                'created_at' => $capaian->created_at,
                'hits' => $capaian->hits ?? 0,
                'isi_konten' => $capaian->deskripsi ?? '<p>Konten capaian ini belum memiliki deskripsi rinci.</p>',
            ];
        } else {
            // Fallback jika belum ada di database
            $judul = str_replace('-', ' ', ucwords($slug));
            $profil = (object)[
                'judul' => $judul,
                'created_at' => now(),
                'hits' => 0,
                'isi_konten' => '<p>Content sedang diproses, silahkan kunjungi beberapa saat lagi...</p>',
            ];
        }
        
        return view('pages.profil.show', compact('profil', 'allProfil'));
    }

    /**
     * Menangani Menu Galeri
     */
    public function galleryIndex() {
        $allProfil = Profil::all();
        return view('pages.gallery.index', compact('allProfil'));
    }

    public function galleryVideo() {
        $allProfil = Profil::all();
        return view('pages.gallery.video', compact('allProfil'));
=======
use Illuminate\Http\Request;
use App\Models\Profil;

class ProfilController extends Controller
{
    public function index()
    {
        $data = Profil::all();
        return view('profil', compact('data'));
    }

    public function store(Request $request)
    {
        Profil::create([
            'judul' => $request->judul,
            'isi' => $request->isi
        ]);

        return redirect('/profil');
>>>>>>> f4da9032c9988bdd8d4d0196b006066481a9cda5
    }
}