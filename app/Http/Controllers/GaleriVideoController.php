<?php

namespace App\Http\Controllers;

use App\Models\GaleriVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriVideoController extends GalleryControllerBase
{
    public function index()
    {
        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'data' => GaleriVideo::latest()->get(),
        ]));
    }

    public function uploadVideo(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,mkv,wmv|max:40960',
            'link_youtube' => 'nullable|string|max:65535',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        if (!$request->hasFile('video_file') && !$request->filled('link_youtube')) {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Upload file video atau isi link video terlebih dahulu.',
            ], 422));
        }

        $judul = $this->sanitizeText($validated['judul'] ?? null);
        if ($judul === '') {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Judul video wajib diisi.',
            ], 422));
        }

        $deskripsi = $this->sanitizeText($validated['deskripsi'] ?? null);
        $videoLink = $this->sanitizeUrl($validated['link_youtube'] ?? null);
        if ($request->filled('link_youtube') && !$videoLink) {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Link video tidak valid.',
            ], 422));
        }

        $videoSource = null;
        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $videoSource = time() . '_' . Str::slug($judul) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('gallery/videos', $videoSource, 'public');
        } elseif ($videoLink) {
            $videoSource = $videoLink;
        }

        $video = GaleriVideo::create([
            'judul' => $judul,
            'slug' => Str::slug($judul),
            'link_youtube' => $videoSource,
            'deskripsi' => $deskripsi,
        ]);

        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'message' => 'Video berhasil ditambahkan!',
            'data' => $video,
        ]));
    }

    public function updateVideo(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,mkv,wmv|max:40960',
            'link_youtube' => 'nullable|string|max:65535',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $video = GaleriVideo::findOrFail($id);
        $judul = $this->sanitizeText($validated['judul'] ?? null);
        if ($judul === '') {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Judul video wajib diisi.',
            ], 422));
        }

        $deskripsi = $this->sanitizeText($validated['deskripsi'] ?? null);
        $videoLink = $this->sanitizeUrl($validated['link_youtube'] ?? null);
        if ($request->filled('link_youtube') && !$videoLink) {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Link video tidak valid.',
            ], 422));
        }

        $video->judul = $judul;
        $video->slug = Str::slug($judul);
        $video->deskripsi = $deskripsi;

        if ($request->hasFile('video_file')) {
            if ($video->link_youtube && !filter_var($video->link_youtube, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete('gallery/videos/' . $video->link_youtube);
            }
            $file = $request->file('video_file');
            $videoSource = time() . '_' . Str::slug($judul) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('gallery/videos', $videoSource, 'public');
            $video->link_youtube = $videoSource;
        } elseif ($videoLink) {
            $video->link_youtube = $videoLink;
        }

        $video->save();

        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'message' => 'Video berhasil diperbarui!',
        ]));
    }

    public function deleteVideo($id)
    {
        $video = GaleriVideo::findOrFail($id);
        if ($video->link_youtube && !filter_var($video->link_youtube, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete('gallery/videos/' . $video->link_youtube);
        }
        $video->delete();

        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'message' => 'Video berhasil dihapus!',
        ]));
    }
}
