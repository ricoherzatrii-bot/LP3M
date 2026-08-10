<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PilarRenstra;

class PilarRenstraSeeder extends Seeder
{
    public function run(): void
    {
        $pilars = [
            [
                'kode' => 'I',
                'judul' => 'Pengembangan Sistem Pengelolaan berbasis SMART Campus untuk Menuju kwalitas Regional',
                'warna' => '#1e3a8a',
                'gradient_class' => 'bg-gradient-to-br from-[#1e3a8a] to-blue-900',
                'urutan' => 1,
            ],
            [
                'kode' => 'II',
                'judul' => 'Membangun Poltek Jambi branding melalui global networking for global partnership',
                'warna' => '#16a085',
                'gradient_class' => 'bg-gradient-to-br from-[#16a085] to-emerald-800',
                'urutan' => 2,
            ],
            [
                'kode' => 'III',
                'judul' => 'Menjadi pusat penyelenggaraan kegiatan akademik yang unggul dan berlandaskan academic exellence berstandar nasional dan internasional',
                'warna' => '#e91e63',
                'gradient_class' => 'bg-gradient-to-br from-[#e91e63] to-pink-800',
                'urutan' => 3,
            ],
            [
                'kode' => 'IV',
                'judul' => 'Menjadi pusat penelitian yang unggul (research exellence) sesuai perkembangan IPTEKS yang berorientasi pada pemberdayaan masyarakat.',
                'warna' => '#e67e22',
                'gradient_class' => 'bg-gradient-to-br from-[#e67e22] to-orange-700',
                'urutan' => 4,
            ],
            [
                'kode' => 'V',
                'judul' => 'Kualitas sumberdaya manusia melalui manajemen berbasis kinerja',
                'warna' => '#f1c40f',
                'gradient_class' => 'bg-gradient-to-br from-[#f1c40f] to-amber-600',
                'urutan' => 5,
            ],
            [
                'kode' => 'VI',
                'judul' => 'Kualitas manajemen aset yang integratif, efektif dan efisien melalui kebijakan resources sharing, berwawasan lingkungandan berkelanjutan',
                'warna' => '#2ecc71',
                'gradient_class' => 'bg-gradient-to-br from-[#2ecc71] to-green-700',
                'urutan' => 6,
            ],
            [
                'kode' => 'VII',
                'judul' => 'Kapasitas institusi dalam pengelolaan',
                'warna' => '#8e44ad',
                'gradient_class' => 'bg-gradient-to-br from-[#8e44ad] to-purple-900',
                'urutan' => 7,
            ],
            [
                'kode' => 'VIII',
                'judul' => 'Kemandirian keuangan dengan pengelolaan yang akuntabel dan transparan, efektif, dan efisien sesuai standar yang berlaku.',
                'warna' => '#3498db',
                'gradient_class' => 'bg-gradient-to-br from-[#3498db] to-blue-600',
                'urutan' => 8,
            ],
        ];

        foreach ($pilars as $pilar) {
            PilarRenstra::updateOrCreate(
                ['kode' => $pilar['kode']],
                $pilar
            );
        }
    }
}
