<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PilarRenstra;

class PilarRenstraController extends Controller
{
    public function index()
    {
        $data = PilarRenstra::orderBy('urutan', 'asc')->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:10', function ($attribute, $value, $fail) {
                if ($value !== strip_tags($value)) {
                    $fail('Field ' . $attribute . ' tidak boleh mengandung tag HTML atau skrip.');
                }
            }],
            'judul' => ['required', 'string', function ($attribute, $value, $fail) {
                if ($value !== strip_tags($value)) {
                    $fail('Field ' . $attribute . ' tidak boleh mengandung tag HTML atau skrip.');
                }
            }],
            'warna' => ['required', 'string', 'max:20', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'gradient_class' => ['required', 'string', 'max:255'],
            'urutan' => 'required|integer|min:1',
        ]);

        PilarRenstra::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pilar Renstra berhasil ditambahkan.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:10', function ($attribute, $value, $fail) {
                if ($value !== strip_tags($value)) {
                    $fail('Field ' . $attribute . ' tidak boleh mengandung tag HTML atau skrip.');
                }
            }],
            'judul' => ['required', 'string', function ($attribute, $value, $fail) {
                if ($value !== strip_tags($value)) {
                    $fail('Field ' . $attribute . ' tidak boleh mengandung tag HTML atau skrip.');
                }
            }],
            'warna' => ['required', 'string', 'max:20', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'gradient_class' => ['required', 'string', 'max:255'],
            'urutan' => 'required|integer|min:1',
        ]);

        $pilar = PilarRenstra::findOrFail($id);
        $pilar->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pilar Renstra berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $pilar = PilarRenstra::findOrFail($id);
        $pilar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pilar Renstra berhasil dihapus.'
        ]);
    }
}
