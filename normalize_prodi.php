<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$mapping = [
    'Akuntansi Perpajakan' => 'D4 Akuntansi Perpajakan',
    'D4 Akuntasi Perpajakan' => 'D4 Akuntansi Perpajakan',
    'Bisnis Digital' => 'D4 Bisnis Digital',
    'D3 Elektronika' => 'D3 Teknik Elektronika',
    'Teknik Elektronika' => 'D3 Teknik Elektronika',
    'D3 Listrik' => 'D3 Teknik Listrik',
    'Teknik Listrik' => 'D3 Teknik Listrik',
    'D3 Teknik Mesin' => 'D3 Teknik Mesin',
    'Teknik Mesin' => 'D3 Teknik Mesin',
    'D4 TRLOG' => 'D4 Teknologi Rekayasa Logistik',
    'Teknologi Rekayasa Logistik' => 'D4 Teknologi Rekayasa Logistik',
    'D4 TRPAB' => 'D4 Teknologi Rekayasa Pemeliharaan Alat Berat',
    'Teknologi Rekayasa Pemeliharaan Alat Berat' => 'D4 Teknologi Rekayasa Pemeliharaan Alat Berat',
    'D4 Teknologi Rekayasa Perangkat Lunak' => 'D4 Teknologi Rekayasa Perangkat Lunak (TRPL)',
    'Teknologi Rekayasa Perangkat Lunak' => 'D4 Teknologi Rekayasa Perangkat Lunak (TRPL)',
    'IT' => 'D4 Teknologi Rekayasa Perangkat Lunak (TRPL)',
    'Tambang' => 'D3 Teknik Pertambangan',
];

$updatedKuesioner = 0;
$updatedAkreditasi = 0;
$updatedProdis = 0;

foreach ($mapping as $old => $new) {
    if ($old === $new) continue;
    
    // Update Kuesioner (prodi column)
    $q1 = \App\Models\KuesionerDosenKaryawan::where('prodi', $old)->update(['prodi' => $new]);
    $updatedKuesioner += $q1;
    
    // Update Akreditasi (judul column)
    // Wait, akreditasi table has exact prodi names in 'judul' for kategori 'Akreditasi'
    $q2 = \App\Models\Akreditasi::where('kategori', 'Akreditasi')->where('judul', $old)->update(['judul' => $new]);
    $updatedAkreditasi += $q2;
    
    // Update Prodis (nama column)
    $q3 = \App\Models\Prodi::where('nama', $old)->update(['nama' => $new]);
    $updatedProdis += $q3;
}

echo "Standardization complete.\n";
echo "Updated Kuesioner rows: $updatedKuesioner\n";
echo "Updated Akreditasi rows: $updatedAkreditasi\n";
echo "Updated Prodis rows: $updatedProdis\n";

// Deduplicate Prodis table if necessary
$prodis = \App\Models\Prodi::all()->groupBy('nama');
$deletedProdis = 0;
foreach ($prodis as $nama => $group) {
    if ($group->count() > 1) {
        $first = $group->first();
        // Delete the rest
        foreach ($group as $idx => $item) {
            if ($item->id !== $first->id) {
                $item->delete();
                $deletedProdis++;
            }
        }
    }
}
echo "Cleaned up $deletedProdis duplicate records from prodis table.\n";
