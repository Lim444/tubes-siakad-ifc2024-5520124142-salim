# tubes-siakad-ifc2024-5520124142-salim

**Sistem Informasi Akademik (SIAKAD)** — Aplikasi web berbasis Laravel untuk pengelolaan data akademik meliputi dosen, mahasiswa, mata kuliah, jadwal perkuliahan, dan Kartu Rencana Studi (KRS).

---

## Akses Aplikasi (Hosting)

**URL Aplikasi:** http://tubes-siakad-ifc24-salim.wuaze.com

| Role      | Username | Password |
|-----------|----------|----------|
| Admin     | admin    | 12345    |
| Mahasiswa | 5520124142 | 12345    |

---

## Deskripsi Singkat Aplikasi

SIAKAD adalah aplikasi berbasis web yang dibangun menggunakan framework Laravel. Aplikasi ini mensimulasikan sistem informasi akademik sederhana yang digunakan oleh dua jenis pengguna: Admin dan Mahasiswa. Admin memiliki kendali penuh atas seluruh data di sistem, sedangkan Mahasiswa hanya dapat mengakses fitur pengambilan KRS dan melihat jadwal perkuliahan.

Aplikasi ini dikembangkan sebagai Tugas Besar Mata Kuliah Web II (IF45123) dengan memanfaatkan fitur-fitur Laravel seperti Eloquent ORM, Eloquent Relationship, Migration, Seeder, Middleware, dan sistem autentikasi berbasis role.

---

## Teknologi yang Digunakan

| Komponen        | Keterangan                   |
|-----------------|------------------------------|
| Framework       | Laravel 11                   |
| Bahasa          | PHP 8.2, Blade Template      |
| Database        | MySQL                        |
| Frontend        | HTML, CSS, JavaScript        |
| Ikon            | Font Awesome 6               |
| Export          | jsPDF, jsPDF AutoTable, SheetJS |

---

## Struktur Role & Hak Akses

| Halaman              | Admin | Mahasiswa |
|----------------------|-------|-----------|
| Dashboard            | Ya    | Ya        |
| Manajemen Dosen      | Ya    | Tidak     |
| Manajemen Mahasiswa  | Ya    | Tidak     |
| Manajemen Mata Kuliah| Ya    | Tidak     |
| Jadwal Perkuliahan   | Ya    | Ya (hanya lihat) |
| KRS                  | Ya    | Ya (ambil & hapus milik sendiri) |

---

## Penjelasan Fungsi Masing-Masing Halaman

### 1. Halaman Login

Halaman awal yang wajib dilalui setiap pengguna sebelum mengakses sistem. Pengguna memasukkan username dan password. Sistem memverifikasi kredensial dan mengarahkan pengguna ke dashboard sesuai role masing-masing. Terdapat validasi input sisi server untuk mencegah data kosong.

---

### 2. Dashboard

Halaman utama setelah login berhasil. Menampilkan ringkasan statistik sistem berupa jumlah total dosen, mahasiswa, mata kuliah, jadwal, dan KRS yang terdaftar. Tersedia kartu statistik yang memberikan gambaran umum kondisi data akademik secara sekilas.

---

### 3. Halaman Dosen (Admin Only)

Menampilkan daftar seluruh dosen yang terdaftar di sistem beserta NIDN dan namanya. Halaman ini menyediakan fitur lengkap CRUD:

- **Tambah Dosen** — Mengisi form dengan data NIDN dan nama dosen, disertai validasi unik untuk NIDN.
- **Edit Dosen** — Mengubah data nama dosen yang sudah ada.
- **Hapus Dosen** — Menghapus data dosen dari sistem dengan konfirmasi.
- **Cari Dosen** — Mencari data berdasarkan NIDN atau nama.
- **Urutkan A-Z / Z-A** — Mengurutkan data nama dosen secara ascending atau descending melalui server.

---

### 4. Halaman Mahasiswa (Admin Only)

Menampilkan daftar seluruh mahasiswa yang terdaftar beserta NPM, nama, dan dosen wali. Halaman ini menyediakan fitur lengkap CRUD:

- **Tambah Mahasiswa** — Mengisi form dengan NPM, nama, dan memilih dosen wali. NPM bersifat unik.
- **Tambah Akun Mahasiswa** — Mengisi form dengan username (npm), email, password.
- **Edit Mahasiswa** — Mengubah nama dan dosen wali mahasiswa.
- **Hapus Mahasiswa** — Menghapus data mahasiswa dari sistem dengan konfirmasi.
- **Cari Mahasiswa** — Mencari berdasarkan NPM, nama, atau nama dosen wali.
- **Urutkan A-Z / Z-A** — Mengurutkan data berdasarkan nama mahasiswa.

---

### 5. Halaman Mata Kuliah (Admin Only)

Menampilkan daftar mata kuliah yang tersedia di sistem beserta kode, nama, dan jumlah SKS. Halaman ini menyediakan fitur CRUD:

