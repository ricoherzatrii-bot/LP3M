<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KuesionerDosenKaryawan;
use App\Shuchkin\SimpleXLSX;
use Illuminate\Support\Facades\Validator;

class KuesionerDosenKaryawanController extends Controller
{
    /**
     * Return all data + available years for the panel table
     */
    public function index(Request $request)
    {
        $tahun = $request->query('tahun_akademik');
        $kategori = $request->query('kategori', 'Dosen & Karyawan');

        $query = KuesionerDosenKaryawan::query();
        $query->where('kategori', $kategori);
        
        if ($tahun) {
            $query->where('tahun_akademik', $tahun);
        }

        $data = $query->orderBy('tahun_akademik', 'desc')->orderBy('program', 'asc')->get();
        $years = KuesionerDosenKaryawan::where('kategori', $kategori)->select('tahun_akademik')->distinct()->orderBy('tahun_akademik', 'desc')->pluck('tahun_akademik');

        return response()->json([
            'success' => true,
            'data' => $data,
            'years' => $years
        ]);
    }

    /**
     * Store a single new row
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun_akademik' => 'required|string',
            'program' => 'required|string',
            'kategori' => 'nullable|string',
            'sangat_setuju' => 'required|numeric|min:0|max:100',
            'setuju' => 'required|numeric|min:0|max:100',
            'cukup_setuju' => 'nullable|numeric|min:0|max:100',
            'tidak_setuju' => 'required|numeric|min:0|max:100',
            'sangat_tidak_setuju' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        KuesionerDosenKaryawan::create($request->only([
            'tahun_akademik', 'program', 'prodi', 'kategori', 'sangat_setuju', 'setuju',
            'cukup_setuju', 'tidak_setuju', 'sangat_tidak_setuju'
        ]));

        return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan.']);
    }

    /**
     * Update an existing row
     */
    public function update(Request $request, $id)
    {
        $record = KuesionerDosenKaryawan::findOrFail($id);

        $record->update($request->only([
            'tahun_akademik', 'program', 'prodi', 'sangat_setuju', 'setuju',
            'cukup_setuju', 'tidak_setuju', 'sangat_tidak_setuju'
        ]));

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
    }

