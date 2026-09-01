# 📋 Panduan Mengelola Profil Organisasi di Admin Panel

## 🎯 Overview
Admin panel sekarang memiliki dashboard lengkap untuk mengelola profil organisasi KDMP yang mencakup:
- **Halaman Tentang** - Edit profil, visi, misi, dan nilai organisasi
- **Anggota Organisasi** - Kelola data pengurus dan pengawas

---

## 📌 Cara Mengakses Menu Profil Organisasi

### Step 1: Login Admin
1. Buka halaman admin: `http://localhost:8000/admin/login`
2. Gunakan kredensial:
   - **Email**: `studio.mazte@gmail.com`
   - **Password**: `Admin1234!`

### Step 2: Akses Menu Profil Organisasi
1. Setelah login, lihat sidebar di sebelah kiri
2. Cari menu **"Profil Organisasi"** dengan icon card
3. Klik menu tersebut untuk masuk ke dashboard profil

---

## 📖 Dashboard Profil Organisasi

Setelah mengklik menu Profil Organisasi, Anda akan melihat:

### 📊 Summary Cards
- **Halaman Tentang**: 1 (menampilkan jumlah konten tentang)
- **Pengurus**: X anggota (jumlah pengurus aktif)
- **Pengawas**: X anggota (jumlah pengawas aktif)

### ⚡ Aksi Cepat
Tombol-tombol untuk navigasi cepat:
- Edit Halaman Tentang
- Tambah Anggota Baru
- Kelola Pengurus
- Kelola Pengawas

---

## 🎯 Mengelola Halaman Tentang

### Mengakses Halaman Tentang
1. Di dashboard profil, klik tab **"Halaman Tentang"** atau tombol **"Edit Halaman Tentang"**
2. Atau langsung ke: `/admin/profile/about`

### Edit Konten Tentang
1. **Profil Singkat** - Deskripsi organisasi (max 2000 karakter)
2. **Visi** - Visi organisasi (max 1000 karakter)
3. **Misi** - Array misi yang dapat ditambah/hapus
   - Klik "Tambah Misi" untuk menambah item baru
   - Klik icon trash untuk menghapus item
4. **Nilai** - Array nilai-nilai organisasi
   - Klik "Tambah Nilai" untuk menambah item baru
   - Klik icon trash untuk menghapus item

### Menyimpan Perubahan
Klik tombol **"Simpan Perubahan"** di bawah form

---

## 👥 Mengelola Anggota Organisasi (Pengurus & Pengawas)

### Mengakses Daftar Anggota
1. Di dashboard profil, klik tab **"Anggota Organisasi"** atau tombol **"Kelola Pengurus"**/**"Kelola Pengawas"**
2. Atau langsung ke: `/admin/profile/members`

### Fitur Daftar Anggota
- **Search**: Cari berdasarkan nama atau jabatan
- **Filter Tipe**: Pilih "Pengurus" atau "Pengawas"
- **Tabel Data**: Tampilkan semua anggota dengan:
  - Foto profil
  - Nama
  - Jabatan
  - Tipe (Pengurus/Pengawas)
  - Status (Aktif/Tidak Aktif)
  - Urutan tampilan

---

## ➕ Menambah Anggota Baru

### Step 1: Akses Form Tambah
1. Klik tombol **"Tambah Anggota"** di dashboard atau halaman anggota
2. Atau ke: `/admin/profile/members/create`

### Step 2: Isi Form
Form yang perlu diisi:

| Field | Tipe | Keterangan |
|-------|------|-----------|
| **Nama Lengkap** | Text (Wajib) | Nama anggota organisasi |
| **Jabatan** | Text (Wajib) | Contoh: Ketua, Sekretaris, Bendahara, dll |
| **Tipe** | Dropdown (Wajib) | Pilih "Pengurus" atau "Pengawas" |
| **Foto Profil** | File (Opsional) | JPG, PNG, GIF (max 2MB) |
| **Biografi** | Textarea (Opsional) | Deskripsi singkat tentang anggota |
| **Urutan Tampilan** | Number | 0 = pertama, 1 = kedua, dst |
| **Aktif** | Checkbox | Centang untuk menampilkan di halaman publik |

### Step 3: Simpan
Klik tombol **"Simpan"** untuk menambahkan anggota baru

---

## ✏️ Mengedit Anggota

### Step 1: Akses Form Edit
1. Di halaman daftar anggota, klik tombol **"Edit"** pada baris anggota yang ingin diubah
2. Atau langsung ke: `/admin/profile/members/{id}/edit`

### Step 2: Ubah Data
Semua field sama seperti form tambah dan sudah terisi dengan data lama

### Step 3: Upload Foto Baru (Opsional)
- Jika ingin mengganti foto, upload file baru
- Foto lama akan otomatis dihapus
- Biarkan kosong jika tidak ingin mengubah foto

### Step 4: Simpan
Klik tombol **"Perbarui"** untuk menyimpan perubahan

---

## 🗑️ Menghapus Anggota

1. Di halaman daftar anggota, klik tombol **"Hapus"** pada baris anggota
2. Konfirmasi penghapusan pada dialog popup
3. Anggota dan foto profilnya akan dihapus permanen

**Catatan**: Jika ingin menyembunyikan anggota tanpa menghapus, gunakan status "Tidak Aktif"

---

## 👁️ Tampilan di Halaman Publik

Data yang Anda kelola di admin akan tampil di:

- **Halaman Tentang**: `/profil/tentang`
  - Menampilkan profil singkat, visi, misi, dan nilai organisasi

- **Halaman Pengurus**: `/profil/pengurus`
  - Menampilkan daftar anggota dengan tipe "pengurus"
  - Diurutkan berdasarkan field "order"

- **Halaman Pengawas**: `/profil/pengawas`
  - Menampilkan daftar anggota dengan tipe "pengawas"
  - Diurutkan berdasarkan field "order"

---

## 💡 Tips & Trik

1. **Aktifkan/Nonaktifkan Anggota**
   - Gunakan checkbox "Aktif" untuk show/hide anggota tanpa menghapus data
   - Data disimpan dan dapat diaktifkan kembali kapan saja

2. **Mengatur Urutan Tampilan**
   - Gunakan field "Urutan" untuk mengatur posisi di halaman publik
   - Angka lebih kecil ditampilkan lebih awal
   - Contoh: Ketua (order=0), Sekretaris (order=1), Bendahara (order=2)

3. **Upload Foto Optimal**
   - Gunakan ukuran minimal 400x400 pixels
   - Format: JPG, PNG, atau GIF
   - Maksimal 2MB per file
   - Foto akan otomatis di-crop menjadi circle

4. **Backup Data**
   - Pastikan selalu backup database secara berkala
   - Penghapusan anggota bersifat permanen

---

## ❓ FAQ

### Q: Data tidak tampil di halaman publik?
**A**: Periksa:
- Apakah status anggota sudah "Aktif"?
- Apakah sudah ada minimal 1 anggota dengan tipe pengurus/pengawas?
- Clear browser cache dan refresh halaman

### Q: Foto tidak muncul setelah upload?
**A**: 
- Pastikan folder `storage` memiliki permission yang tepat
- Jalankan `php artisan storage:link`
- Clear view cache: `php artisan view:clear`

### Q: Mau ubah email/password admin?
**A**: Edit file `.env`:
```
ADMIN_EMAIL=email@baru.com
ADMIN_PASSWORD=password_baru
```
Kemudian restart server

---

## 📞 Support
Jika ada masalah atau pertanyaan, silakan hubungi tim development.
