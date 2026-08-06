<?php

namespace App\Http\Controllers;

use App\Models\GaleriAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriAlbumController extends GalleryControllerBase
{
    public function index()
    {
        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'data' => GaleriAlbum::with('firstFoto')->latest()->get(),
        ]));
    }

    public function uploadAlbum(Request $request)
    {
        $validated = $request->validate([
            'nama_album' => 'required|string|max:255',
            'sampul_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'link_extern' => 'nullable|string|max:255',
        ]);

        $namaAlbum = $this->sanitizeText($validated['nama_album'] ?? null);
        if ($namaAlbum === '') {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Nama album wajib diisi.',
            ], 422));
        }

        $linkExtern = $this->sanitizeUrl($validated['link_extern'] ?? null);
        if ($request->filled('link_extern') && !$linkExtern) {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Link sampul tidak valid.',
            ], 422));
        }

        $filename = null;
        if ($request->hasFile('sampul_foto')) {
            $file = $request->file('sampul_foto');
            $filename = time() . '_' . Str::slug($namaAlbum) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('gallery', $filename, 'public');
        } elseif ($linkExtern) {
            $filename = $linkExtern;
        }

        $album = GaleriAlbum::create([
            'nama_album' => $namaAlbum,
            'slug' => Str::slug($namaAlbum),
            'sampul_foto' => $filename,
        ]);

        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'message' => 'Album berhasil ditambahkan!',
            'data' => $album,
        ]));
    }

    public function updateAlbum(Request $request, $id)
    {
        $album = GaleriAlbum::findOrFail($id);

        $validated = $request->validate([
            'nama_album' => 'required|string|max:255',
            'sampul_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'link_extern' => 'nullable|string|max:255',
        ]);

        $namaAlbum = $this->sanitizeText($validated['nama_album'] ?? null);
        if ($namaAlbum === '') {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Nama album wajib diisi.',
            ], 422));
        }

        $linkExtern = $this->sanitizeUrl($validated['link_extern'] ?? null);
        if ($request->filled('link_extern') && !$linkExtern) {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Link sampul tidak valid.',
            ], 422));
        }

        $album->nama_album = $namaAlbum;
        $album->slug = Str::slug($namaAlbum);

        if ($request->hasFile('sampul_foto')) {
            if ($album->sampul_foto && !filter_var($album->sampul_foto, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete('gallery/' . $album->sampul_foto);
            }
            $file = $request->file('sampul_foto');
            $filename = time() . '_' . Str::slug($namaAlbum) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('gallery', $filename, 'public');
            $album->sampul_foto = $filename;
        } elseif ($linkExtern) {
            $album->sampul_foto = $linkExtern;
        }

        $album->save();

        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'message' => 'Album berhasil diperbarui!',
        ]));
    }

    public function deleteAlbum($id)
    {
        $album = GaleriAlbum::with('fotos')->findOrFail($id);

        if ($album->sampul_foto && !filter_var($album->sampul_foto, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete('gallery/' . $album->sampul_foto);
        }

        foreach ($album->fotos as $foto) {
            if ($foto->file_path && !filter_var($foto->file_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete('gallery/' . $foto->file_path);
            }
            $foto->delete();
        }

        $album->delete();

        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'message' => 'Album dan semua foto di dalamnya berhasil dihapus!',
        ]));
    }
}
