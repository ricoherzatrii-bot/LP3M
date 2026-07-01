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
            $extension = $request->file('file')->getClientOriginalExtension();
            $xlsx = null;

            if (strtolower($extension) === 'xlsx') {
                $xlsx = \App\Shuchkin\SimpleXLSX::parse($request->file('file')->path());
            } else {
                $xlsx = \App\Shuchkin\SimpleXLS::parse($request->file('file')->path());
            }

            if ($xlsx) {
                $rows = $xlsx->rows();
                
                if (count($rows) < 1) {
                    return response()->json(['success' => false, 'message' => 'File Excel kosong.'], 400);
                }

                if ($kategori === 'Mahasiswa') {
                    unset($rows[0]); // Skip header
                    foreach ($rows as $row) {
                        if (empty($row[0])) continue;
                        $aspectName = trim($row[0]);
                        
                        // Parse values from columns B, C, D, E (1, 2, 3, 4)
                        $baik         = (double) str_replace(['%', ','], ['', '.'], $row[1] ?? 0);
                        $sangat_baik  = (double) str_replace(['%', ','], ['', '.'], $row[2] ?? 0);
                        $kurang       = (double) str_replace(['%', ','], ['', '.'], $row[3] ?? 0);
                        $sangat_kurang = (double) str_replace(['%', ','], ['', '.'], $row[4] ?? 0);

                        if ($baik > 0 || $sangat_baik > 0 || $kurang > 0 || $sangat_kurang > 0) {
                            KuesionerDosenKaryawan::updateOrCreate(
                                ['tahun_akademik' => $tahun, 'kategori' => $kategori, 'prodi' => $prodi, 'program' => $aspectName],
                                [
                                    'sangat_setuju' => $baik,           // Map to Sangat Setuju for DB storage
                                    'setuju'        => $sangat_baik,    // Map to Setuju for DB storage
                                    'tidak_setuju'  => $kurang,
                                    'sangat_tidak_setuju' => $sangat_kurang,
                                    'cukup_setuju'  => 0
                                ]
                            );
                        }
                    }
                } else {
                    // Dosen/Staff Formats
                    unset($rows[0]); // Skip header
                    foreach ($rows as $row) {
                        $program = ''; $ss = 0; $s = 0; $cs = 0; $ts = 0; $sts = 0; $desc = ''; $order = 0;
                        if (count($row) >= 8) {
                            $program = trim($row[2] ?? '');
                            $ss      = (double) str_replace(['%', ','], ['', '.'], $row[3] ?? 0);
                            $s       = (double) str_replace(['%', ','], ['', '.'], $row[4] ?? 0);
                            $cs      = (double) str_replace(['%', ','], ['', '.'], $row[5] ?? 0);
                            $ts      = (double) str_replace(['%', ','], ['', '.'], $row[6] ?? 0);
                            $sts     = (double) str_replace(['%', ','], ['', '.'], $row[7] ?? 0);
                            $desc    = trim($row[8] ?? ''); // Optional: Column I
                            $order   = (int) ($row[9] ?? 0); // Optional: Column J
                        } else {
                            $program = trim($row[0] ?? '');
                            $ss      = (double) str_replace(['%', ','], ['', '.'], $row[1] ?? 0);
                            $s       = (double) str_replace(['%', ','], ['', '.'], $row[2] ?? 0);
                            $cs      = (double) str_replace(['%', ','], ['', '.'], $row[3] ?? 0);
                            $ts      = (double) str_replace(['%', ','], ['', '.'], $row[4] ?? 0);
                            $sts     = (double) str_replace(['%', ','], ['', '.'], $row[5] ?? 0);
                            $desc    = trim($row[6] ?? ''); // Optional
                            $order   = (int) ($row[7] ?? 0); // Optional
                        }

                        if (empty($program)) continue;

                        // Use updateOrCreate to prevent unique constraint failures and allow updates
                        KuesionerDosenKaryawan::updateOrCreate(
                            [
                                'tahun_akademik' => $tahun,
                                'kategori'      => $kategori,
                                'program'       => $program,
                            ],
                            [
                                'prodi'         => $prodi,
                                'sangat_setuju' => $ss,
                                'setuju'        => $s,
                                'cukup_setuju'  => $cs,
                                'tidak_setuju'  => $ts,
                                'sangat_tidak_setuju' => $sts,
                                'keterangan'    => $desc,
                                'urutan'        => $order
                            ]
                        );
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => "Data Kuesioner $kategori berhasil diimpor untuk T.A $tahun"
                ]);
            } else {
                $error = (strtolower($extension) === 'xlsx') ? \App\Shuchkin\SimpleXLSX::parseError() : \App\Shuchkin\SimpleXLS::parseError();
                return response()->json(['success' => false, 'message' => 'Gagal membaca: ' . $error], 400);
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
        try {
            $tahun = $request->query('tahun_akademik');
            $kategori = $request->query('kategori', 'Dosen & Karyawan');

            $query = KuesionerDosenKaryawan::where('kategori', $kategori);

            if ($tahun) {
                $count = $query->where('tahun_akademik', $tahun)->delete();
                return response()->json(['success' => true, 'message' => "Data $kategori tahun $tahun ($count entri) berhasil dihapus."]);
            }
            
            $count = $query->delete();
            return response()->json(['success' => true, 'message' => "Semua data kuesioner $kategori ($count entri) berhasil dikosongkan."]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}
