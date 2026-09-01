# 📘 MANUAL ADMIN PANEL - Dokumentasi Lengkap

Sistem admin panel manual untuk KDMP Wonokerto yang telah menggantikan Filament. Panduan lengkap penggunaan dan struktur kode.

---

## 🎯 Fitur Utama

Admin panel ini menyediakan:

1. **Dashboard** - Overview statistik sistem
2. **Manajemen Anggota** - CRUD anggota koperasi
3. **Manajemen Artikel** - Kelola berita, informasi, dan pengumuman
4. **Manajemen Transaksi** - Catat pemasukan dan pengeluaran
5. **Pengaturan** - Konfigurasi website dan kontak

---
php artisan cache:clear
php artisan view:clear
php artisan migrate --fresh --seed## 🔐 Akses Admin Panel

### Login
- **URL:** `http://localhost/admin/login`
- **Email:** `studi.mazte@gmail.com` (sesuai `.env`)
- **Password:** `Admin1234!` (sesuai `.env`)

### Dashboard
- **URL:** `http://localhost/admin` (setelah login)
- Menampilkan statistik lengkap sistem

---

## 📁 Struktur File

```
app/Http/Controllers/Admin/
├── AdminAuthController.php       # Handle login/logout
├── AdminController.php           # Dashboard
├── AdminMemberController.php     # CRUD Anggota
├── AdminArticleController.php    # CRUD Artikel
├── AdminTransactionController.php # CRUD Transaksi
└── AdminSettingController.php    # Pengaturan

resources/views/admin/
├── layouts/
│   └── app.blade.php            # Template utama
├── auth/
│   └── login.blade.php          # Form login
├── dashboard.blade.php          # Halaman dashboard
├── members/                      # Views anggota
├── articles/                     # Views artikel
├── transactions/                 # Views transaksi
└── settings/                     # Views pengaturan
```

---

## 🛣️ Route Struktur

Semua route admin dimulai dengan prefix `/admin`:

### Authentication
```
GET/POST  /admin/login              # Login page & process
POST      /admin/logout             # Logout
```

### Members
```
GET       /admin/members            # Daftar anggota
GET       /admin/members/create     # Form tambah
POST      /admin/members            # Simpan anggota baru
GET       /admin/members/{id}       # Detail anggota
GET       /admin/members/{id}/edit  # Form edit
PUT       /admin/members/{id}       # Simpan edit
DELETE    /admin/members/{id}       # Hapus anggota
```

### Articles
```
GET       /admin/articles           # Daftar artikel
GET       /admin/articles/create    # Form tambah
POST      /admin/articles           # Simpan artikel baru
GET       /admin/articles/{id}      # Detail artikel
GET       /admin/articles/{id}/edit # Form edit
PUT       /admin/articles/{id}      # Simpan edit
DELETE    /admin/articles/{id}      # Hapus artikel
```

### Transactions
```
GET       /admin/transactions       # Daftar transaksi
GET       /admin/transactions/create # Form tambah
POST      /admin/transactions       # Simpan transaksi baru
GET       /admin/transactions/{id}  # Detail transaksi
GET       /admin/transactions/{id}/edit # Form edit
PUT       /admin/transactions/{id}  # Simpan edit
DELETE    /admin/transactions/{id}  # Hapus transaksi
```

### Settings
```
GET       /admin/settings           # Form pengaturan
POST      /admin/settings           # Simpan pengaturan
```

---

## 👥 Cara Kerja Admin Panel

### 1. **Authentication (Login/Logout)**

**File:** `AdminAuthController.php`

```php
// Login validation & auth
if (Auth::guard('admin')->attempt($credentials)) {
    // Redirect to dashboard
    redirect()->route('admin.dashboard');
}

// Logout & session invalidate
Auth::guard('admin')->logout();
```

**Konfigurasi:** `config/auth.php`
- Menggunakan guard `admin`
- User provider: `admins` → User model
- Session driver untuk penyimpanan

---

### 2. **Dashboard**

**File:** `AdminController.php` → `dashboard()`

Menampilkan:
- Total anggota & yang aktif
- Total artikel & yang dipublikasikan
- Total transaksi
- Total pemasukan/pengeluaran
- Saldo bersih
- Artikel terbaru (5)
- Transaksi terbaru (5)

```php
$stats = [
    'total_members' => Member::count(),
    'active_members' => Member::where('is_active', true)->count(),
    // ... more stats
];
```

---

### 3. **Manajemen Anggota**

**File:** `AdminMemberController.php`

#### Fitur:
- **Index:** Daftar anggota dengan search & filter status
- **Create:** Form tambah anggota baru
- **Store:** Simpan anggota ke database
- **Show:** Detail anggota
- **Edit:** Form edit anggota
- **Update:** Simpan perubahan anggota
- **Destroy:** Hapus anggota

#### Validasi:
```php
'name' => 'required|string|max:255',
'nik' => 'required|string|unique:members,nik',
'email' => 'required|email|unique:members,email',
'phone' => 'required|string|max:15',
'address' => 'required|string',
'gender' => 'required|in:Laki-laki,Perempuan',
'role' => 'required|string',
```

---

### 4. **Manajemen Artikel**

**File:** `AdminArticleController.php`

#### Fitur:
- **Index:** Daftar artikel dengan filter tipe & status publikasi
- **Create:** Form buat artikel baru
- **Store:** Simpan artikel
- **Show:** Tampilkan isi artikel lengkap
- **Edit:** Ubah artikel
- **Update:** Simpan perubahan
- **Destroy:** Hapus artikel

