<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CapaianRenstra;
use App\Shuchkin\SimpleXLSX;

class RenstraController extends Controller
{
    public function index()
    {
        $data = CapaianRenstra::orderBy('tahun', 'asc')->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function publicIndex(Request $request)
    {
        $availableYears = CapaianRenstra::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $selectedYears = $request->get('tahun', [$availableYears->first()]);
        
        // Ensure selectedYears is an array (handle comma-separated string from URL if needed)
        if (!is_array($selectedYears)) {
            $selectedYears = array_filter(explode(',', $selectedYears));
        }

        // Filter valid years
        $selectedYears = array_filter($selectedYears, function($y) use ($availableYears) {
            return $availableYears->contains($y);
        });

        // Default to latest year if empty
        if (empty($selectedYears)) {
            $selectedYears = [$availableYears->first()];
        }

        // Aggregate data across selected years (average target and realisasi per indicator)
        $data = CapaianRenstra::whereIn('tahun', $selectedYears)
            ->selectRaw('program, indikator, ROUND(AVG(target), 2) as target, ROUND(AVG(realisasi), 2) as realisasi')
            ->groupBy('program', 'indikator')
            ->orderBy('program', 'asc')
            ->get()
            ->groupBy('program');

        // Yearly trend for line chart (Sync with selection)
        $yearlyStats = CapaianRenstra::whereIn('tahun', $selectedYears)
            ->selectRaw('tahun, ROUND(AVG(realisasi),1) as avg_realisasi, ROUND(AVG(target),1) as avg_target, COUNT(*) as total_indikator')
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc')
            ->get();

        // All-year program stats for horizontal multi-bar chart (Sync with selection)
        $allProgramStats = CapaianRenstra::whereIn('tahun', $selectedYears)
            ->selectRaw('program, tahun, ROUND(AVG(realisasi),2) as avg_realisasi')
            ->groupBy('program', 'tahun')
            ->orderBy('program')
            ->orderBy('tahun')
            ->get()
            ->groupBy('program');

        // Unique indicators for the selector
        $indicators = CapaianRenstra::select('program', 'indikator')
            ->distinct()
            ->orderBy('program')
            ->orderBy('indikator')
            ->get()
            ->groupBy('program');

        return view('pages.renstra', compact('data', 'availableYears', 'selectedYears', 'yearlyStats', 'allProgramStats', 'indicators'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

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
                
                if (count($rows) < 2) {
                    return response()->json(['success' => false, 'message' => 'File Excel kosong atau tidak valid.'], 400);
                }

                $headers = $rows[0]; // Row 0: Tahun, Pillar I, Pillar II, ...
                unset($rows[0]); // Remove headers

                $yearOverride = $request->input('tahun_override');
                $importedCount = 0;

                foreach ($rows as $row) {
                    $tahun = $yearOverride ?: trim($row[0] ?? '');
                    if (empty($tahun) || !is_numeric($tahun)) continue;

                    // Iterate through pillars (Column B onwards)
                    for ($i = 1; $i < count($headers); $i++) {
                        $program = trim($headers[$i] ?? '');
                        if (empty($program)) continue;

                        $realisasiRaw = $row[$i] ?? 0;
                        
                        // Handle percentage string/decimal
                        if (is_string($realisasiRaw) && str_contains($realisasiRaw, '%')) {
                            $realisasi = (double) str_replace(['%', ','], ['', '.'], $realisasiRaw);
                        } else {
                            $realisasi = (double) $realisasiRaw;
                            // If user input 0.75 thinking it's 75%, but the frontend expects 75.0, 
                            // we should check. Usually SimpleXLSX handles numbers.
                            // If it's less than 1 (except 0), it might be a ratio.
                            if ($realisasi > 0 && $realisasi <= 1) {
                                $realisasi *= 100;
                            }
                        }

                        // Update or Create
                        CapaianRenstra::updateOrCreate(
                            [
                                'tahun'     => (int) $tahun,
                                'program'   => $program,
                                'indikator' => 'Rata-rata Capaian Strategy' // Default indicator for matrix
                            ],
                            [
                                'pic'       => 'LPM', // Default PIC for matrix import
                                'target'    => 100,  // Target default 100%
                                'realisasi' => round($realisasi, 2)
                            ]
                        );
                        $importedCount++;
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => "Data Matrix Renstra ($importedCount entri) berhasil disinkronisasi."
                ]);
            } else {
                $error = (strtolower($extension) === 'xlsx') ? \App\Shuchkin\SimpleXLSX::parseError() : \App\Shuchkin\SimpleXLS::parseError();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membaca file Excel: ' . $error
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program'   => 'nullable|string|max:255',
            'indikator' => 'required|string',
            'pic'       => 'nullable|string',
            'target'    => 'required|numeric',
            'realisasi' => 'required|numeric',
            'tahun'     => 'required|integer'
        ]);

        CapaianRenstra::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Renstra berhasil ditambahkan.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'program'   => 'nullable|string|max:255',
            'indikator' => 'required|string',
            'pic'       => 'nullable|string',
            'target'    => 'required|numeric',
            'realisasi' => 'required|numeric',
            'tahun'     => 'required|integer'
        ]);

