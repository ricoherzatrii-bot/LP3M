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

        $selectedYear = $request->get('tahun', $availableYears->first());

        $data = CapaianRenstra::where('tahun', $selectedYear)
            ->orderBy('program', 'asc')
            ->get()
            ->groupBy('program');

        // Yearly trend for line chart
        $yearlyStats = CapaianRenstra::selectRaw('tahun, ROUND(AVG(realisasi),1) as avg_realisasi, ROUND(AVG(target),1) as avg_target, COUNT(*) as total_indikator')
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc')
            ->get();

        // All-year program stats for horizontal multi-bar chart
        $allProgramStats = CapaianRenstra::selectRaw('program, tahun, ROUND(AVG(realisasi),2) as avg_realisasi')
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

        return view('pages.renstra', compact('data', 'availableYears', 'selectedYear', 'yearlyStats', 'allProgramStats', 'indicators'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            if ($xlsx = SimpleXLSX::parse($request->file('file')->path())) {
                $rows = $xlsx->rows();
                
                // Skip first 2 rows (Instruction row and Header row)
                unset($rows[0], $rows[1]);

                $currentProgram = null;

                foreach ($rows as $row) {
                    // Column mapping: A[0]: Program, B[1]: Indikator, C[2]: PIC, D[3]: Target, E[4]: Realisasi, F[5]: Tahun
                    
                    // Skip rows where Indikator is empty or just whitespace
                    $indikator = trim($row[1] ?? '');
                    
                    // Propagation logic for Program
                    $program = trim($row[0] ?? '');
                    if (!empty($program)) {
                        $currentProgram = $program;
                    }

                    // If both program and indicator are empty, it's likely an empty row between groups
                    if (empty($indikator) && empty($program)) continue;
                    
                    // If it's a section header (program name but no indicator), just update currentProgram
                    if (empty($indikator) && !empty($program)) continue;

                    // Validate that we have an indicator to save
                    if (empty($indikator)) continue;

                    CapaianRenstra::create([
                        'program'   => $currentProgram,
                        'indikator' => $indikator,
                        'pic'       => trim($row[2] ?? null),
                        'target'    => (double) str_replace(',', '.', $row[3] ?? 0),
                        'realisasi' => (double) str_replace(',', '.', $row[4] ?? 0),
                        'tahun'     => (int) ($row[5] ?? date('Y'))
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Data Capaian Renstra berhasil diimpor dengan format 6 kolom.'
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
        $rows = $request->input('data');
        if (!is_array($rows)) return response()->json(['success' => false, 'message' => 'Invalid data format']);

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
            'Program (Renstra)',
            'Indikator Kinerja',
            'PIC (Contoh: WD 1)',
            'Target (%)',
            'Realisasi (%)',
            'Tahun (YYYY)'
        ];

        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            
            // Add a sample row for guidance
            fputcsv($file, [
                'R 1: Kesiapan Kerja Lulusan',
                'Tingkat kepuasan pengguna lulusan',
                'WD 3',
                '80',
                '75',
                '2026'
            ]);
            
            // Add another row to show program omission (grouping)
            fputcsv($file, [
                '',
                'Jumlah Lulusan Bekerja Tingkat Nasional',
                'WD 3',
                '70',
                '68',
                '2026'
            ]);

            fclose($file);
        };

        return response()->streamDownload($callback, 'template_renstra_poljam.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
