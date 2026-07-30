<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Akreditasi;
use App\Models\CapaianRenstra;
use App\Models\Kuesioner;

echo "=== Akreditasi (kategori=Akreditasi) ===" . PHP_EOL;
$items = Akreditasi::where('kategori', 'Akreditasi')->get(['id','judul','peringkat']);
foreach ($items as $i) {
    echo "ID={$i->id} | judul={$i->judul} | peringkat={$i->peringkat}" . PHP_EOL;
}

echo PHP_EOL . "=== CapaianRenstra Trend ===" . PHP_EOL;
$renstra = CapaianRenstra::selectRaw('tahun, ROUND(AVG(realisasi),1) as avg_r, ROUND(AVG(target),1) as avg_t')
    ->groupBy('tahun')->orderBy('tahun')->get();
foreach ($renstra as $r) {
    echo "tahun={$r->tahun} | realisasi={$r->avg_r} | target={$r->avg_t}" . PHP_EOL;
}

echo PHP_EOL . "=== Kuesioner Details ===" . PHP_EOL;
$kqd = \App\Models\KuesionerDosenKaryawan::selectRaw('kategori, SUM(sangat_setuju) as sangat_setuju, SUM(setuju) as setuju, SUM(cukup_setuju) as cukup_setuju, SUM(tidak_setuju) as tidak_setuju, SUM(sangat_tidak_setuju) as sangat_tidak_setuju')->groupBy('kategori')->get();
foreach ($kqd as $k) {
    echo "kategori={$k->kategori} | SS={$k->sangat_setuju} | S={$k->setuju} | CS={$k->cukup_setuju} | TS={$k->tidak_setuju} | STS={$k->sangat_tidak_setuju}" . PHP_EOL;
}
