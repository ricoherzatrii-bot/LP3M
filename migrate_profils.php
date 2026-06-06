<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Profil;

$profilSlugs = [
    'Visi Dan Misi' => 'visi-dan-misi',
    'Moto Dan Janji Layanan' => 'moto-dan-janji-layanan',
    'Kebijakan Mutu POLJAM' => 'kebijakan-mutu-poljam',
    'Sasaran Mutu POLJAM' => 'sasaran-mutu-poljam',
    'Standar Mutu POLJAM' => 'standar-mutu-poljam',
    'Sasaran Mutu LPM' => 'sasaran-mutu-lpm',
    'Struktur Organisasi' => 'struktur-organisasi',
    'Job Deskripsi' => 'job-deskripsi',
    'Standar Waktu Pelayanan' => 'standar-waktu-pelayanan',
];

foreach ($profilSlugs as $title => $slug) {
    Profil::where('slug', $slug)->update(['kategori' => $title]);
    echo "Updated $slug to kategori: $title\n";
}
