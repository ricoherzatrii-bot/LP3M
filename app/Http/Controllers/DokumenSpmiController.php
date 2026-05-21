<?php

namespace App\Http\Controllers;

use App\Models\DokumenSpmi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumenSpmiController extends Controller
{
    /**
     * Upload dokumen baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'tahun'      => 'required|integer|min:2000|max:2099',
            'deskripsi'  => 'nullable|string',
            'kategori'   => 'nullable|string',
            'file'       => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:20480',
        ]);

        $file       = $request->file('file');
        $namaAsli   = $file->getClientOriginalName();
        $ekstensi   = strtolower($file->getClientOriginalExtension());
        $namaFile   = Str::slug($request->judul) . '-' . $request->tahun . '-' . time() . '.' . $ekstensi;
        $path       = $file->storeAs('dokumen_spmi', $namaFile, 'public');
        $ukuran     = $this->formatBytes($file->getSize());

        $dokumen = DokumenSpmi::create([
            'judul'      => $request->judul,
            'tahun'      => $request->tahun,
            'deskripsi'  => $request->deskripsi,
            'nama_file'  => $namaAsli,
            'path_file'  => $path,
            'ukuran_file'=> $ukuran,
            'tipe_file'  => $ekstensi,
            'kategori'   => $request->kategori ?? 'Dokumen SPMI',
            'slug'       => Str::slug($request->judul),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen "' . $request->judul . '" berhasil diupload!',
            'data'    => [
                'id'          => $dokumen->id,
                'judul'       => $dokumen->judul,
                'tahun'       => $dokumen->tahun,
                'deskripsi'   => $dokumen->deskripsi,
                'nama_file'   => $dokumen->nama_file,
                'ukuran_file' => $dokumen->ukuran_file,
                'tipe_file'   => $dokumen->tipe_file,
                'kategori'    => $dokumen->kategori,
                'file_url'    => $dokumen->file_url,
                'icon_class'  => $dokumen->icon_class,
                'created_at'  => $dokumen->created_at->format('d M Y'),
            ],
        ]);
    }

    /**
     * Update data dokumen (dengan atau tanpa upload file baru)
     */
    public function update(Request $request, $id)
    {
        $dokumen = DokumenSpmi::findOrFail($id);

        $request->validate([
            'judul'     => 'required|string|max:255',
            'tahun'     => 'required|integer|min:2000|max:2099',
            'deskripsi' => 'nullable|string',
            'kategori'  => 'nullable|string',
            'file'      => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:20480',
        ]);

        $updateData = [
            'judul'    => $request->judul,
            'tahun'    => $request->tahun,
            'deskripsi'=> $request->deskripsi,
            'kategori' => $request->kategori ?? $dokumen->kategori,
            'slug'     => Str::slug($request->judul),
        ];

        // Jika ada file baru diupload
        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($dokumen->path_file && Storage::disk('public')->exists($dokumen->path_file)) {
                Storage::disk('public')->delete($dokumen->path_file);
            }

            $file      = $request->file('file');
            $namaAsli  = $file->getClientOriginalName();
            $ekstensi  = strtolower($file->getClientOriginalExtension());
            $namaFile  = Str::slug($request->judul) . '-' . $request->tahun . '-' . time() . '.' . $ekstensi;
            $path      = $file->storeAs('dokumen_spmi', $namaFile, 'public');
            $ukuran    = $this->formatBytes($file->getSize());

            $updateData['nama_file']   = $namaAsli;
            $updateData['path_file']   = $path;
            $updateData['ukuran_file'] = $ukuran;
            $updateData['tipe_file']   = $ekstensi;
        }

        $dokumen->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diperbarui!',
            'data'    => [
                'id'          => $dokumen->id,
                'judul'       => $dokumen->judul,
                'tahun'       => $dokumen->tahun,
                'deskripsi'   => $dokumen->deskripsi,
                'nama_file'   => $dokumen->nama_file,
                'ukuran_file' => $dokumen->ukuran_file,
                'tipe_file'   => $dokumen->tipe_file,
                'kategori'    => $dokumen->kategori,
                'file_url'    => $dokumen->file_url,
                'icon_class'  => $dokumen->icon_class,
                'created_at'  => $dokumen->created_at->format('d M Y'),
            ],
        ]);
    }

    /**
     * Hapus dokumen beserta file fisik
     */
    public function destroy($id)
    {
        $dokumen = DokumenSpmi::findOrFail($id);

        // Hapus file fisik dari storage
        if ($dokumen->path_file && Storage::disk('public')->exists($dokumen->path_file)) {
            Storage::disk('public')->delete($dokumen->path_file);
        }

        $judul = $dokumen->judul;
        $dokumen->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dokumen "' . $judul . '" berhasil dihapus!',
        ]);
    }

    /**
     * Download dokumen & tambah counter
     */
    public function download($id)
    {
        $dokumen = DokumenSpmi::findOrFail($id);

        if (!$dokumen->path_file || !Storage::disk('public')->exists($dokumen->path_file)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Tambah counter download
        $dokumen->increment('downloads');

        $path = Storage::disk('public')->path($dokumen->path_file);
        return response()->download($path, $dokumen->nama_file);
    }

    /**
     * Ambil semua dokumen (untuk AJAX dashboard)
     */
    public function index(Request $request)
    {
        $query = DokumenSpmi::query();

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }

        $dokumen = $query->orderBy('tahun', 'desc')->orderBy('created_at', 'desc')->get()
            ->map(fn($d) => [
                'id'          => $d->id,
                'judul'       => $d->judul,
                'tahun'       => $d->tahun,
                'deskripsi'   => $d->deskripsi,
                'nama_file'   => $d->nama_file,
                'ukuran_file' => $d->ukuran_file,
                'tipe_file'   => $d->tipe_file,
                'kategori'    => $d->kategori,
                'file_url'    => $d->file_url,
                'icon_class'  => $d->icon_class,
                'downloads'   => $d->downloads,
                'created_at'  => $d->created_at ? $d->created_at->format('d M Y') : '-',
            ]);

        return response()->json(['success' => true, 'data' => $dokumen]);
    }

    /**
     * Format ukuran file ke format manusiawi
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow   = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
