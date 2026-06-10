<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    public function index()
    {
        $data = Slider::orderBy('urutan', 'asc')->get();
        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul'     => 'nullable|string|max:255',
                'sub_judul' => 'nullable|string|max:255',
                'gambar'    => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
                'link_url'  => 'nullable|string|max:255',
                'urutan'    => 'nullable|integer',
            ]);

            $path = $request->file('gambar')->store('sliders', 'public');

            $slider = Slider::create([
                'judul'     => $request->judul,
                'sub_judul' => $request->sub_judul,
                'gambar'    => $path,
                'link_url'  => $request->link_url,
                'urutan'    => $request->urutan ?? 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Slide berhasil ditambahkan!',
                'data'    => $slider
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambah slide: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $slider = Slider::findOrFail($id);

            $request->validate([
                'judul'     => 'nullable|string|max:255',
                'sub_judul' => 'nullable|string|max:255',
                'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
                'link_url'  => 'nullable|string|max:255',
                'urutan'    => 'nullable|integer',
            ]);

            $data = [
                'judul'     => $request->judul,
                'sub_judul' => $request->sub_judul,
                'link_url'  => $request->link_url,
                'urutan'    => $request->urutan ?? $slider->urutan,
            ];

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama
                if ($slider->gambar) {
                    Storage::disk('public')->delete($slider->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('sliders', 'public');
            }

            $slider->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Slide berhasil diperbarui!',
                'data'    => $slider
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui slide: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            if ($slider->gambar) {
                Storage::disk('public')->delete($slider->gambar);
            }
            $slider->delete();

            return response()->json([
                'success' => true,
                'message' => 'Slide berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus slide: ' . $e->getMessage()
            ], 500);
        }
    }
}