<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    /**
     * Menampilkan daftar pengumuman
     */
    public function index()
    {
        $allProfil = \App\Models\Profil::all();
        $pengumumans = Pengumuman::where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.pengumuman.index', compact('pengumumans', 'allProfil'));
    }

    /**
     * Menampilkan detail pengumuman
     */
    public function show($slug)
    {
        $allProfil = \App\Models\Profil::all();
        
        $pengumuman = Pengumuman::where('slug', $slug)
            ->where('status', 'aktif')
            ->firstOrFail();

        // Update hits
        $pengumuman->increment('hits');

        // Ambil pengumuman lainnya untuk sidebar
        $recentPengumumans = Pengumuman::where('id', '!=', $pengumuman->id)
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $prev = Pengumuman::where('created_at', '<', $pengumuman->created_at)->where('status', 'aktif')->orderBy('created_at', 'desc')->first();
        $next = Pengumuman::where('created_at', '>', $pengumuman->created_at)->where('status', 'aktif')->orderBy('created_at', 'asc')->first();
        $prevUrl = $prev ? route('pengumuman.show', $prev->slug) : null;
        $nextUrl = $next ? route('pengumuman.show', $next->slug) : null;

        return view('pages.pengumuman.show', compact('pengumuman', 'allProfil', 'recentPengumumans', 'prevUrl', 'nextUrl'));
    }

    /**
     * API - Get all Pengumuman untuk backend admin
     */
    public function getAll()
    {
        try {
            $pengumumans = Pengumuman::orderBy('created_at', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $pengumumans
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * API - Store (Tambah pengumuman)
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'isi_konten' => 'required|string',
                'gambar' => 'nullable|string',
                'status' => 'nullable|in:aktif,non-aktif',
            ]);

            $validated['slug'] = Str::slug($validated['judul']) . '-' . time();
            $validated['status'] = $validated['status'] ?? 'aktif';
            $validated['hits'] = 0;

            $pengumuman = Pengumuman::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Pengumuman berhasil ditambahkan',
                'data' => $pengumuman
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * API - Update pengumuman
     */
    public function update(Request $request, $id)
    {
        try {
            $pengumuman = Pengumuman::findOrFail($id);

            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'isi_konten' => 'required|string',
                'gambar' => 'nullable|string',
                'status' => 'nullable|in:aktif,non-aktif',
            ]);

            $pengumuman->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Pengumuman berhasil diupdate',
                'data' => $pengumuman
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * API - Delete pengumuman
     */
    public function destroy($id)
    {
        try {
            $pengumuman = Pengumuman::findOrFail($id);
            $pengumuman->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pengumuman berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Halaman admin - Daftar pengumuman (Legacy view)
     */
    public function adminIndex()
    {
        $pengumumans = Pengumuman::latest()->paginate(20);
        return view('admin.pengumuman.index', compact('pengumumans'));
    }
}