        $renstra = CapaianRenstra::findOrFail($id);
        $renstra->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Renstra berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $renstra = CapaianRenstra::findOrFail($id);
        $renstra->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Renstra berhasil dihapus.'
        ]);
    }

    public function getIndicatorStats(Request $request)
    {
        $indikator = $request->query('indikator');
        if (!$indikator) return response()->json(['success' => false, 'message' => 'Indikator required']);

        $stats = CapaianRenstra::where('indikator', $indikator)
            ->orderBy('tahun', 'asc')
            ->get(['tahun', 'target', 'realisasi']);

        return response()->json([
            'success' => true,
            'data'    => $stats
        ]);
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'data' => 'required|array',
            'data.*.id' => 'required|integer',
            'data.*.indikator' => 'nullable|string|max:255',
            'data.*.pic' => 'nullable|string|max:255',
            'data.*.target' => 'nullable|numeric',
            'data.*.realisasi' => 'nullable|numeric',
        ]);

        $rows = $request->input('data');

        foreach ($rows as $row) {
            $renstra = CapaianRenstra::find($row['id']);
            if ($renstra) {
                $renstra->update([
                    'indikator' => $row['indikator'] ?? $renstra->indikator,
                    'pic'       => $row['pic'] ?? $renstra->pic,
                    'target'    => $row['target'] ?? $renstra->target,
                    'realisasi' => $row['realisasi'] ?? $renstra->realisasi,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Renstra berhasil diperbarui secara massal.'
        ]);
    }

    public function truncate()
    {
        CapaianRenstra::truncate();
        return response()->json([
            'success' => true,
            'message' => 'Data Renstra berhasil dikosongkan.'
        ]);
    }

    public function downloadTemplate()
    {
        $headers = [
            'Tahun',
            'I. Pengembangan Sistem Pengelolaan berbasis SMART Campus untuk Menuju kualitas Regional',
            'II. Membangun Poltek Jambi branding melalui global networking for global partnership',
            'III. Menjadi pusat penyelenggaraan kegiatan akademik yang unggul dan berlandaskan academic excellence berstandar nasional dan internasional',
            'IV. Menjadi pusat penelitian yang unggul (research excellence) sesuai perkembangan IPTEKS yang berorientasi pada pemberdayaan masyarakat',
            'V. Kualitas sumberdaya manusia melalui manajemen berbasis kinerja',
            'VI. Kualitas manajemen aset yang integratif, efektif dan efisien melalui kebijakan resources sharing, berwawasan lingkungan dan berkelanjutan',
            'VII. Kapasitas institusi dalam pengelolaan',
            'IX. Kemandirian keuangan dengan pengelolaan yang akuntabel dan transparan, efektif, dan efisien sesuai standar yang berlaku'
        ];

        $rows = [
            ['2021', '51.00%', '45.93%', '34.14%', '40.67%', '27.27%', '66.67%', '29.88%', '60.00%'],
            ['2022', '75.00%', '58.62%', '42.22%', '80.00%', '45.45%', '82.61%', '53.33%', '62.50%'],
            ['2023', '61.11%', '62.50%', '64.86%', '33.33%', '54.55%', '82.61%', '80.00%', '100.00%'],
            ['2024', '61.54%', '46.15%', '48.89%', '100.00%', '75.00%', '56.62%', '86.67%', '71.43%'],
            ['2025', '97.56%', '34.00%', '57.35%', '93.02%', '28.57%', '60.98%', '66.67%', '55.56%'],
            ['2026', '20.00%', '30.00%', '47.00%', '60.00%', '55.00%', '33.00%', '33.00%', '80.00%'],
            ['Rata2 Capaian', '60.86%', '', '', '', '', '', '', '', '']
        ];

        $callback = function() use ($headers, $rows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $headers);

            foreach ($rows as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'template_renstra_poljam.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
