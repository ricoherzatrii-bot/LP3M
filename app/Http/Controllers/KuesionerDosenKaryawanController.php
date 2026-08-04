<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KuesionerDosenKaryawan;
use App\Models\Prodi;
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
            $trimmedYear = trim($tahun);
            $query->whereRaw('LOWER(tahun_akademik) LIKE ?', [strtolower($trimmedYear) . '%']);
        }

        $data = $query->orderBy('tahun_akademik', 'desc')->orderBy('program', 'asc')->get();
        $years = KuesionerDosenKaryawan::where('kategori', $kategori)->select('tahun_akademik')->distinct()->orderBy('tahun_akademik', 'desc')->pluck('tahun_akademik');

        // Merge prodi from all sources: prodis table + akreditasi + kuesioner data
        $prodiFromTable = Prodi::orderBy('nama')->pluck('nama');
        $prodiFromAkreditasi = collect();
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('akreditasi')) {
                $prodiFromAkreditasi = \App\Models\Akreditasi::where('kategori', 'Akreditasi')->pluck('judul');
            }
        } catch (\Exception $e) {}
        $prodiFromData = KuesionerDosenKaryawan::where('kategori', $kategori)
            ->whereNotNull('prodi')
            ->where('prodi', '!=', '')
            ->distinct()
            ->pluck('prodi');
        $prodis = $prodiFromTable->merge($prodiFromAkreditasi)->merge($prodiFromData)
            ->map(function ($prodi) { return trim($prodi); })
            ->filter(function ($prodi) { return !empty($prodi); })
            ->unique(function ($prodi) { return strtolower(trim($prodi)); })
            ->sort()
            ->values();

        return response()->json([
            'success' => true,
            'data' => $data,
            'years' => $years,
            'prodis' => $prodis
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

        $request->validate([
            'tahun_akademik' => 'nullable|string|max:255',
            'program' => 'nullable|string|max:255',
            'prodi' => 'nullable|string|max:255',
            'sangat_setuju' => 'nullable|numeric|min:0|max:100',
            'setuju' => 'nullable|numeric|min:0|max:100',
            'cukup_setuju' => 'nullable|numeric|min:0|max:100',
            'tidak_setuju' => 'nullable|numeric|min:0|max:100',
            'sangat_tidak_setuju' => 'nullable|numeric|min:0|max:100',
        ]);

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
            'tahun_akademik' => $request->input('kategori') === 'Mahasiswa' ? 'nullable|string' : 'required|string',
            'kategori' => 'nullable|string',
            'prodi' => 'nullable|string'
        ]);

        $tahun = $request->tahun_akademik;
        $kategori = $request->input('kategori', 'Dosen & Karyawan');
        $prodi = trim($request->input('prodi', ''));

        // Normalization Map to prevent duplicates
        $prodiMap = [
            'Akuntansi Perpajakan' => 'D4 Akuntansi Perpajakan',
            'D4 Akuntasi Perpajakan' => 'D4 Akuntansi Perpajakan',
            'Bisnis Digital' => 'D4 Bisnis Digital',
            'D3 Elektronika' => 'D3 Teknik Elektronika',
            'Teknik Elektronika' => 'D3 Teknik Elektronika',
            'D3 Listrik' => 'D3 Teknik Listrik',
            'Teknik Listrik' => 'D3 Teknik Listrik',
            'Teknik Mesin' => 'D3 Teknik Mesin',
            'D4 TRLOG' => 'D4 Teknologi Rekayasa Logistik',
            'Teknologi Rekayasa Logistik' => 'D4 Teknologi Rekayasa Logistik',
            'D4 TRPAB' => 'D4 Teknologi Rekayasa Pemeliharaan Alat Berat',
            'Teknologi Rekayasa Pemeliharaan Alat Berat' => 'D4 Teknologi Rekayasa Pemeliharaan Alat Berat',
            'D4 Teknologi Rekayasa Perangkat Lunak' => 'D4 Teknologi Rekayasa Perangkat Lunak',
            'Teknologi Rekayasa Perangkat Lunak' => 'D4 Teknologi Rekayasa Perangkat Lunak',
            'IT' => 'D4 Teknologi Rekayasa Perangkat Lunak',
            'Tambang' => 'D3 Teknik Pertambangan',
        ];
        foreach ($prodiMap as $key => $value) {
            if (strtolower(trim($prodi)) === strtolower($key)) {
                $prodi = $value;
                break;
            }
        }

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
                    
                    // Helper: parse percentage cells — SimpleXLSX reads "74.99%" as 0.7499
                    $parsePercent = function($val) {
                        if (is_null($val) || $val === '') return 0.0;
                        $valStr = (string)$val;
                        $hasPercent = (strpos($valStr, '%') !== false);
                        $num = (double) str_replace(['%', ','], ['', '.'], $valStr);
                        // If SimpleXLSX returned a raw fraction (e.g. 0.7499 for 74.99%), scale it up
                        if (!$hasPercent && is_numeric($val) && $num >= 0 && $num <= 1.0) {
                            $num = round($num * 100, 2);
                        }
                        return $num;
                    };

                    foreach ($rows as $row) {
                        if (empty($row[0])) continue;
                        $rowTahun = trim($row[0]);
                        if (strtolower($rowTahun) === 'tahun akademik') continue;

                        $aspectName = isset($row[1]) ? trim($row[1]) : '';
                        if (empty($aspectName)) continue;
                        
                        // Parse values from columns C, D, E, F (2, 3, 4, 5)
                        $sangat_baik   = $parsePercent($row[2] ?? 0);
                        $baik          = $parsePercent($row[3] ?? 0);
                        $kurang        = $parsePercent($row[4] ?? 0);
                        $sangat_kurang = $parsePercent($row[5] ?? 0);

                        if ($sangat_baik > 0 || $baik > 0 || $kurang > 0 || $sangat_kurang > 0) {
                            KuesionerDosenKaryawan::updateOrCreate(
                                ['tahun_akademik' => $rowTahun, 'kategori' => $kategori, 'prodi' => $prodi, 'program' => $aspectName],
                                [
                                    'sangat_setuju' => $sangat_baik,    // Excel "Sangat Baik" → DB sangat_setuju
                                    'setuju'        => $baik,           // Excel "Baik" → DB setuju
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

                $msg = $tahun ? "Data Kuesioner $kategori berhasil diimpor untuk T.A $tahun" : "Data Kuesioner $kategori berhasil diimpor";
                return response()->json([
                    'success' => true,
                    'message' => $msg
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
            $trimmedYear = trim($tahun);
            $query->whereRaw('LOWER(tahun_akademik) LIKE ?', [strtolower($trimmedYear) . '%']);
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
            $semester = $request->query('semester');
            $kategori = $request->query('kategori', 'Dosen & Karyawan');
            $prodi = $request->query('prodi');

            $query = KuesionerDosenKaryawan::where('kategori', $kategori);

            if ($prodi && $prodi !== 'all' && $prodi !== '') {
                $query->where('prodi', $prodi);
            }

            if ($tahun) {
                $trimmedYear = trim($tahun);
                $query->whereRaw('LOWER(tahun_akademik) LIKE ?', [strtolower($trimmedYear) . '%']);
            }

            if ($semester) {
                $semester = strtolower(trim($semester));
                if ($semester === 'ganjil' || $semester === 'genap') {
                    $query->whereRaw('LOWER(tahun_akademik) LIKE ?', ["%{$semester}%"]);
                }
            }
            
            $count = $query->delete();
            
            $prodiMsg = ($prodi && $prodi !== 'all' && $prodi !== '') ? " prodi $prodi" : "";
            $tahunMsg = $tahun ? " tahun $tahun" : "";
            $semesterMsg = $semester ? " semester " . ucfirst($semester) : "";

            return response()->json([
                'success' => true, 
                'message' => "Data $kategori$prodiMsg$tahunMsg$semesterMsg ($count entri) berhasil dihapus."
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Add a new prodi entry so it appears in prodi lists.
     * Creates a minimal record with kategori 'Mahasiswa'.
     */
    public function addProdi(Request $request)
    {
        $request->validate([
            'prodi' => 'required|string|max:100'
        ]);

        try {
            $name = trim($request->input('prodi'));
            if (empty($name)) {
                return response()->json(['success' => false, 'message' => 'Nama prodi tidak boleh kosong.'], 422);
            }

            // Create or return existing
            $prodi = Prodi::firstOrCreate(['nama' => $name]);

            return response()->json(['success' => true, 'message' => 'Prodi berhasil ditambahkan.', 'prodi' => $prodi]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menambahkan prodi: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Download template Excel (CSV) untuk import Kuesioner Mahasiswa.
     * Format: Tahun Akademik | Aspek Penilaian | SB (%) | B (%) | K (%) | SK (%)
     */
    public function downloadTemplateMahasiswa()
    {
        $headers = [
            'Tahun Akademik',
            'Aspek Penilaian',
            'Sangat Baik (%)',
            'Baik (%)',
            'Kurang (%)',
            'Sangat Kurang (%)'
        ];

        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            // BOM for Excel UTF-8 compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $headers);

            // Sample rows for guidance
            fputcsv($file, ['2026 Ganjil', 'Assurance', '68.73', '23.69', '6.6', '0.97']);
            fputcsv($file, ['2026 Ganjil', 'Responsiveness', '55.44', '32.77', '10.39', '1.4']);
            fputcsv($file, ['2026 Ganjil', 'Tangible', '60.12', '28.50', '9.30', '2.08']);
            fputcsv($file, ['2026 Ganjil', 'Empathy', '62.00', '25.00', '11.00', '2.00']);
            fputcsv($file, ['2026 Ganjil', 'Reliability', '58.00', '30.00', '10.00', '2.00']);

            fclose($file);
        };

        return response()->streamDownload($callback, 'template_kuesioner_mahasiswa.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Download template Excel (CSV) untuk import Kuesioner Dosen & Karyawan.
     * Format: Program | Sangat Setuju (%) | Setuju (%) | Cukup Setuju (%) | Tidak Setuju (%) | Sangat Tidak Setuju (%)
     */
    public function downloadTemplateDosen()
    {
        $headers = [
            'Program',
            'Sangat Setuju (%)',
            'Setuju (%)',
            'Cukup Setuju (%)',
            'Tidak Setuju (%)',
            'Sangat Tidak Setuju (%)'
        ];

        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            // BOM for Excel UTF-8 compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $headers);

            // Sample rows for guidance
            fputcsv($file, ['Kepuasan Layanan Akademik', '45.5', '30.2', '15.0', '7.3', '2.0']);
            fputcsv($file, ['Kepuasan Layanan Administratif', '40.0', '35.0', '14.0', '8.0', '3.0']);
            fputcsv($file, ['Kepuasan Sarana Prasarana', '38.5', '32.0', '18.5', '9.0', '2.0']);

            fclose($file);
        };

        return response()->streamDownload($callback, 'template_kuesioner_dosen_karyawan.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