#### Tipe Artikel:
- `berita` - Berita terkini
- `informasi` - Informasi umum
- `pengumuman` - Pengumuman penting

#### Slug Generation:
```php
$validated['slug'] = Str::slug($validated['title']);
// Contoh: "Rapat Rutin Bulan Mei" → "rapat-rutin-bulan-mei"
```

---

### 5. **Manajemen Transaksi**

**File:** `AdminTransactionController.php`

#### Fitur:
- **Index:** Daftar transaksi dengan filter tipe, bulan, dan search
- **Create:** Form catat transaksi baru
- **Store:** Simpan transaksi
- **Show:** Detail transaksi
- **Edit:** Ubah transaksi
- **Update:** Simpan perubahan
- **Destroy:** Hapus transaksi

#### Tipe Transaksi:
- `income` - Pemasukan
- `expense` - Pengeluaran

#### Statistik:
```php
$income_total = Transaction::where('type', 'income')->sum('amount');
$expense_total = Transaction::where('type', 'expense')->sum('amount');
// Saldo = Income - Expense
```

---

### 6. **Pengaturan Website**

**File:** `AdminSettingController.php`

#### Setting yang Dapat Diatur:
1. **Informasi Dasar**
   - Nama website
   - Alamat

2. **Kontak**
   - Telepon
   - Email

3. **Footer**
   - Deskripsi footer

4. **Maps**
   - URL Google Maps

5. **Media Sosial**
   - Facebook
   - Instagram
   - Twitter
   - YouTube
   - WhatsApp

#### Cara Kerja:
```php
// Simpan/update setting by key
Setting::updateOrCreate(
    ['key' => 'site_name'],
    ['value' => 'KDMP Wonokerto']
);

// Retrieve setting
$siteName = $settings['site_name'] ?? null;
```

---

## 🎨 UI/UX Design

### Layout
- **Sidebar** - Navigasi utama (Rose gradient)
- **Top Bar** - Judul halaman & user info
- **Main Content** - Isi halaman dengan padding
- **Footer** - Copyright info

### Colors
- **Primary:** Rose (#f43f5e)
- **Success:** Green (#10b981)
- **Danger:** Red (#ef4444)
- **Warning:** Yellow (#f59e0b)
- **Info:** Blue (#3b82f6)

### Components
- Cards dengan shadow & border
- Tables dengan responsive design
- Forms dengan validation messages
- Buttons dengan hover effects
- Status badges untuk indikator

---

## 🔒 Security Features

1. **Authentication Guard** - Menggunakan `auth:admin` middleware
2. **Session Management** - Regenerate token setelah login
3. **CSRF Protection** - Form directive `@csrf`
4. **Validation** - Server-side validation untuk semua input
5. **Authorization** - Hanya admin yang dapat akses

### Middleware Apply:
```php
// Cek apakah sudah login sebagai admin
Route::middleware('auth:admin')->group(function() {
    // Protected routes here
});

// Cek apakah belum login (untuk login page)
Route::middleware('guest:admin')->group(function() {
    // Guest routes
});
```

---

## 📝 Validasi Input

Semua controller menggunakan validasi ketat:

```php
$request->validate([
    'field' => ['required', 'type', 'constraints'],
], [
    'field.required' => 'Pesan error custom',
    'field.type' => 'Pesan error custom',
]);
```

### Pesan Error
- Dalam bahasa Indonesia untuk UX yang lebih baik
- Ditampilkan di atas form atau di bawah field

---

## 🚀 Deployment Checklist

Sebelum go live:

- [ ] Pastikan database sudah migrate
- [ ] Jalankan seeder admin: `php artisan db:seed --class=AdminUserSeeder`
- [ ] Test login dengan kredensial di `.env`
- [ ] Test CRUD untuk semua modul
- [ ] Setting website di `/admin/settings`
- [ ] Clear cache: `php artisan config:clear`

---

## 🐛 Troubleshooting

### Login Tidak Bisa Masuk
1. Cek kredensial di `.env` (ADMIN_EMAIL, ADMIN_PASSWORD)
2. Pastikan admin user sudah ada di database: `SELECT * FROM users;`
3. Jalankan seeder: `php artisan db:seed --class=AdminUserSeeder`

### Halaman Kosong
1. Clear cache: `php artisan cache:clear`
2. Clear views: `php artisan view:clear`
3. Clear config: `php artisan config:clear`

### Data Tidak Muncul
1. Pastikan database connection aktif
2. Cek tabel exists: `php artisan migrate --force`
3. Verify model relationships correct

---

## 📚 Quick Tips

1. **Navigasi Cepat** - Klik logo untuk kembali ke dashboard
2. **Pencarian** - Gunakan filter search untuk menemukan data
3. **Pagination** - Gunakan tombol next/previous untuk halaman lain
4. **Status Badge** - Warna berbeda menunjukkan status (hijau=aktif, abu=tidak aktif)
5. **Aksi Cepat** - Dashboard memiliki tombol untuk operasi utama

---

## 🆘 Bantuan Lebih Lanjut

Untuk pertanyaan atau masalah:
1. Cek dokumentasi controller di comments
2. Lihat validasi rules di store/update methods
3. Cek blade templates untuk UI reference
4. Konsultasi dengan developer

---

**Admin Panel Manual - KDMP Wonokerto**
*Diperbarui: April 2026*
