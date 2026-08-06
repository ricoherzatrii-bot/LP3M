<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    private function withSecurityHeaders($response)
    {
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: blob:; font-src 'self' data:; connect-src 'self'; object-src 'none'; base-uri 'self'; frame-ancestors 'none'"
        );

        return $response;
    }

    private function sanitizeText($value): string
    {
        if ($value === null) {
            return '';
        }

        $stringValue = strip_tags((string) $value);
        $stringValue = trim($stringValue);
        $stringValue = preg_replace('/[\x00-\x1F\x7F]/u', '', $stringValue);

        return $stringValue ?? '';
    }

    public function index()
    {
        $data = Slider::orderBy('urutan', 'asc')->get();
        return $this->withSecurityHeaders(response()->json([
            'success' => true,
            'data'    => $data
        ]));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul'     => 'nullable|string|max:255',
                'sub_judul' => 'nullable|string|max:255',
                'gambar'    => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
                'link_url'  => 'nullable|string|max:255',
                'urutan'    => 'nullable|integer',
            ]);

            $path = $request->file('gambar')->store('sliders', 'public');

            $slider = Slider::create([
                'judul'     => $this->sanitizeText($validated['judul'] ?? null),
                'sub_judul' => $this->sanitizeText($validated['sub_judul'] ?? null),
                'gambar'    => $path,
                'link_url'  => $this->sanitizeText($validated['link_url'] ?? null),
                'urutan'    => (int) ($validated['urutan'] ?? 0),
            ]);

            return $this->withSecurityHeaders(response()->json([
                'success' => true,
                'message' => 'Slide berhasil ditambahkan!',
                'data'    => $slider
            ]));
        } catch (\Exception $e) {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Gagal menambah slide: ' . $e->getMessage()
            ], 500));
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $slider = Slider::findOrFail($id);

            $validated = $request->validate([
                'judul'     => 'nullable|string|max:255',
                'sub_judul' => 'nullable|string|max:255',
                'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
                'link_url'  => 'nullable|string|max:255',
                'urutan'    => 'nullable|integer',
            ]);

            $data = [
                'judul'     => $this->sanitizeText($validated['judul'] ?? $slider->judul),
                'sub_judul' => $this->sanitizeText($validated['sub_judul'] ?? $slider->sub_judul),
                'link_url'  => $this->sanitizeText($validated['link_url'] ?? $slider->link_url),
                'urutan'    => isset($validated['urutan']) ? (int) $validated['urutan'] : $slider->urutan,
            ];

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama
                if ($slider->gambar) {
                    Storage::disk('public')->delete($slider->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('sliders', 'public');
            }

            $slider->update($data);

            return $this->withSecurityHeaders(response()->json([
                'success' => true,
                'message' => 'Slide berhasil diperbarui!',
                'data'    => $slider
            ]));
        } catch (\Exception $e) {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui slide: ' . $e->getMessage()
            ], 500));
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

            return $this->withSecurityHeaders(response()->json([
                'success' => true,
                'message' => 'Slide berhasil dihapus!'
            ]));
        } catch (\Exception $e) {
            return $this->withSecurityHeaders(response()->json([
                'success' => false,
                'message' => 'Gagal menghapus slide: ' . $e->getMessage()
            ], 500));
        }
    }
}