# 📋 Panduan Input Data Profil Backend - POLJAM

Sistem input data profil backend telah dibuat tanpa memerlukan API key. Anda dapat menambah, edit, dan menghapus data profil melalui form yang user-friendly.

## 🎯 Fitur Utama

### 1. **Kelola Data Profil via Form Admin** 
   - **URL**: `/profil` (setelah login)
   - **Fitur**:
     - ✅ Melihat daftar semua data profil
     - ✅ Tambah data profil baru
     - ✅ Edit data profil yang ada
     - ✅ Hapus data profil
     - ✅ Auto-generate slug dari judul

### 2. **Input Data Secara Bulk via Seeder**
   - **Command**: `php artisan db:seed --class=ProfilSeeder`
   - Seeder sudah menyiapkan 9 data profil sample yang bisa langsung digunakan

---

## 📝 Cara Menggunakan

### **A. Via Form Admin (Manual Input)**

#### 1️⃣ Akses Halaman Kelola Profil
```
Login → Dashboard → Kelola Data Profil
atau langsung akses: /profil
```

#### 2️⃣ Tambah Data Profil Baru
- Klik tombol "➕ Tambah Data Profil"
- Isi form dengan data:
  - **Judul** (required) - Judul/nama profil
  - **Kategori** (required) - Pilih dari dropdown (Visi & Misi, Tugas Pokok, dll)
  - **Isi Konten** (required) - Gunakan editor rich text (TinyMCE)
  - **Slug** (optional) - URL-friendly identifier, auto-generate jika kosong
  - **Penulis** (optional) - Nama penulis/kontributor
- Klik "💾 Simpan Data Profil"

#### 3️⃣ Edit Data Profil
- Di halaman daftar profil, klik "✏️ Edit" pada baris yang ingin diedit
- Ubah data sesuai kebutuhan
- Klik "💾 Update Data Profil"

#### 4️⃣ Hapus Data Profil
- Di halaman daftar profil, klik "🗑️ Hapus" pada baris yang ingin dihapus
- Konfirmasi penghapusan

---

### **B. Via Seeder (Bulk Input)**

#### Jalankan seeder sample:
```bash
php artisan db:seed --class=ProfilSeeder
```

#### Data yang akan ditambahkan:
1. Visi LP3M Politeknik Jambi
2. Misi LP3M Politeknik Jambi
3. Tugas Pokok dan Fungsi LP3M
4. Sejarah Berdirinya LP3M
5. Struktur Organisasi LP3M
6. Tim Manajemen LP3M
7. Berita: Peluncuran Sistem Penjaminan Mutu Online
8. Kegiatan: Workshop Penyusunan Dokumen SPMI
9. Profil: Program Studi di Politeknik Jambi

---

### **C. Via API (Programmatic)**

Jika ingin input via aplikasi lain/script:

```bash
POST /profil
Content-Type: application/json

{
  "judul": "Judul Profil",
  "kategori": "Visi & Misi",
  "isi_konten": "<p>Isi konten di sini</p>",
  "slug": "judul-profil",
  "penulis": "Nama Penulis"
}
```

Response:
```json
{
  "message": "Data berhasil disimpan"
}
```

---

## 🗄️ Struktur Data Profil

| Field | Tipe | Required | Keterangan |
|-------|------|----------|-----------|
| id | Integer | ✅ | Primary key (auto) |
| kategori | String(100) | ✅ | Kategori profil |
| judul | String(255) | ✅ | Judul/nama profil |
| isi_konten | Text | ✅ | Konten profil (HTML) |
| slug | String | ❌ | URL-friendly identifier |
| hits | Integer | ❌ | Jumlah views |
| penulis | String(100) | ❌ | Nama penulis |
| tanggal_arsip | Timestamp | ❌ | Tanggal arsip |
| created_at | Timestamp | ✅ | Waktu dibuat (auto) |

---

## 🔐 Keamanan

✅ **Tidak perlu API Key** - Form langsung diakses melalui dashboard admin  
✅ **CSRF Protection** - Semua form dilindungi CSRF token  
✅ **Validasi Input** - Semua input divalidasi di server-side  
✅ **Authentication** - Hanya admin yang login yang bisa akses

---

## 📂 File-File yang Dibuat/Dimodifikasi

### Routes
- `routes/web.php` - Tambah 7 route CRUD profil

### Controllers
- `app/Http/Controllers/ProfilController.php` - Tambah methods:
  - `indexAdmin()` - Tampilkan daftar profil
  - `create()` - Form input baru
  - `edit()` - Form edit profil
  - `saveData()` - Simpan data baru
  - `update()` - Update data existing
  - `destroy()` - Hapus data
  - `store()` - API endpoint

### Views
- `resources/views/admin/profil/index.blade.php` - Daftar profil
- `resources/views/admin/profil/create.blade.php` - Form tambah
- `resources/views/admin/profil/edit.blade.php` - Form edit

### Database
- `database/seeders/ProfilSeeder.php` - Seeder sample data
- `database/seeders/DatabaseSeeder.php` - Register seeder

---

## 🚀 Quick Start

```bash
# 1. Jalankan seeder untuk input sample data
php artisan db:seed --class=ProfilSeeder

# 2. Akses admin panel
# Login → Pergi ke /profil

# 3. Mulai input/edit data via form!
```

---

## ❓ FAQ

**Q: Bagaimana jika slug kosong saat input?**  
A: Sistem akan auto-generate slug dari judul secara otomatis.

**Q: Bisakah saya menggunakan HTML di isi_konten?**  
A: Ya, editor TinyMCE mendukung HTML formatting lengkap.

**Q: Apakah data bisa dihapus secara permanen?**  
A: Ya, klik tombol "Hapus" dan konfirmasi untuk menghapus permanen dari database.

**Q: Berapa jumlah maksimal karakter untuk judul?**  
A: Maksimal 255 karakter (VARCHAR limit).

---

## 💡 Tips

- Gunakan kategori yang konsisten untuk grouping data
- Slug sebaiknya unique dan deskriptif
- Isi konten bisa menggunakan editor visual atau HTML manual
- Jika input banyak data sekaligus, gunakan seeder lebih efisien

---

**Created**: May 22, 2026  
**Status**: ✅ Siap Digunakan