- **Tambah Mata Kuliah** — Mengisi kode mata kuliah (unik), nama, dan jumlah SKS (1–6).
- **Edit Mata Kuliah** — Mengubah nama dan jumlah SKS.
- **Hapus Mata Kuliah** — Menghapus data mata kuliah dengan konfirmasi.
- **Cari Mata Kuliah** — Mencari berdasarkan kode, nama, atau SKS.
- **Urutkan A-Z / Z-A** — Mengurutkan berdasarkan nama mata kuliah.

---

### 6. Halaman Jadwal Perkuliahan

Menampilkan daftar jadwal kelas yang telah disusun, mencakup mata kuliah, dosen pengajar, kelas, hari, dan waktu. Hak akses berbeda per role:

**Admin:**
- **Tambah Jadwal** — Menentukan mata kuliah, dosen pengajar, kelas, hari, jam mulai, dan jam selesai.
- **Edit Jadwal** — Mengubah detail jadwal yang sudah ada.
- **Hapus Jadwal** — Menghapus jadwal dengan konfirmasi.

**Mahasiswa:**
- Hanya dapat melihat seluruh daftar jadwal yang tersedia tanpa bisa mengubah data.

Tersedia fitur pencarian dan pengurutan berdasarkan hari untuk memudahkan navigasi.

---

### 7. Halaman KRS (Kartu Rencana Studi)

Menampilkan daftar mata kuliah yang telah diambil. Terdapat fitur ekspor data ke PDF dan Excel. Hak akses berbeda per role:

**Admin:**
- Melihat, menambah, mengedit, dan menghapus KRS seluruh mahasiswa.

**Mahasiswa:**
- **Ambil Mata Kuliah** — Memilih mata kuliah untuk dimasukkan ke KRS.
- **Hapus KRS** — Membatalkan (drop) mata kuliah dari KRS.
- **Export PDF** — Mengekspor daftar KRS yang ditampilkan ke file PDF.
- **Export Excel** — Mengekspor daftar KRS yang ditampilkan ke file Excel (.xlsx).

---

## Cara Menjalankan Aplikasi (Lokal)

```bash
# 1. Clone repository
git clone https://github.com/[username]/tubes-siakad-ifc2024-5520124142-salim.git
cd tubes-siakad-ifc2024-5520124142-salim

# 2. Install dependensi PHP & JS
composer install
npm install & npm run dev

# 3. Salin file environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Konfigurasi database di file .env
# DB_DATABASE=nama_database
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Jalankan migrasi dan seeder
php artisan migrate --seed

# 7. Jalankan server lokal
php artisan serve
```

Setelah server berjalan, akses aplikasi di: `http://127.0.0.1:8000`

---

## Akun Default (Seeder)

| Role      | Username | Password |
|-----------|----------|----------|
| Admin     | admin    | 12345    |
| Mahasiswa | 5520124142 | 12345    |

---

## Struktur Direktori Utama

```
tubes-siakad-ifc2024-5520124142-salim/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # AuthController, DashboardController, dll.
│   │   └── Middleware/         # AdminMiddleware, Authenticate
│   ├── Models/                 # User, Dosen, Mahasiswa, Matakuliah, Jadwal, Krs
│   └── Providers/
├── database/
│   ├── migrations/             # Skema tabel database
│   └── seeders/                # Data awal (DatabaseSeeder, UserSeeder, dll)
├── resources/
│   └── views/
│       ├── layouts/            # Template utama (app.blade.php)
│       ├── auth/               # Halaman login
│       ├── dashboard/          # Halaman dashboard
│       ├── dosen/              # CRUD dosen
│       ├── mahasiswa/          # CRUD mahasiswa
│       ├── matakuliah/         # CRUD mata kuliah
│       ├── jadwal/             # CRUD jadwal
│       ├── krs/                # CRUD KRS
│       └── vendor/pagination/  # Custom pagination Bootstrap
├── routes/
│   └── web.php                 # Definisi seluruh route
├── public/
│   └── css/                    # Stylesheet (app.css, auth.css, dashboard.css)
├── screenshots/                # Screenshot tiap halaman
└── README.md
```

---

## Screenshots

Folder `screenshots/` berisi tangkapan layar dari setiap halaman aplikasi.

| Nama File              | Halaman                        |
|------------------------|-------------------------------|
| login.png              | Halaman Login                 |
| dashboard.png          | Halaman Dashboard             |
| dosen-index.png        | Daftar Dosen                  |
| dosen-create.png       | Form Tambah Dosen             |
| mahasiswa-index.png    | Daftar Mahasiswa              |
| mahasiswa-create.png   | Form Tambah Mahasiswa         |
| matakuliah-index.png   | Daftar Mata Kuliah            |
| matakuliah-create.png  | Form Tambah Mata Kuliah       |
| jadwal-index.png       | Daftar Jadwal                 |
| jadwal-create.png      | Form Tambah Jadwal            |
| krs-index.png          | Daftar KRS                    |
| krs-create.png         | Form Ambil Mata Kuliah (KRS)  |

---

## Informasi Pengembang

| Keterangan   | Detail                              |
|--------------|-------------------------------------|
| Nama         | Salim                               |
| NPM          | 5520124142                          |
| Kelas        | IFC 2024                            |
| Mata Kuliah  | Web II — IF45123                    |
| Prodi        | Teknik Informatika                  |
| Institusi    | Fakultas Teknik Universitas Suryakancana |
