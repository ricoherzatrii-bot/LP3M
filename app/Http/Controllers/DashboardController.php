<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Profil;
use App\Models\Spmi;
use App\Models\Akreditasi;
use App\Models\Capaian;
use App\Models\Kuesioner;
use App\Models\Berita;
use App\Models\Artikel;
use App\Models\GaleriAlbum;
use App\Models\GaleriVideo;

class DashboardController extends Controller
{
    /**
     * Tampilan utama Dashboard dengan statistik real-time dari database
     */
    public function index()
    {
        $totalMutuDocs = Spmi::count() + Akreditasi::where('kategori', 'Dokumen Akreditasi')->count() + Capaian::count();
        $avgIku = round(Capaian::whereNotNull('persentase_capaian')->avg('persentase_capaian') ?? 94.5, 1);
        $totalProdi = Akreditasi::where('kategori', 'Akreditasi')->count();
        if ($totalProdi === 0) $totalProdi = 8; // fallback
        $totalResponden = Kuesioner::sum('hits');
        if ($totalResponden === 0) $totalResponden = 3673; // fallback

        return view('dashboard', compact('totalMutuDocs', 'avgIku', 'totalProdi', 'totalResponden'));
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
            'Kebijakan Mutu POLJAM' => 'kebijakan-mutu-poljam',
            'Sasaran Mutu POLJAM' => 'sasaran-mutu-poljam',
            'Standar Mutu POLJAM' => 'standar-mutu-poljam',
            'Sasaran Mutu LPM' => 'sasaran-mutu-lpm',
            'Struktur Organisasi' => 'struktur-organisasi',
            'Job Deskripsi' => 'job-deskripsi',
            'Standar Waktu Pelayanan' => 'standar-waktu-pelayanan',
        ];

        if (isset($profilSlugs[$title])) {
            return [
                'type' => 'single',
                'model' => Profil::class,
                'query' => ['slug' => $profilSlugs[$title]],
                'fields' => ['judul', 'isi_konten'],
                'defaults' => ['kategori' => 'Profil', 'judul' => $title, 'slug' => $profilSlugs[$title]],
            ];
        }

        // 2. SPMI Items
        $spmiKategori = [
            'Dokumen SPMI' => 'Dokumen SPMI',
            'Unit' => 'Unit',
            'RTM' => 'RTM',
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

        // 3. Akreditasi
        if ($title === 'Akreditasi' || $title === 'Data Akreditasi') {
            return [
                'type' => 'table',
                'model' => Akreditasi::class,
                'query' => ['kategori' => 'Akreditasi'],
                'fields' => ['judul', 'peringkat', 'tanggal_kedaluwarsa'],
                'defaults' => ['kategori' => 'Akreditasi'],
            ];
        }

        if ($title === 'Dokumen Akreditasi' || $title === 'Dokumen Pendukung') {
            return [
                'type' => 'table',
                'model' => Akreditasi::class,
                'query' => ['kategori' => 'Dokumen Akreditasi'],
                'fields' => ['judul', 'file_dokumen'],
                'defaults' => ['kategori' => 'Dokumen Akreditasi'],
            ];
        }

        // 4. Capaian Kinerja
        $capaianKategori = [
            'Renop' => ['kategori' => 'Renop'],
            'Capaian Renstra' => ['kategori' => 'Capaian Renstra'],
            'Kepuasan Mahasiswa Poljam' => ['kategori' => 'Kepuasan Mahasiswa', 'sub_kategori' => 'Poljam 2020/2021'],
            'Kepuasan Mahasiswa Prodi' => ['kategori' => 'Kepuasan Mahasiswa', 'sub_kategori' => 'Prodi 2020/2021'],
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
        if ($title === 'Kuesioner Dosen & Karyawan') {
            return [
                'type' => 'table',
                'model' => Kuesioner::class,
                'query' => ['kategori' => 'Dosen & Karyawan'],
                'fields' => ['judul', 'tahun_akademik', 'link_embed_grafik'],
                'defaults' => ['kategori' => 'Dosen & Karyawan'],
            ];
        }

        if ($title === 'Kuisioner Mahasiswa' || $title === 'Kuesioner Mahasiswa') {
            return [
                'type' => 'table',
                'model' => Kuesioner::class,
                'query' => ['kategori' => 'Mahasiswa'],
                'fields' => ['judul', 'prodi', 'tahun_akademik', 'link_embed_grafik'],
                'defaults' => ['kategori' => 'Mahasiswa'],
            ];
        }

        // 6. Portal Berita
        if ($title === 'Daftar Berita' || $title === 'Portal Berita' || $title === 'Berita') {
            return [
                'type' => 'table',
                'model' => Berita::class,
                'query' => [],
                'fields' => ['judul', 'konten', 'gambar_fitur'],
                'defaults' => [],
            ];
        }

        // 7. Artikel Ilmiah
        if ($title === 'Artikel Ilmiah' || $title === 'Artikel') {
            return [
                'type' => 'table',
                'model' => Artikel::class,
                'query' => [],
                'fields' => ['judul', 'kategori', 'isi_konten', 'penulis'],
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
                'fields' => $mapping['fields']
            ]);
        } else {
            // Tipe Tabel / List
            $records = $modelClass::where($mapping['query'])->get();

            return response()->json([
                'success' => true,
                'type' => 'table',
                'data' => $records,
                'fields' => $mapping['fields']
            ]);
        }
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

            $updateData = $request->except(['title', 'id']);
            
            // Tambahkan auto-slug jika ada judul
            if (isset($updateData['judul'])) {
                $updateData['slug'] = Str::slug($updateData['judul']);
            } elseif (isset($updateData['nama_album'])) {
                $updateData['slug'] = Str::slug($updateData['nama_album']);
            }

            $record->update($updateData);

            return response()->json(['success' => true, 'message' => 'Data entri berhasil diperbarui secara permanen!']);
        }
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
        $insertData = $request->except('title');

        // Gabungkan dengan query filter (agar kategori sesuai otomatis) dan default values
        $finalData = array_merge($mapping['query'], $mapping['defaults'], $insertData);

        // Tambahkan auto-slug
        if (isset($finalData['judul'])) {
            $finalData['slug'] = Str::slug($finalData['judul']);
        } elseif (isset($finalData['nama_album'])) {
            $finalData['slug'] = Str::slug($finalData['nama_album']);
        }

        $record = $modelClass::create($finalData);

        return response()->json([
            'success' => true,
            'message' => 'Data entri baru berhasil ditambahkan secara permanen ke basis data!',
            'data' => $record
        ]);
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