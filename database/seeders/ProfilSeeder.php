<?php

namespace Database\Seeders;

use App\Models\Profil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profils = [
            [
                'kategori' => 'Visi & Misi',
                'judul' => 'Visi LP3M Politeknik Jambi',
                'isi_konten' => '<p>Menjadi lembaga penjaminan mutu yang terkemuka dalam mengembangkan budaya mutu di seluruh civitas akademika Politeknik Jambi.</p>',
                'slug' => 'visi-lp3m',
                'penulis' => 'Tim LP3M',
                'hits' => 0,
            ],
            [
                'kategori' => 'Visi & Misi',
                'judul' => 'Misi LP3M Politeknik Jambi',
                'isi_konten' => '<p><strong>Misi LP3M adalah:</strong></p><ol><li>Melakukan perencanaan, pelaksanaan, dan evaluasi penjaminan mutu pendidikan</li><li>Mengembangkan sistem informasi untuk mendukung pengambilan keputusan berbasis data</li><li>Melakukan audit mutu internal secara berkelanjutan</li><li>Mendampingi program studi dalam peningkatan mutu</li></ol>',
                'slug' => 'misi-lp3m',
                'penulis' => 'Tim LP3M',
                'hits' => 0,
            ],
            [
                'kategori' => 'Tugas Pokok',
                'judul' => 'Tugas Pokok dan Fungsi LP3M',
                'isi_konten' => '<p>LP3M memiliki tugas pokok melakukan penjaminan mutu internal di Politeknik Jambi dengan fokus pada:</p><ul><li>Merencanakan, mengembangkan, dan mengimplementasikan sistem penjaminan mutu</li><li>Melakukan audit mutu internal terhadap semua unit</li><li>Memberikan rekomendasi untuk peningkatan mutu</li><li>Membuat laporan penjaminan mutu berkala</li></ul>',
                'slug' => 'tugas-pokok-lp3m',
                'penulis' => 'Tim LP3M',
                'hits' => 0,
            ],
            [
                'kategori' => 'Sejarah',
                'judul' => 'Sejarah Berdirinya LP3M',
                'isi_konten' => '<p>Lembaga Perencanaan Pengembangan dan Penjaminan Mutu (LP3M) Politeknik Jambi didirikan sebagai bagian dari komitmen institusi untuk meningkatkan dan mempertahankan kualitas pendidikan. Sejak pendirian, LP3M telah bekerja sama dengan semua unit kerja untuk membangun budaya mutu yang kuat.</p>',
                'slug' => 'sejarah-lp3m',
                'penulis' => 'Tim LP3M',
                'hits' => 0,
            ],
            [
                'kategori' => 'Struktur Organisasi',
                'judul' => 'Struktur Organisasi LP3M',
                'isi_konten' => '<p>LP3M dipimpin oleh seorang Kepala Lembaga yang bertanggung jawab kepada Direktur. Struktur organisasi LP3M dirancang untuk memastikan efektivitas pelaksanaan tugas penjaminan mutu di seluruh institusi.</p>',
                'slug' => 'struktur-organisasi',
                'penulis' => 'Tim LP3M',
                'hits' => 0,
            ],
            [
                'kategori' => 'Tim Manajemen',
                'judul' => 'Tim Manajemen LP3M',
                'isi_konten' => '<p>Tim manajemen LP3M terdiri dari profesional berpengalaman di bidang penjaminan mutu pendidikan tinggi. Mereka bekerja sama untuk memberikan pelayanan terbaik dalam mendukung peningkatan mutu institusi.</p>',
                'slug' => 'tim-manajemen',
                'penulis' => 'Admin',
                'hits' => 0,
            ],
            [
                'kategori' => 'Berita',
                'judul' => 'Peluncuran Sistem Penjaminan Mutu Online',
                'isi_konten' => '<p>LP3M Politeknik Jambi telah meluncurkan sistem penjaminan mutu online untuk meningkatkan efisiensi dan transparansi dalam proses audit mutu internal. Sistem ini memungkinkan seluruh unit kerja untuk melaporkan pencapaian dengan lebih mudah dan real-time.</p>',
                'slug' => 'sistem-penjaminan-mutu-online',
                'penulis' => 'LP3M',
                'hits' => 124,
            ],
            [
                'kategori' => 'Kegiatan',
                'judul' => 'Workshop Penyusunan Dokumen SPMI',
                'isi_konten' => '<p>LP3M mengadakan workshop penyusunan dokumen Sistem Penjaminan Mutu Internal (SPMI) untuk semua program studi. Workshop ini bertujuan meningkatkan pemahaman tentang standar mutu dan cara implementasinya di tingkat program studi.</p>',
                'slug' => 'workshop-spmi',
                'penulis' => 'Tim LP3M',
                'hits' => 87,
            ],
            [
                'kategori' => 'Profil',
                'judul' => 'Program Studi di Politeknik Jambi',
                'isi_konten' => '<p>Politeknik Jambi memiliki beberapa program studi unggulan yang terus berkembang dengan standar kualitas tinggi. Setiap program studi memiliki komitmen untuk memberikan pendidikan terbaik kepada mahasiswa.</p>',
                'slug' => 'program-studi',
                'penulis' => 'Akademik',
                'hits' => 234,
            ],
        ];

        foreach ($profils as $profil) {
            Profil::create($profil);
        }

        $this->command->info('Data profil berhasil ditambahkan!');
    }
}
