<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KuesionerMahasiswaController extends KuesionerDosenKaryawanController
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

    public function index(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
        ]);

        $request->merge([
            'kategori' => 'Mahasiswa',
            'tahun_akademik' => $this->sanitizeText($validated['tahun_akademik'] ?? $request->query('tahun_akademik')),
        ]);

        return $this->withSecurityHeaders(parent::index($request));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'prodi' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'sangat_setuju' => 'required|numeric|min:0|max:100',
            'setuju' => 'required|numeric|min:0|max:100',
            'cukup_setuju' => 'nullable|numeric|min:0|max:100',
            'tidak_setuju' => 'required|numeric|min:0|max:100',
            'sangat_tidak_setuju' => 'required|numeric|min:0|max:100',
        ]);

        $request->merge([
            'kategori' => 'Mahasiswa',
            'tahun_akademik' => $this->sanitizeText($validated['tahun_akademik'] ?? null),
            'program' => $this->sanitizeText($validated['program'] ?? null),
            'prodi' => $this->sanitizeText($validated['prodi'] ?? null),
            'sangat_setuju' => (float) ($validated['sangat_setuju'] ?? 0),
            'setuju' => (float) ($validated['setuju'] ?? 0),
            'cukup_setuju' => (float) ($validated['cukup_setuju'] ?? 0),
            'tidak_setuju' => (float) ($validated['tidak_setuju'] ?? 0),
            'sangat_tidak_setuju' => (float) ($validated['sangat_tidak_setuju'] ?? 0),
        ]);

        return $this->withSecurityHeaders(parent::store($request));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'nullable|string|max:255',
            'program' => 'nullable|string|max:255',
            'prodi' => 'nullable|string|max:255',
            'sangat_setuju' => 'nullable|numeric|min:0|max:100',
            'setuju' => 'nullable|numeric|min:0|max:100',
            'cukup_setuju' => 'nullable|numeric|min:0|max:100',
            'tidak_setuju' => 'nullable|numeric|min:0|max:100',
            'sangat_tidak_setuju' => 'nullable|numeric|min:0|max:100',
        ]);

        $request->merge([
            'kategori' => 'Mahasiswa',
            'tahun_akademik' => isset($validated['tahun_akademik']) ? $this->sanitizeText($validated['tahun_akademik']) : $request->input('tahun_akademik'),
            'program' => isset($validated['program']) ? $this->sanitizeText($validated['program']) : $request->input('program'),
            'prodi' => isset($validated['prodi']) ? $this->sanitizeText($validated['prodi']) : $request->input('prodi'),
            'sangat_setuju' => isset($validated['sangat_setuju']) ? (float) $validated['sangat_setuju'] : $request->input('sangat_setuju'),
            'setuju' => isset($validated['setuju']) ? (float) $validated['setuju'] : $request->input('setuju'),
            'cukup_setuju' => isset($validated['cukup_setuju']) ? (float) $validated['cukup_setuju'] : $request->input('cukup_setuju'),
            'tidak_setuju' => isset($validated['tidak_setuju']) ? (float) $validated['tidak_setuju'] : $request->input('tidak_setuju'),
            'sangat_tidak_setuju' => isset($validated['sangat_tidak_setuju']) ? (float) $validated['sangat_tidak_setuju'] : $request->input('sangat_tidak_setuju'),
        ]);

        return $this->withSecurityHeaders(parent::update($request, $id));
    }

    public function destroy($id)
    {
        return $this->withSecurityHeaders(parent::destroy($id));
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'tahun_akademik' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'prodi' => 'nullable|string|max:255',
        ]);

        $request->merge([
            'kategori' => 'Mahasiswa',
            'tahun_akademik' => $this->sanitizeText($validated['tahun_akademik'] ?? null),
            'prodi' => $this->sanitizeText($validated['prodi'] ?? null),
        ]);

        return $this->withSecurityHeaders(parent::import($request));
    }

    public function getStats(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
        ]);

        $request->merge([
            'kategori' => 'Mahasiswa',
            'tahun_akademik' => $this->sanitizeText($validated['tahun_akademik'] ?? null),
        ]);

        return $this->withSecurityHeaders(parent::getStats($request));
    }

    public function truncate(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'nullable|string|max:255',
            'semester' => 'nullable|string|max:50',
            'kategori' => 'nullable|string|max:255',
            'prodi' => 'nullable|string|max:255',
        ]);

        $request->merge([
            'kategori' => 'Mahasiswa',
            'tahun_akademik' => $this->sanitizeText($validated['tahun_akademik'] ?? null),
            'semester' => $this->sanitizeText($validated['semester'] ?? null),
            'prodi' => $this->sanitizeText($validated['prodi'] ?? null),
        ]);

        return $this->withSecurityHeaders(parent::truncate($request));
    }

    public function addProdi(Request $request)
    {
        $validated = $request->validate([
            'prodi' => 'required|string|max:100',
        ]);

        $request->merge([
            'prodi' => $this->sanitizeText($validated['prodi'] ?? null),
        ]);

        return $this->withSecurityHeaders(parent::addProdi($request));
    }

    public function downloadTemplateMahasiswa()
    {
        return $this->withSecurityHeaders(parent::downloadTemplateMahasiswa());
    }
}
