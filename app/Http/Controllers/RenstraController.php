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

    public function publicIndex()
    {
        $data = CapaianRenstra::orderBy('program', 'asc')->orderBy('tahun', 'asc')->get()->groupBy('program');
        return view('pages.renstra', compact('data'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        if ($xlsx = SimpleXLSX::parse($request->file('file')->path())) {
            $rows = $xlsx->rows();
            
            // Skip first 2 rows (Instruction row and Header row)
            unset($rows[0], $rows[1]);

            $currentProgram = null;

            foreach ($rows as $row) {
                // Column mapping: A[0]: Program, B[1]: Indikator, C[2]: PIC, D[3]: Target, E[4]: Realisasi, F[5]: Tahun
                
                // Skip rows where Indikator is empty or just whitespace
                $indikator = trim($row[1] ?? '');
                if (empty($indikator)) continue;

                // Propagation logic for Program
                $program = trim($row[0] ?? '');
                if (!empty($program)) {
                    $currentProgram = $program;
                }

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
    }

    public function truncate()
    {
        CapaianRenstra::truncate();
        return response()->json([
            'success' => true,
            'message' => 'Data Renstra berhasil dikosongkan.'
        ]);
    }
}
