-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Bulan Mei 2026 pada 17.21
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lp3m_poljam`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akreditasis`
--

CREATE TABLE `akreditasis` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` enum('Akreditasi','Dokumen Akreditasi') NOT NULL,
  `peringkat` varchar(50) DEFAULT NULL,
  `tanggal_kedaluwarsa` date DEFAULT NULL,
  `file_dokumen` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akreditasis`
--

INSERT INTO `akreditasis` (`id`, `judul`, `kategori`, `peringkat`, `tanggal_kedaluwarsa`, `file_dokumen`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Teknologi Rekayasa Perangkat Lunak', 'Akreditasi', 'Baik Sekali', '2030-03-24', NULL, 'trpl-akreditasi', '2026-05-04 04:42:40', '2026-05-04 04:42:40'),
(2, 'Bisnis Digital', 'Akreditasi', 'Baik', '2029-11-28', NULL, 'bisnis-digital-akreditasi', '2026-05-04 04:42:40', '2026-05-04 04:42:40'),
(3, 'Akuntansi Perpajakan', 'Akreditasi', 'Baik', '2029-08-31', NULL, 'akuntansi-perpajakan-akreditasi', '2026-05-04 04:42:40', '2026-05-04 04:42:40'),
(4, 'Teknik Listrik', 'Akreditasi', 'Baik Sekali', '2029-08-20', NULL, 'teknik-listrik-akreditasi', '2026-05-04 04:42:40', '2026-05-04 04:42:40'),
(5, 'Teknik Elektronika', 'Akreditasi', 'Baik Sekali', '2029-08-20', NULL, 'teknik-elektronika-akreditasi', '2026-05-04 04:42:40', '2026-05-04 04:42:40'),
(6, 'Teknik Mesin', 'Akreditasi', 'Baik Sekali', '2027-12-20', NULL, 'teknik-mesin-akreditasi', '2026-05-04 04:42:40', '2026-05-04 04:42:40'),
(7, 'Teknologi Rekayasa Logistik', 'Akreditasi', 'Baik', '2026-07-11', NULL, 'tr-logistik-akreditasi', '2026-05-04 04:42:40', '2026-05-04 04:42:40'),
(8, 'Pedoman Akreditasi PT', 'Dokumen Akreditasi', NULL, NULL, 'pedoman_pt.pdf', 'pedoman-pt', '2026-05-04 04:42:40', '2026-05-04 04:42:40'),
(9, 'Pedoman Akreditasi LAMTEKNIK', 'Dokumen Akreditasi', NULL, NULL, 'pedoman_lamteknik.pdf', 'pedoman-lamteknik', '2026-05-04 04:42:40', '2026-05-04 04:42:40'),
(10, 'Pedoman Akreditasi LAMINFOKOM', 'Dokumen Akreditasi', NULL, NULL, 'pedoman_laminfokom.pdf', 'pedoman-laminfokom', '2026-05-04 04:42:40', '2026-05-04 04:42:40'),
(11, 'Pedoman Akreditasi LAMEMBA', 'Dokumen Akreditasi', NULL, NULL, 'pedoman_lamemba.pdf', 'pedoman-lamemba', '2026-05-04 04:42:40', '2026-05-04 04:42:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikels`
--

CREATE TABLE `artikels` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` enum('Berita','Kegiatan','Profil') NOT NULL,
  `isi_konten` longtext NOT NULL,
  `gambar` varchar(255) DEFAULT 'default.jpg',
  `slug` varchar(255) DEFAULT NULL,
  `tanggal_arsip` date DEFAULT NULL,
  `penulis` varchar(100) DEFAULT 'Admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `artikels`
--

INSERT INTO `artikels` (`id`, `judul`, `kategori`, `isi_konten`, `gambar`, `slug`, `tanggal_arsip`, `penulis`, `created_at`) VALUES
(1, 'Pelaksanaan Audit Mutu Internal 2024', 'Berita', '<p>LP3M Politeknik Jambi melaksanakan Audit Mutu Internal...</p>', 'default.jpg', 'pelaksanaan-ami-2024', '2024-05-01', 'Admin', '2026-05-04 04:01:26'),
(2, 'Workshop Penyusunan Standar SPMI', 'Kegiatan', '<p>Kegiatan workshop ini diikuti oleh seluruh unit kerja...</p>', 'default.jpg', 'workshop-spmi', '2024-04-15', 'Admin', '2026-05-04 04:01:26'),
(3, 'Sejarah Singkat LP3M', 'Profil', '<p>Lembaga Penjaminan Mutu didirikan pada tahun...</p>', 'default.jpg', 'sejarah-lp3m', '2023-10-10', 'Admin', '2026-05-04 04:01:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `beritas`
--

CREATE TABLE `beritas` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `konten` longtext NOT NULL,
  `gambar_fitur` varchar(255) DEFAULT NULL,
  `hits` int(11) DEFAULT 0,
  `publish_at` datetime DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `beritas`
--

INSERT INTO `beritas` (`id`, `judul`, `slug`, `konten`, `gambar_fitur`, `hits`, `publish_at`, `created_at`) VALUES
(1, 'Webinar: Luka Yang Tidak Kelihatan', 'webinar-luka-tidak-kelihatan', 'LP3M menyelenggarakan webinar psychological well-being bertajuk \"Luka Yang Tidak Kelihatan\" bersama Politeknik Ibrahim Sultan...', 'webinar_psikologi.jpg', 1540, '2026-05-04 14:23:23', '2026-05-04 07:23:23'),
(2, 'Sosialisasi E-SPMI Politeknik Jambi', 'sosialisasi-e-spmi-poljam', 'Kegiatan ini bertujuan memperkenalkan platform digital untuk mempermudah audit mutu internal di lingkungan kampus...', 'e_spmi_news.jpg', 890, '2026-05-04 14:23:23', '2026-05-04 07:23:23'),
(3, 'Peluncuran Aplikasi UMKM-HUB', 'peluncuran-umkm-hub', 'LP3M mendukung pengembangan aplikasi UMKM-HUB untuk membantu manajemen bisnis lokal di Jambi...', 'umkm_hub.jpg', 1200, '2026-05-04 14:23:23', '2026-05-04 07:23:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `capaians`
--

CREATE TABLE `capaians` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` enum('Renop','Capaian Renstra','Kepuasan Mahasiswa','Kepuasan Dosen Dan Tendik') NOT NULL,
  `sub_kategori` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `persentase_capaian` decimal(5,2) DEFAULT NULL,
  `file_dokumen` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `hits` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `capaians`
--

INSERT INTO `capaians` (`id`, `judul`, `kategori`, `sub_kategori`, `deskripsi`, `persentase_capaian`, `file_dokumen`, `slug`, `hits`, `created_at`, `updated_at`) VALUES
(1, 'Rencana Operasional Politeknik Jambi', 'Renop', NULL, NULL, NULL, NULL, 'renop', 0, '2026-05-04 04:50:37', '2026-05-04 04:50:37'),
(2, 'Pengembangan Sistem Pengelolaan Berbasis SMART Campus', 'Capaian Renstra', NULL, NULL, 69.24, NULL, 'capaian-renstra-pilar-1', 0, '2026-05-04 04:50:37', '2026-05-04 04:50:37'),
(3, 'Hasil Survei Kepuasan Mahasiswa Poljam 2020/2021', 'Kepuasan Mahasiswa', 'Poljam 2020/2021', NULL, NULL, NULL, 'kepuasan-mahasiswa-poljam-2020-2021', 0, '2026-05-04 04:50:37', '2026-05-04 04:50:37'),
(4, 'Hasil Survei Kepuasan Mahasiswa Per Prodi 2020/2021', 'Kepuasan Mahasiswa', 'Prodi 2020/2021', NULL, NULL, NULL, 'kepuasan-mahasiswa-prodi-2020-2021', 0, '2026-05-04 04:50:37', '2026-05-04 04:50:37'),
(5, 'Hasil Survei Kepuasan Dosen dan Tenaga Kependidikan', 'Kepuasan Dosen Dan Tendik', NULL, NULL, NULL, NULL, 'kepuasan-dosen-tendik', 0, '2026-05-04 04:50:37', '2026-05-04 04:50:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri_albums`
--

CREATE TABLE `galeri_albums` (
  `id` int(11) NOT NULL,
  `nama_album` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `sampul_foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `galeri_albums`
--

INSERT INTO `galeri_albums` (`id`, `nama_album`, `slug`, `sampul_foto`, `created_at`) VALUES
(1, 'Lokakarya Audit Mutu Internal', 'lokakarya-audit-mutu-internal', 'sampul_lokakarya.jpg', '2026-05-04 07:10:54'),
(2, 'Rapat Koordinasi Pemilihan Ketua AMI 2019-2020 Genap', 'rapat-koordinasi-ami-2019-2020', 'sampul_rapat.jpg', '2026-05-04 07:10:54'),
(3, 'Kegiatan Audit Mutu Internal Wakil Direktur I', 'kegiatan-ami-wadir-1', 'sampul_wadir.jpg', '2026-05-04 07:10:54'),
(4, 'AMI 2023', 'ami-2023', 'sampul_ami_2023.jpg', '2026-05-04 07:10:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri_fotos`
--

CREATE TABLE `galeri_fotos` (
  `id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `galeri_fotos`
--

INSERT INTO `galeri_fotos` (`id`, `album_id`, `file_path`, `keterangan`, `created_at`) VALUES
(1, 4, 'foto_ami_1.jpg', 'Suasana rapat AMI 2023', '2026-05-04 07:11:11'),
(2, 4, 'foto_ami_2.jpg', 'Dokumentasi kegiatan AMI', '2026-05-04 07:11:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `home_counters`
--

CREATE TABLE `home_counters` (
  `id` int(11) NOT NULL,
  `nama_label` varchar(100) NOT NULL,
  `jumlah_angka` int(11) NOT NULL,
  `ikon` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `home_counters`
--

INSERT INTO `home_counters` (`id`, `nama_label`, `jumlah_angka`, `ikon`, `created_at`) VALUES
(1, 'Program Studi', 8, 'fa-university', '2026-05-04 07:23:32'),
(2, 'Dokumen Mutu', 124, 'fa-file-alt', '2026-05-04 07:23:32'),
(3, 'Audit Internal', 15, 'fa-check-circle', '2026-05-04 07:23:32'),
(4, 'Responden Kuesioner', 3673, 'fa-users', '2026-05-04 07:23:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kuesioners`
--

CREATE TABLE `kuesioners` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` enum('Dosen & Karyawan','Mahasiswa') NOT NULL,
  `prodi` varchar(100) DEFAULT NULL,
  `tahun_akademik` varchar(20) DEFAULT '2023/2024',
  `isi_artikel` text DEFAULT NULL,
  `link_embed_grafik` text DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `hits` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kuesioners`
--

INSERT INTO `kuesioners` (`id`, `judul`, `kategori`, `prodi`, `tahun_akademik`, `isi_artikel`, `link_embed_grafik`, `slug`, `hits`, `created_at`, `updated_at`) VALUES
(1, 'Kuesioner Dosen & Karyawan', 'Dosen & Karyawan', NULL, '2023/2024', NULL, NULL, 'kuesioner-dosen-karyawan', 1030, '2026-05-04 07:01:24', '2026-05-04 07:01:24'),
(2, 'Kuisioner Mahasiswa - D3 Teknik Elektronika', 'Mahasiswa', 'D3 - Teknik Elektronika', '2023/2024', NULL, NULL, 'kuisioner-d3-teknik-elektronika', 3673, '2026-05-04 07:01:24', '2026-05-04 07:01:24'),
(3, 'Kuisioner Mahasiswa - D3 Teknik Mesin', 'Mahasiswa', 'D3 - Teknik Mesin', '2023/2024', NULL, NULL, 'kuisioner-d3-teknik-mesin', 0, '2026-05-04 07:01:24', '2026-05-04 07:01:24'),
(4, 'Kuisioner Mahasiswa - D3 Teknik Listrik', 'Mahasiswa', 'D3 - Teknik Listrik', '2023/2024', NULL, NULL, 'kuisioner-d3-teknik-listrik', 0, '2026-05-04 07:01:24', '2026-05-04 07:01:24'),
(5, 'Kuisioner Mahasiswa - D4 Akuntansi Perpajakan', 'Mahasiswa', 'D4 - Akuntansi Perpajakan', '2023/2024', NULL, NULL, 'kuisioner-d4-akuntansi-perpajakan', 0, '2026-05-04 07:01:24', '2026-05-04 07:01:24'),
(6, 'Kuisioner Mahasiswa - D4 Teknologi Rekayasa Perangkat Lunak', 'Mahasiswa', 'D4 - TRPL', '2023/2024', NULL, NULL, 'kuisioner-d4-trpl', 0, '2026-05-04 07:01:24', '2026-05-04 07:01:24'),
(7, 'Kuisioner Mahasiswa - D4 Bisnis Digital', 'Mahasiswa', 'D4 - Bisnis Digital', '2023/2024', NULL, NULL, 'kuisioner-d4-bisnis-digital', 0, '2026-05-04 07:01:24', '2026-05-04 07:01:24'),
(8, 'Kuisioner Mahasiswa - D4 TRAB', 'Mahasiswa', 'D4 - TRAB', '2023/2024', NULL, NULL, 'kuisioner-d4-trab', 0, '2026-05-04 07:01:24', '2026-05-04 07:01:24'),
(9, 'Kuisioner Mahasiswa - D4 TRLOG', 'Mahasiswa', 'D4 - TRLOG', '2023/2024', NULL, NULL, 'kuisioner-d4-trlog', 0, '2026-05-04 07:01:24', '2026-05-04 07:01:24'),
(10, 'Kuisioner Mahasiswa - All Pages', 'Mahasiswa', 'Semua Prodi', '2023/2024', NULL, NULL, 'kuisioner-mahasiswa-all-pages', 0, '2026-05-04 07:01:24', '2026-05-04 07:01:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `nama_aplikasi` varchar(100) NOT NULL,
  `url_link` varchar(255) NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `links`
--

INSERT INTO `links` (`id`, `nama_aplikasi`, `url_link`, `logo_path`, `urutan`, `created_at`) VALUES
(1, 'SIAK - Sistem Akreditasi', 'https://siak.politeknikjambi.ac.id', 'logo_siak.png', 1, '2026-05-04 07:23:52'),
(2, 'E-Monev Poljam', 'https://emonev.politeknikjambi.ac.id', 'logo_emonev.png', 2, '2026-05-04 07:23:52'),
(3, 'Siakad Poljam', 'https://siakad.politeknikjambi.ac.id', 'logo_siakad.png', 3, '2026-05-04 07:23:52'),
(4, 'Portal Politeknik Jambi', 'https://politeknikjambi.ac.id', 'logo_poljam.png', 4, '2026-05-04 07:23:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumumans`
--

CREATE TABLE `pengumumans` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `file_lampiran` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumumans`
--

INSERT INTO `pengumumans` (`id`, `judul`, `file_lampiran`, `is_active`, `created_at`) VALUES
(1, 'Jadwal Audit Mutu Internal Semester Genap 2025/2026', 'jadwal_ami_genap.pdf', 1, '2026-05-04 07:23:41'),
(2, 'Pedoman Penyusunan Laporan Evaluasi Diri (LED) 2026', 'pedoman_led_2026.pdf', 1, '2026-05-04 07:23:41'),
(3, 'Instruksi Kerja Kuesioner Kepuasan Mahasiswa', 'ik_kuesioner.pdf', 1, '2026-05-04 07:23:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profils`
--

CREATE TABLE `profils` (
  `id` int(11) NOT NULL,
  `kategori` varchar(100) DEFAULT 'Profil',
  `judul` varchar(255) NOT NULL,
  `isi_konten` longtext NOT NULL,
  `slug` varchar(255) NOT NULL,
  `hits` int(11) DEFAULT 0,
  `penulis` varchar(100) DEFAULT 'Admin',
  `tanggal_arsip` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profils`
--

INSERT INTO `profils` (`id`, `kategori`, `judul`, `isi_konten`, `slug`, `hits`, `penulis`, `tanggal_arsip`, `created_at`) VALUES
(1, 'Profil', 'Visi Dan Misi', '<h3>POLITEKNIK JAMBI</h3><p><strong>VISI :</strong></p><p>Menjadi Politeknik yang unggul di bidang inovasi Rekayasa Terapan di Tingkat Sumatera tahun 2025</p><p><strong>MISI :</strong></p><p>Sebagai upaya untuk mewujudkan visi tersebut di atas, maka Misi Politeknik Jambi adalah:</p><ol><li>Menyelenggarakan pendidikan profesional agar dapat menghasilkan lulusan yang unggul di bidang teknologi inovasi berbasis kompetensi dan berakhlak mulia.</li><li>Menyelenggarakan program penelitian dan pengabdian kepada masyarakat dan mempublikasikan hasil pengembangan teknologi inovasi yang berbasis pada kebutuhan masyarakat, pemerintah dan dunia industri.</li><li>Membangun kerjasama dengan pemerintah dan dunia industri sebagai mitra Politeknik Jambi, dengan mengoptimalkan sumber daya yang ada dalam mencapai mutu dan kemandirian melalui kegiatan pendidikan, penelitian, dan pengabdian kepada masyarakat.</li></ol><br><h3>LP3M</h3><p><strong>VISI :</strong></p><p>Terwujudnya LP3M sebagai lembaga unggul dalam pengelolaan sistem penjaminan mutu pendidikan yang berkarakter dalam kebersamaan pada tahun 2025</p><p><strong>MISI :</strong></p><ol><li>Mengelola Sistem Penjaminan Mutu Internal (SPMI) untuk menjamin kualitas kinerja di bidang pendidikan akademik dan vokasi.</li><li>Mengelola Sistem Penjaminan Mutu Internal (SPMI) untuk menjamin kualitas kinerja di bidang penelitian dan pengabdian kepada masyarakat.</li><li>Mengelola Sistem Penjaminan Mutu Internal (SPMI) untuk menjamin tatakelola dan kinerja institusi serta unit kerja dibawahnya secara adil, jujur, amanah, religius dan akuntabel dalam pelaksanaannya.</li></ol>', 'visi-dan-misi', 3250, 'Admin', '2023-02-03', '2026-05-04 03:24:23'),
(2, 'Profil', 'Moto Dan Janji Layanan', '<p>Content sedang diproses, silahkan kunjungi beberapa saat lagi...</p>', 'moto-dan-janji-layanan', 788, 'Admin', '2023-02-03', '2026-05-04 03:24:23'),
(3, 'Profil', 'Kebijakan Mutu POLJAM', '<h3>KEBIJAKAN SPMI POLITEKNIK JAMBI</h3><p>Sistem Penjaminan Mutu Pendidikan Tinggi terdiri atas: Sistem Penjaminan Mutu Internal (SPMI); dan Sistem Penjaminan Mutu Eksternal (SPME). SPMI direncanakan, dilaksanakan, dievaluasi, dikendalikan, dan dikembangkan oleh perguruan tinggi. SPME direncanakan, dilaksanakan, dievaluasi, dikendalikan, dan dikembangkan oleh BAN-PT dan /atau Lembaga Audit Mutu (LAM) melalui akreditasi sesuai dengan kewenangan masing-masing. Luaran penerapan SPMI oleh perguruan tinggi digunakan oleh BAN-PT atau LAM untuk penetapan status dan peringkat terakreditasi perguruan tinggi atau program studi.</p><p>[Image: Kebijakan SPMI Politeknik Jambi 2019]</p>', 'kebijakan-mutu-poljam', 655, 'Admin', '2023-02-03', '2026-05-04 03:24:23'),
(4, 'Profil', 'Sasaran Mutu POLJAM', '<p>Content sedang diproses, silahkan kunjungi beberapa saat lagi...</p>', 'sasaran-mutu-poljam', 888, 'Admin', '2023-02-04', '2026-05-04 03:24:23'),
(5, 'Profil', 'Standar Mutu POLJAM', '<h3>STANDAR SPMI POLITEKNIK JAMBI</h3><p>Dalam rangka memenuhi pencapaian Visi, Misi dan Tujuan tersebut, SPMI yang diterapkan oleh Politeknik Jambi mencakup semua kegiatan pendidikan, penelitian, dan pengabdian kepada masyarakat beserta sumberdaya yang digunakannya sesuai dengan Standar Nasional Pendidikan Tinggi (SN-DIKTI) dan Standar Pendidikan Tinggi (Standar Dikti) yang ditetapkan oleh Politeknik Jambi. Penerapan SPMI diharapkan dapat secara simultan memberikan jaminan dan keyakinan kepada sivitas akademika, dan pihak-pihak yang berkepentingan (stakeholders) bahwa Politeknik Jambi akan memberikan yang terbaik sesuai dengan standar-standar yang telah ditetapkan dalam pelaksanaan Tri Dharma Pendidikan Tinggi serta pengelolaan sistem pendidikan tinggi yang diselenggarakan.\r\n\r\nStandar-standar yang ditetapkan pada Dokumen Kebijakan SPMI Politeknik Jambi ini berguna untuk:\r\n\r\nMenjamin mutu yang berkelanjutan (Continuous quality improvement),\r\nMengukur kualitas keluaran (output) dan dampak (outcome)dari penyelenggaraan sistem pendidikan di Politeknik Jambi, sehingga keberadaan Politeknik Jambi memberikan kebermanfaatan untuk lingkungan sekitar,\r\nMenjamin penyelenggaraan sistem pendidikan yang dilakukan oleh Politeknik Jambi (input-proses-output), selaras dan harus dapat menjawab kebutuhan masyarakat sekitar,\r\nMemberikan kepercayaan, kepada sivitas akademika, stakeholders, dan lingkungan sekitar terkait penyelenggaraan pendidikan yang diberikan oleh Politeknik Jambi.</p>', 'standar-mutu-poljam', 767, 'Admin', '2023-02-04', '2026-05-04 03:24:23'),
(6, 'Profil', 'Sasaran Mutu LPM', '<p>Content sedang diproses, silahkan kunjungi beberapa saat lagi...</p>', 'sasaran-mutu-lpm', 1019, 'Admin', '2023-02-04', '2026-05-04 03:24:23'),
(7, 'Profil', 'Struktur Organisasi', '<div style=\"text-align:center;\"><h3>STRUKTUR ORGANISASI</h3><p>[Image: Bagan Struktur Organisasi - Direktur, Kepala Lembaga, Kabag Penjaminan Mutu Internal/Eksternal]</p></div>', 'struktur-organisasi', 1109, 'Admin', '2023-02-04', '2026-05-04 03:24:23'),
(8, 'Profil', 'Job Deskripsi', '\r\n<h4>KEPALA BAGIAN PERENCANAAN DAN PENGEMBANGAN (Kabag. Renbang)</h4>\r\n<ol>\r\n    <li>Menyusun Rencana Induk Pengembangan Institusi</li>\r\n    <li>Menyusun dan mengembangkan Statuta</li>\r\n    <li>Menyusun Rencana Strategis Politeknik Jambi bersama-sama dengan pimpinan dan unit terkait</li>\r\n    <li>Mereview Renop berdasarkan Rencana Strategis (Renstra) Politeknik Jambi 1</li>\r\n    <li>Mereview Renop berdasarkan Rencana Strategis (Renstra) Politeknik Jambi 2</li>\r\n    <li>Melakukan analisis dan tinjauan rencana operasional dari tahun ke tahun.</li>\r\n    <li>Menerbitkan dan mereview rencana operasional tahunan yang merupakan turunan dari renstra</li>\r\n    <li>Mendistribusikan Indikator rencana operasional kepada unit-unit terkait</li>\r\n    <li>Melakukan evaluasi rencana operasional berdasarkan data riil yang diisi oleh bidang/unit terkait</li>\r\n    <li>Melakukan evaluasi capaian rencana operasional dan menginformasikan ke pimpinan terkait</li>\r\n    <li>Melakukan rekapitulasi capaian keseluruhan rencana operasional berdasarkan rencana strategi</li>\r\n    <li>Melakukan analisis hasil rekapitulasi capaian rencana operasional tahunan dan memberikan pertimbangan kepada Kepala Lembaga mengenai hasil rekapitulasi</li>\r\n    <li>Melakukan kegiatan pengembangan institusi yang diinstruksikan langsung oleh direktur melalui surat tugas.</li>\r\n</ol>\r\n\r\n<h4>KEPALA BAGIAN PENJAMINAN MUTU (Kabag. PMI)</h4>\r\n<ol>\r\n    <li>Menyusun perencanaan program kerja dan anggaran dalam waktu satu tahun sesuai renstra institusi</li>\r\n    <li>Menyusun laporan evaluasi kinerja tahunan</li>\r\n    <li>Mengkoordinir penyusunan dan pengembangan Standar Mutu dan Standar Operasional</li>\r\n    <li>Mengkoordinir pelaksanaan Monitoring dan Evaluasi Internal (Monev-In) di lingkungan Politeknik Jambi</li>\r\n    <li>Melaksanakan monev penyelesaian PTK AMI sebelumnya</li>\r\n    <li>Melaksanakan Audit Mutu Internal di lingkungan Politeknik Jambi</li>\r\n    <li>Menyusun laporan hasil Audit Mutu internal termasuk rekomendasi tindak lanjut kepada Kepala Lembaga</li>\r\n    <li>Melaksanakan RTM untuk menindaklanjuti laporan hasil tindak lanjut AMI</li>\r\n    <li>Mengelola pelaksanaan evaluasi kegiatan akademik melalui kuesioner online yang dilaksanakan semester ganjil dan genap</li>\r\n    <li>Menyusun laporan dan memberikan rekomendasi terhadap hasil kuesioner yang dilakukan</li>\r\n    <li>Melakukan pelatihan untuk tenaga Auditor untuk Audit Mutu Internal di Lingkungan Politeknik Jambi</li>\r\n    <li>Mengikuti kegiatan Sistem Penjaminan Mutu Internal (SPMI) yang dilaksanakan oleh lembaga lain.</li>\r\n    <li>Melakukan sosialisasi sistem penjaminan mutu dan budaya mutu kepada civitas akademika</li>\r\n    <li>Memeriksa capaian indikator masing-masing unit sesuai dengan capaian indikator yang ditetapkan pada standar mutu Politeknik Jambi.</li>\r\n</ol>\r\n\r\n<h4>STAFF ADMINISTRASI LP3M</h4>\r\n<ol>\r\n    <li>Membantu Kabag PMI Melaksanakan Audit Mutu Internal di lingkungan Politeknik Jambi</li>\r\n    <li>Membantu Kabag PMI Menyusun laporan dan memberikan rekomendasi terhadap hasil kuesioner yang dilakukan</li>\r\n    <li>Membantu Kabag PMI merevisi standar SPMI</li>\r\n    <li>Mengikuti Kegiatan Sistem Penjaminan Mutu Internal (SPMI) yang dilaksanakan oleh lembaga lain</li>\r\n    <li>Membantu Kabag PME Mengkoordinir kegiatan visitasi baik untuk akreditasi program studi maupun akreditasi institusi.</li>\r\n    <li>Melaporkan data IKU (Indikator Kinerja Utama) ke LLDIKTI X</li>\r\n    <li>Membantu Kepala LP3M dalam mengelola pencapaian hibah pengembangan institusi</li>\r\n    <li>Membantu Ka. LP3M dalam Melakukan rekapitulasi capaian keseluruhan rencana operasional berdasarkan rencana Strategis</li>\r\n    <li>Membantu dalam Menyusun laporan evaluasi kinerja tahunan Ka. LP3M</li>\r\n    <li>Mengelola data web LP3M</li>\r\n    <li>Membantu Kepala LP3M merevisi SOP/form SPMI yang diajukan oleh unit terkait</li>\r\n    <li>Membantu Kabag PMI Mengelola pelaksanaan evaluasi kegiatan akademik melalui kuesioner online yang dilaksanakan setiap semester</li>\r\n</ol>\r\n', 'job-deskripsi', 5432, 'Admin', '2023-02-04', '2026-05-04 03:24:23'),
(9, 'Profil', 'Standar Waktu Pelayanan', '<p>Content sedang diproses, silahkan kunjungi beberapa saat lagi...</p>', 'standar-waktu-pelayanan', 979, 'Admin', '2023-02-04', '2026-05-04 03:24:23'),
(10, 'Profil', 'Artikel', '\r\n<div class=\"list-group\">\r\n  <a href=\"/artikel/berita\" class=\"list-group-item\">Daftar Berita (Uncategorised)</a>\r\n  <a href=\"/artikel/kegiatan\" class=\"list-group-item\">Daftar Kegiatan</a>\r\n  <a href=\"/artikel/profil\" class=\"list-group-item\">Daftar Profil Artikel</a>\r\n</div>\r\n', 'artikel', 450, 'Admin', '2023-02-04', '2026-05-04 03:24:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `sub_judul` text DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sliders`
--

INSERT INTO `sliders` (`id`, `judul`, `sub_judul`, `gambar`, `link_url`, `urutan`, `created_at`) VALUES
(1, 'Selamat Datang di LP3M', 'Lembaga Perencanaan Pengembangan & Penjaminan Mutu Politeknik Jambi', 'banner_welcome.jpg', '#', 1, '2026-05-04 07:23:14'),
(2, 'Sistem Penjaminan Mutu Internal', 'Membangun Budaya Mutu Melalui Siklus PPEPP yang Konsisten', 'banner_spmi.jpg', '/spmi/kebijakan-spmi', 2, '2026-05-04 07:23:14'),
(3, 'Akreditasi Program Studi', 'Menuju Program Studi yang Unggul dan Berdaya Saing Nasional', 'banner_akreditasi.jpg', '/akreditasi/akreditasi', 3, '2026-05-04 07:23:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `spmis`
--

CREATE TABLE `spmis` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` enum('Dokumen SPMI','Unit','RTM','Dokumen Mutu SPMI','e-spmiPoljam') NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `link_eksternal` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `spmis`
--

INSERT INTO `spmis` (`id`, `judul`, `kategori`, `deskripsi`, `nama_file`, `link_eksternal`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Kebijakan SPMI 2024', 'Dokumen SPMI', 'Dokumen standar kebijakan pusat.', NULL, NULL, 'kebijakan-spmi-2024', '2026-05-04 04:21:11', '2026-05-04 04:21:11'),
(2, 'Daftar Unit Kerja', 'Unit', 'List unit di lingkungan Poljam.', NULL, NULL, 'daftar-unit-kerja', '2026-05-04 04:21:11', '2026-05-04 04:21:11'),
(3, 'Laporan RTM Semester Ganjil', 'RTM', 'Hasil Rapat Tinjauan Manajemen.', NULL, NULL, 'rtm-ganjil-2024', '2026-05-04 04:21:11', '2026-05-04 04:21:11'),
(4, 'Manual Mutu Pendidikan', 'Dokumen Mutu SPMI', 'Standar operasional prosedur pendidikan.', NULL, NULL, 'manual-mutu-pendidikan', '2026-05-04 04:21:11', '2026-05-04 04:21:11'),
(5, 'Portal e-spmiPoljam', 'e-spmiPoljam', 'Akses ke sistem elektronik SPMI.', NULL, NULL, 'link-e-spmi', '2026-05-04 04:21:11', '2026-05-04 04:21:11');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akreditasis`
--
ALTER TABLE `akreditasis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `artikels`
--
ALTER TABLE `artikels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `beritas`
--
ALTER TABLE `beritas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `capaians`
--
ALTER TABLE `capaians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `galeri_albums`
--
ALTER TABLE `galeri_albums`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `galeri_fotos`
--
ALTER TABLE `galeri_fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `album_id` (`album_id`);

--
-- Indeks untuk tabel `home_counters`
--
ALTER TABLE `home_counters`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kuesioners`
--
ALTER TABLE `kuesioners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengumumans`
--
ALTER TABLE `pengumumans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `profils`
--
ALTER TABLE `profils`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `spmis`
--
ALTER TABLE `spmis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akreditasis`
--
ALTER TABLE `akreditasis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `artikels`
--
ALTER TABLE `artikels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `beritas`
--
ALTER TABLE `beritas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `capaians`
--
ALTER TABLE `capaians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `galeri_albums`
--
ALTER TABLE `galeri_albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `galeri_fotos`
--
ALTER TABLE `galeri_fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `home_counters`
--
ALTER TABLE `home_counters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kuesioners`
--
ALTER TABLE `kuesioners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pengumumans`
--
ALTER TABLE `pengumumans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `profils`
--
ALTER TABLE `profils`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `spmis`
--
ALTER TABLE `spmis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `galeri_fotos`
--
ALTER TABLE `galeri_fotos`
  ADD CONSTRAINT `galeri_fotos_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `galeri_albums` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