    /**
     * Delete a single row
     */
    public function destroy($id)
    {
        $record = KuesionerDosenKaryawan::findOrFail($id);
        $record->delete();

        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'tahun_akademik' => 'required|string',
            'kategori' => 'nullable|string',
            'prodi' => 'nullable|string'
        ]);

        $tahun = $request->tahun_akademik;
        $kategori = $request->input('kategori', 'Dosen & Karyawan');
        $prodi = $request->input('prodi', '');

        try {
            if ($xlsx = SimpleXLSX::parse($request->file('file')->path())) {
                $rows = $xlsx->rows();
                
                if ($kategori === 'Mahasiswa') {
                    // Optimized Pivot Format: [Tahun, Kriteria, Aspect1, Aspect2, Aspect3, ...]
                    // Step 1: Detect Aspects from Header (Row 1)
                    $header = $rows[0] ?? [];
                    $aspects = [];
                    for ($i = 2; $i < count($header); $i++) {
                        if (!empty(trim($header[$i]))) {
                            $aspects[$i] = trim($header[$i]);
                        }
                    }

                    if (empty($aspects)) {
                        return response()->json(['success' => false, 'message' => 'Format Excel tidak valid: Nama aspek tidak ditemukan di baris pertama.'], 400);
                    }

                    // Step 2: Skip header and process rows in groups of 4 (SB, B, K, SK)
                    unset($rows[0]);
                    $dataMap = []; // [aspectName => [criteria => value]]

                    foreach ($rows as $row) {
                        if (empty($row[0])) continue; // Skip empty rows
                        $kriteria = trim($row[1] ?? '');
                        
                        // Map user criteria names to db fields
                        $fieldMap = [
                            'Sangat Baik' => 'sangat_setuju',
                            'Baik' => 'setuju',
                            'Kurang' => 'tidak_setuju',
                            'Sangat Kurang' => 'sangat_tidak_setuju'
                        ];
                        
                        $field = $fieldMap[$kriteria] ?? null;
                        if (!$field) continue;

                        foreach ($aspects as $colIndex => $aspectName) {
                            $val = (double) str_replace(['%', ','], ['', '.'], $row[$colIndex] ?? 0);
                            $dataMap[$aspectName][$field] = $val;
                        }
                    }

                    // Step 3: Save to database
                    foreach ($dataMap as $aspectName => $values) {
                        KuesionerDosenKaryawan::updateOrCreate(
                            [
                                'tahun_akademik' => $tahun,
                                'kategori' => $kategori,
                                'prodi' => $prodi,
                                'program' => $aspectName
                            ],
                            array_merge($values, ['cukup_setuju' => 0])
                        );
                    }
                } else {
                    // Dosen/Staff Formats (as before)
                    unset($rows[0]);
                    foreach ($rows as $row) {
                        $program = ''; $ss = 0; $s = 0; $cs = 0; $ts = 0; $sts = 0;
                        if (count($row) >= 8) {
                            $program = trim($row[2] ?? '');
                            $ss      = (double) str_replace(['%', ','], ['', '.'], $row[3] ?? 0);
                            $s       = (double) str_replace(['%', ','], ['', '.'], $row[4] ?? 0);
                            $cs      = (double) str_replace(['%', ','], ['', '.'], $row[5] ?? 0);
                            $ts      = (double) str_replace(['%', ','], ['', '.'], $row[6] ?? 0);
                            $sts     = (double) str_replace(['%', ','], ['', '.'], $row[7] ?? 0);
                        } else {
                            $program = trim($row[0] ?? '');
                            $ss      = (double) str_replace(['%', ','], ['', '.'], $row[1] ?? 0);
                            $s       = (double) str_replace(['%', ','], ['', '.'], $row[2] ?? 0);
                            $cs      = (double) str_replace(['%', ','], ['', '.'], $row[3] ?? 0);
                            $ts      = (double) str_replace(['%', ','], ['', '.'], $row[4] ?? 0);
                            $sts     = (double) str_replace(['%', ','], ['', '.'], $row[5] ?? 0);
                        }

                        if (empty($program)) continue;

                        KuesionerDosenKaryawan::create([
                            'tahun_akademik' => $tahun,
                            'kategori'      => $kategori,
                            'prodi'         => $prodi,
                            'program'       => $program,
                            'sangat_setuju' => $ss,
                            'setuju'        => $s,
                            'cukup_setuju'  => $cs,
                            'tidak_setuju'  => $ts,
                            'sangat_tidak_setuju' => $sts,
                        ]);
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => "Data Kuesioner $kategori berhasil diimpor untuk T.A $tahun"
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Gagal membaca: ' . SimpleXLSX::parseError()], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function getStats(Request $request)
    {
        $tahun = $request->query('tahun_akademik');
        $kategori = $request->query('kategori', 'Dosen & Karyawan');
        
        $query = KuesionerDosenKaryawan::query();
        $query->where('kategori', $kategori);

        if ($tahun) {
            $query->where('tahun_akademik', $tahun);
        } else {
            // Default to latest year for this category
            $latestYear = KuesionerDosenKaryawan::where('kategori', $kategori)->max('tahun_akademik');
            if ($latestYear) $query->where('tahun_akademik', $latestYear);
        }

        $data = $query->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function truncate(Request $request)
    {
        $tahun = $request->query('tahun_akademik');
        $kategori = $request->query('kategori', 'Dosen & Karyawan');

        $query = KuesionerDosenKaryawan::where('kategori', $kategori);

        if ($tahun) {
            $query->where('tahun_akademik', $tahun)->delete();
            return response()->json(['success' => true, 'message' => "Data $kategori tahun $tahun berhasil dihapus."]);
        }
        
        $query->delete();
        return response()->json(['success' => true, 'message' => "Semua data kuesioner $kategori berhasil dikosongkan."]);
    }
}
