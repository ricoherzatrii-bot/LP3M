<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use App\Models\KuesionerPertanyaan;
use Illuminate\Http\Request;

class KuesionerPertanyaanController extends Controller
{
    public function index($kuesioner_id)
    {
        $kuesioner = Kuesioner::with('pertanyaans')->findOrFail($kuesioner_id);
        return response()->json([
            'success' => true,
            'data'    => $kuesioner->pertanyaans()->orderBy('urutan', 'asc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kuesioner_id' => 'required|exists:kuesioners,id',
            'pertanyaan'   => 'required|string',
            'tipe_jawaban' => 'required|in:skala_likert,teks,pilihan_ganda',
            'opsi_jawaban' => 'nullable|string',
            'urutan'       => 'nullable|integer'
        ]);

        $pertanyaan = KuesionerPertanyaan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil ditambahkan.',
            'data'    => $pertanyaan
        ]);
    }

    public function update(Request $request, $id)
    {
        $pertanyaan = KuesionerPertanyaan::findOrFail($id);
        
        $validated = $request->validate([
            'pertanyaan'   => 'sometimes|required|string',
            'tipe_jawaban' => 'sometimes|required|in:skala_likert,teks,pilihan_ganda',
            'opsi_jawaban' => 'nullable|string',
            'urutan'       => 'nullable|integer'
        ]);

        $pertanyaan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $pertanyaan = KuesionerPertanyaan::findOrFail($id);
        $pertanyaan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil dihapus.'
        ]);
    }

    /**
     * Public: Submit kuesioner responses
     */
    public function submitResponse(Request $request)
    {
        $request->validate([
            'kuesioner_id' => 'required|exists:kuesioners,id',
            'jawaban'      => 'required|array',
        ]);

        $sessionId = uniqid('krs_', true);
        $ip = $request->ip();

        foreach ($request->jawaban as $pertanyaanId => $jawaban) {
            \App\Models\KuesionerResponse::create([
                'kuesioner_id'  => $request->kuesioner_id,
                'pertanyaan_id' => $pertanyaanId,
                'jawaban'       => is_array($jawaban) ? json_encode($jawaban) : $jawaban,
                'session_id'    => $sessionId,
                'ip_address'    => $ip,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Jawaban kuesioner Anda telah berhasil dikirim.'
        ]);
    }
}
