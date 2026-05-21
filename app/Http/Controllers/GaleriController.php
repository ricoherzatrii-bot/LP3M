<?php

namespace App\Http\Controllers;

use App\Models\GaleriAlbum;
use App\Models\GaleriVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * Album Foto CRUD
     */
    public function getAlbums()
    {
        return response()->json(['success' => true, 'data' => GaleriAlbum::with('firstFoto')->latest()->get()]);
    }

    public function uploadAlbum(Request $request)
    {
        $request->validate([
            'nama_album' => 'required|string',
            'sampul_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'link_extern' => 'nullable|string|max:255'
        ]);

        \Log::info('Album Upload Attempt: ' . $request->nama_album);

        $filename = null;
        if ($request->hasFile('sampul_foto')) {
            $file = $request->file('sampul_foto');
            $filename = time() . '_' . Str::slug($request->nama_album) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('gallery', $filename, 'public');
        } elseif ($request->link_extern) {
            $filename = $request->link_extern;
        }

        $album = GaleriAlbum::create([
            'nama_album' => $request->nama_album,
            'slug' => Str::slug($request->nama_album),
            'sampul_foto' => $filename
        ]);

        return response()->json(['success' => true, 'message' => 'Album berhasil ditambahkan!', 'data' => $album]);
    }

    public function updateAlbum(Request $request, $id)
    {
        $album = GaleriAlbum::findOrFail($id);
        
        $album->nama_album = $request->nama_album;
        $album->slug = Str::slug($request->nama_album);

        if ($request->hasFile('sampul_foto')) {
            // Delete old file if exists locally
            if ($album->sampul_foto && !filter_var($album->sampul_foto, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete('gallery/' . $album->sampul_foto);
            }
            $file = $request->file('sampul_foto');
            $filename = time() . '_' . Str::slug($request->nama_album) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('gallery', $filename, 'public');
            $album->sampul_foto = $filename;
        } elseif ($request->link_extern) {
            $album->sampul_foto = $request->link_extern;
        }

        $album->save();
        return response()->json(['success' => true, 'message' => 'Album berhasil diperbarui!']);
    }

    public function deleteAlbum($id)
    {
        $album = GaleriAlbum::with('fotos')->findOrFail($id);
        
        // Delete album cover
        if ($album->sampul_foto && !filter_var($album->sampul_foto, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete('gallery/' . $album->sampul_foto);
        }

        // Delete all associated photos and files
        foreach ($album->fotos as $foto) {
            if ($foto->file_path && !filter_var($foto->file_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete('gallery/' . $foto->file_path);
            }
            $foto->delete();
        }

        $album->delete();
        return response()->json(['success' => true, 'message' => 'Album dan semua foto di dalamnya berhasil dihapus!']);
    }

    /**
     * Video Galeri CRUD
     */
    public function getVideos()
    {
        return response()->json(['success' => true, 'data' => GaleriVideo::latest()->get()]);
    }

    public function uploadVideo(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,mkv,wmv|max:40960', // Max 40MB sync with server
            'link_youtube' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        \Log::info('Video Upload Attempt: ' . $request->judul);

        $videoSource = null;
        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $videoSource = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('gallery/videos', $videoSource, 'public');
        } elseif ($request->link_youtube) {
            $videoSource = $request->link_youtube;
        }

        $video = GaleriVideo::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'link_youtube' => $videoSource,
            'deskripsi' => $request->deskripsi
        ]);

        return response()->json(['success' => true, 'message' => 'Video berhasil ditambahkan!', 'data' => $video]);
    }

    public function updateVideo(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,mkv,wmv|max:40960',
            'link_youtube' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $video = GaleriVideo::findOrFail($id);
        $video->judul = $request->judul;
        $video->slug = Str::slug($request->judul);
        $video->deskripsi = $request->deskripsi;

        if ($request->hasFile('video_file')) {
            if ($video->link_youtube && !filter_var($video->link_youtube, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete('gallery/videos/' . $video->link_youtube);
            }
            $file = $request->file('video_file');
            $videoSource = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('gallery/videos', $videoSource, 'public');
            $video->link_youtube = $videoSource;
        } elseif ($request->link_youtube) {
            $video->link_youtube = $request->link_youtube;
        }

        $video->save();
        return response()->json(['success' => true, 'message' => 'Video berhasil diperbarui!']);
    }

    public function deleteVideo($id)
    {
        $video = GaleriVideo::findOrFail($id);
        if ($video->link_youtube && !filter_var($video->link_youtube, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete('gallery/videos/' . $video->link_youtube);
        }
        $video->delete();
        return response()->json(['success' => true, 'message' => 'Video berhasil dihapus!']);
    }

    /**
     * Individual Photo Management
     */
    public function getPhotos($album_id)
    {
        $photos = \App\Models\GaleriFoto::where('album_id', $album_id)->latest()->get();
        return response()->json(['success' => true, 'data' => $photos]);
    }

    public function uploadPhotos(Request $request, $album_id)
    {
        $request->validate([
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240' // 10MB per photo
        ]);

        $album = GaleriAlbum::findOrFail($album_id);
        $uploaded = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('gallery', $filename, 'public');

                $photo = \App\Models\GaleriFoto::create([
                    'album_id' => $album->id,
                    'file_path' => $filename
                ]);
                $uploaded[] = $photo;
            }
        }

        return response()->json(['success' => true, 'message' => count($uploaded) . ' Foto berhasil ditambahkan!', 'data' => $uploaded]);
    }

    public function deletePhoto($id)
    {
        $photo = \App\Models\GaleriFoto::findOrFail($id);
        if ($photo->file_path && !filter_var($photo->file_path, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete('gallery/' . $photo->file_path);
        }
        $photo->delete();
        return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus!']);
    }
}
