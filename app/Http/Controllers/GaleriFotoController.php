<?php

namespace App\Http\Controllers;

use App\Models\GaleriAlbum;
use App\Models\GaleriFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriFotoController extends GalleryControllerBase
{
    public function index($album_id)
    {
        $photos = GaleriFoto::where('album_id', $album_id)->latest()->get();

        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'data' => $photos,
        ]));
    }

    public function uploadPhotos(Request $request, $album_id)
    {
        $request->validate([
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'photo_links' => 'nullable|string',
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $album = GaleriAlbum::findOrFail($album_id);
        $uploaded = [];
        $rawPhotoLinks = collect(preg_split('/\r\n|\r|\n/', (string) $request->input('photo_links', '')))
            ->map(fn ($link) => trim((string) $link))
            ->filter();
        $validatedLinks = [];
        foreach ($rawPhotoLinks as $link) {
            $validatedLink = $this->sanitizeUrl($link);
            if ($link !== '' && !$validatedLink) {
                return $this->withSecurityHeaders(response()->json([
                    'success' => false,
                    'message' => "Link foto tidak valid: {$link}",
                ], 422));
            }

            if ($validatedLink) {
                $validatedLinks[] = $validatedLink;
            }
        }
        $photoLinks = collect($validatedLinks);
        $photoTitle = $this->sanitizeText($request->input('judul'));
        $photoDescription = $this->sanitizeText($request->input('deskripsi'));

        if (!$request->hasFile('photos') && $photoLinks->isEmpty()) {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Pilih foto lokal atau isi minimal satu link foto.',
            ], 422));
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('gallery', $filename, 'public');

                $photo = GaleriFoto::create([
                    'album_id' => $album->id,
                    'file_path' => $filename,
                    'judul' => $photoTitle,
                    'deskripsi' => $photoDescription,
                ]);
                $uploaded[] = $photo;
            }
        }

        foreach ($photoLinks as $link) {
            $uploaded[] = GaleriFoto::create([
                'album_id' => $album->id,
                'file_path' => $link,
                'judul' => $photoTitle,
                'deskripsi' => $photoDescription,
            ]);
        }

        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'message' => count($uploaded) . ' Foto berhasil ditambahkan!',
            'data' => $uploaded,
        ]));
    }

    public function updatePhoto(Request $request, $id)
    {
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $photo = GaleriFoto::findOrFail($id);
        $photo->judul = $this->sanitizeText($request->input('judul'));
        $photo->deskripsi = $this->sanitizeText($request->input('deskripsi'));

        if ($request->hasFile('photo_file')) {
            if ($photo->file_path && !filter_var($photo->file_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete('gallery/' . $photo->file_path);
            }

            $file = $request->file('photo_file');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('gallery', $filename, 'public');
            $photo->file_path = $filename;
        }

        $photo->save();

        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'message' => 'Foto berhasil diperbarui!',
        ]));
    }

    public function deletePhoto($id)
    {
        $photo = GaleriFoto::findOrFail($id);
        if ($photo->file_path && !filter_var($photo->file_path, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete('gallery/' . $photo->file_path);
        }
        $photo->delete();

        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'message' => 'Foto berhasil dihapus!',
        ]));
    }
}
