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

        $query = KuesionerDosenKaryawan::query();
        if ($tahun) {
            $query->where('tahun_akademik', $tahun);
        }

        $data = $query->orderBy('tahun_akademik', 'desc')->orderBy('program', 'asc')->get();
        $years = KuesionerDosenKaryawan::select('tahun_akademik')->distinct()->orderBy('tahun_akademik', 'desc')->pluck('tahun_akademik');

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
            'sangat_setuju' => 'required|numeric|min:0|max:100',
            'setuju' => 'required|numeric|min:0|max:100',
            'cukup_setuju' => 'required|numeric|min:0|max:100',
            'tidak_setuju' => 'required|numeric|min:0|max:100',
            'sangat_tidak_setuju' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        KuesionerDosenKaryawan::create($request->only([
            'tahun_akademik', 'program', 'sangat_setuju', 'setuju',
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
            'tahun_akademik', 'program', 'sangat_setuju', 'setuju',
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
            'tahun_akademik' => 'required|string'
        ]);

        $tahun = $request->tahun_akademik;

        try {
            if ($xlsx = SimpleXLSX::parse($request->file('file')->path())) {
                $rows = $xlsx->rows();
                
                // Skip header row
                unset($rows[0]);

                foreach ($rows as $row) {
                    // Supported Formats:
                    // 1. [Program, SS, S, CS, TS, STS] (6 columns)
                    // 2. [ID, Tahun, Program, SS, S, CS, TS, STS] (8 columns) - as requested by user
                    
                    $program = ''; $ss = 0; $s = 0; $cs = 0; $ts = 0; $sts = 0;
                    
                    if (count($row) >= 8) {
                        // Detailed format (8+ columns)
                        $program = trim($row[2] ?? '');
                        $ss      = (double) str_replace(',', '.', $row[3] ?? 0);
                        $s       = (double) str_replace(',', '.', $row[4] ?? 0);
                        $cs      = (double) str_replace(',', '.', $row[5] ?? 0);
                        $ts      = (double) str_replace(',', '.', $row[6] ?? 0);
                        $sts     = (double) str_replace(',', '.', $row[7] ?? 0);
                    } else {
                        // Standard format (6 columns)
                        $program = trim($row[0] ?? '');
                        $ss      = (double) str_replace(',', '.', $row[1] ?? 0);
                        $s       = (double) str_replace(',', '.', $row[2] ?? 0);
                        $cs      = (double) str_replace(',', '.', $row[3] ?? 0);
                        $ts      = (double) str_replace(',', '.', $row[4] ?? 0);
                        $sts     = (double) str_replace(',', '.', $row[5] ?? 0);
                    }

                    if (empty($program)) continue;

                    KuesionerDosenKaryawan::create([
                        'tahun_akademik'        => $tahun,
                        'program'               => $program,
                        'sangat_setuju'         => $ss,
                        'setuju'                => $s,
                        'cukup_setuju'          => $cs,
                        'tidak_setuju'          => $ts,
                        'sangat_tidak_setuju'  => $sts,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Data Kuesioner berhasil diimpor untuk tahun akademik ' . $tahun
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membaca file Excel: ' . SimpleXLSX::parseError()
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getStats(Request $request)
    {
        $tahun = $request->query('tahun_akademik');
        
        $query = KuesionerDosenKaryawan::query();
        if ($tahun) {
            $query->where('tahun_akademik', $tahun);
        } else {
            // Default to latest year
            $latestYear = KuesionerDosenKaryawan::max('tahun_akademik');
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
        if ($tahun) {
            KuesionerDosenKaryawan::where('tahun_akademik', $tahun)->delete();
            return response()->json(['success' => true, 'message' => "Data tahun $tahun berhasil dihapus."]);
        }
        
        KuesionerDosenKaryawan::truncate();
        return response()->json(['success' => true, 'message' => 'Semua data kuesioner dosen & karyawan berhasil dikosongkan.']);
    }
}
