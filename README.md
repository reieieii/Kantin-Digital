# 🍽️ Kantin Digital SMKN 20 Jakarta

> Platform pemesanan makanan digital berbasis web untuk Kantin SMKN 20 Jakarta — memudahkan siswa dan guru memesan makanan dari berbagai stand kantin secara online, cepat, dan praktis.

🌐 **Live:** [kantin-digital-production-31b3.up.railway.app](https://kantin-digital-production-31b3.up.railway.app)

---

## 📋 Daftar Isi

1. [Latar Belakang](#latar-belakang)
2. [Tujuan](#tujuan)
3. [Masalah yang Diselesaikan](#masalah-yang-diselesaikan)
4. [Fitur Utama](#fitur-utama)
5. [Jenis Akun & Peran](#jenis-akun--peran)
6. [Panduan Penggunaan](#panduan-penggunaan)
   - [Pembeli (User)](#-pembeli-user)
   - [Penjaga Stand](#-penjaga-stand)
   - [Admin](#-admin)
7. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
8. [Instalasi Lokal](#instalasi-lokal)
9. [Struktur Akun Default](#struktur-akun-default)

---

## Latar Belakang

Kantin sekolah merupakan fasilitas penting bagi siswa dan tenaga pendidik. Namun, sistem kantin konvensional masih menghadapi berbagai kendala seperti antrian panjang, ketidakjelasan stok makanan, dan kesulitan pengelolaan pesanan dari banyak stand sekaligus.

**Kantin Digital SMKN 20 Jakarta** hadir sebagai solusi modern berbasis teknologi web yang menggantikan sistem manual menjadi sistem digital yang efisien, transparan, dan mudah digunakan oleh semua pihak — siswa, penjaga stand, maupun administrator sekolah.

---

## Tujuan

- Memudahkan siswa dan guru dalam memesan makanan dari kantin sekolah secara digital
- Mengurangi antrian panjang di area kantin
- Membantu penjaga stand mengelola pesanan, stok produk, dan pendapatan secara real-time
- Memberikan admin kontrol penuh atas seluruh operasional kantin
- Menyediakan laporan harian dan rekap pendapatan untuk setiap stand
- Meningkatkan efisiensi dan transparansi pengelolaan kantin sekolah

---

## Masalah yang Diselesaikan

| Masalah Lama | Solusi Digital |
|---|---|
| Antrian panjang di kantin | Pemesanan dilakukan secara online sebelum ke kantin |
| Tidak tahu stok tersedia | Stok produk ditampilkan real-time di setiap stand |
| Pendapatan stand tidak tercatat | Akumulasi pendapatan otomatis setiap pesanan selesai |
| Laporan manual tiap minggu | Rekap harian otomatis per penjaga stand |
| Admin sulit pantau semua stand | Dashboard admin terpusat untuk semua data |
| Tidak bisa melihat riwayat pesanan | Fitur "Pesanan Saya" per akun pembeli |
| Data bercampur antar penjaga | Reset data mingguan oleh admin saat pergantian penjaga |

---

## Fitur Utama

### Untuk Pembeli
- 🔍 Lihat semua stand kantin dan produk yang tersedia
- 🛒 Keranjang belanja multi-stand
- 📱 Checkout cepat langsung dari halaman stand (modal)
- 💳 Pilihan pembayaran: **Tunai** atau **QRIS**
- 📋 Riwayat pesanan pribadi ("Pesanan Saya")
- ❤️ Simpan produk favorit
- 👤 Manajemen profil (ganti nama, password, hapus akun)

### Untuk Penjaga Stand
- 📊 Dashboard stand dengan statistik lengkap
- 💰 Widget **Total Pendapatan** otomatis terakumulasi
- 📦 Kelola produk (tambah, edit, hapus, stok, kategori)
- 🧾 Lihat dan proses pesanan masuk (filter status, kategori, metode bayar)
- 📅 **Rekap Harian** — catat pendapatan & keuntungan per hari
- 🧮 Kalkulator bawaan untuk hitung manual
- 🏪 Kelola info stand (nama, deskripsi, foto, status buka/tutup)

### Untuk Admin
- 🗂️ Kelola semua stand, produk, dan pesanan dari satu dashboard
- 👥 Manajemen akun penjaga stand (8 akun)
- 📊 Laporan rekap harian dari semua stand (read-only)
- 🔄 **Reset Mingguan** — hapus semua data pesanan & rekap saat pergantian penjaga
- 🔎 Filter pesanan berdasarkan stand, kategori, status, metode bayar
- 🧮 Kalkulator bawaan

---

## Jenis Akun & Peran

Aplikasi ini memiliki **3 jenis akun** dengan hak akses berbeda:

```
┌─────────────────┬──────────────────────────────────────────────────────────┐
│ Peran           │ Akses & Kemampuan                                        │
├─────────────────┼──────────────────────────────────────────────────────────┤
│ 👤 Pembeli      │ Daftar, login, belanja, keranjang, pesanan saya, favorit │
│ 🏪 Penjaga Stand│ Dashboard stand, produk, pesanan, rekap harian, kalkulator│
│ 🔑 Admin        │ Semua data, reset mingguan, rekap semua stand            │
└─────────────────┴──────────────────────────────────────────────────────────┘
```

**Stand yang tersedia (8 stand):**
1. Stand Rekayasa Perangkat Lunak
2. Stand Bisnis Digital
3. Stand Management Perkantoran 1
4. Stand Management Perkantoran 2
5. Stand Akuntansi 1
6. Stand Akuntansi 2
7. Stand Es Buah
8. Stand Kuliner

---

## Panduan Penggunaan

### 👤 Pembeli (User)

#### Daftar Akun
1. Buka halaman utama → klik **Masuk** → pilih **Daftar**
2. Isi nama, email, password → klik **Daftar**
3. Login dengan akun yang sudah dibuat

#### Memesan Makanan
1. Klik **Mulai Belanja** atau **Daftar Stand** di navbar
2. Pilih stand yang diinginkan
3. Lihat produk yang tersedia — klik **Beli Sekarang** untuk checkout cepat, atau **+** untuk masuk keranjang
4. Di halaman **Keranjang**, periksa pesanan → klik **Checkout**
5. Isi data diri (nama, telepon, kelas) → pilih metode bayar (**Tunai** / **QRIS**)
6. Jika QRIS: scan QR yang tampil → selesaikan pembayaran
7. Klik **Proses Pesanan** → pesanan berhasil dibuat

#### Cek Riwayat Pesanan
- Klik **Pesanan Saya** di navbar → lihat semua pesanan beserta statusnya
- Klik **Detail** untuk lihat detail per pesanan

#### Fitur Lain
- **Favorit** — klik ikon ❤️ pada produk untuk simpan ke daftar favorit
- **Profil** — klik nama di navbar → **Profil Saya** untuk ubah nama/password

---

### 🏪 Penjaga Stand

> URL: `/penjaga` — Login dengan akun penjaga yang diberikan admin

#### Dashboard
- Lihat statistik: total produk, tersedia, stok habis, total pesanan, perlu diproses
- Widget **Total Pendapatan** menampilkan akumulasi pendapatan dari pesanan selesai

#### Mengelola Produk
1. Sidebar → **Produk Saya** → klik **+ Tambah Produk**
2. Isi nama, deskripsi, harga, stok, kategori (*Makanan / Minuman / Snack/Cemilan*)
3. Upload foto produk (opsional)
4. Centang **Tersedia** jika produk siap dijual → **Simpan**

#### Memproses Pesanan
1. Sidebar → **Pesanan Masuk**
2. Gunakan filter (status, kategori, metode bayar) untuk menyaring pesanan
3. Klik ikon 👁 untuk lihat detail pesanan
4. Di halaman detail → ubah **Status** menjadi:
   - `Diproses` → pesanan sedang disiapkan
   - `Selesai` → pesanan sudah diambil (**pendapatan otomatis terakumulasi**)
   - `Dibatalkan` → pesanan dibatalkan

#### Rekap Harian
1. Sidebar → **Rekap Harian**
2. Pilih tanggal → klik **Ambil Data** → data otomatis terisi dari sistem
3. Isi **Total Keuntungan** secara manual (setelah dikurangi modal/bahan)
4. Tambahkan **Catatan** (opsional) → klik **Simpan Rekap**
5. Lihat riwayat rekap harian di tabel bawah

#### Kalkulator
- Sidebar → **Kalkulator** — gunakan untuk hitung manual (uang tunai, modal, dll)

#### Info Stand
- Sidebar → **Info Stand** → edit nama, deskripsi, foto, status buka/tutup

---

### 🔑 Admin

> URL: `/admin` — Login dengan akun admin

#### Dashboard
- Lihat ringkasan: total stand, produk, pesanan, pendapatan
- Pantau pesanan terbaru dan daftar stand aktif

#### Kelola Stand
- Menu **Stand** → tambah, edit, atau hapus stand
- Upload foto stand, atur pemilik dan nomor telepon

#### Kelola Produk
- Menu **Produk** → filter berdasarkan stand/kategori → edit/hapus produk

#### Kelola Pesanan
- Menu **Pesanan** → filter berdasarkan stand, kategori, status, metode bayar
- Klik detail untuk lihat informasi lengkap pesanan
- Ubah status pesanan dari sisi admin

#### Rekap Harian (Laporan)
- Menu **Rekap Harian** → lihat laporan dari semua stand
- Filter berdasarkan stand tertentu dan rentang tanggal
- Data bersifat **read-only** (hanya bisa dilihat, tidak bisa diedit oleh admin)

#### Reset Data Mingguan
- Menu **Reset Stand** → digunakan saat **pergantian penjaga stand tiap minggu**
- Pilih stand tertentu atau semua stand
- Ketik `RESET` sebagai konfirmasi → klik **Eksekusi Reset**
- ⚠️ Reset akan **menghapus permanen**: semua pesanan, rekap harian, dan total pendapatan stand

---

## Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Backend Framework | Laravel 11 (PHP 8.2) |
| Frontend | Blade Template + Tailwind CSS CDN |
| Database | MySQL (Railway) / SQLite (lokal) |
| Icons | Font Awesome 6 |
| Font | Google Fonts — Poppins |
| Hosting | Railway (auto-deploy dari GitHub) |
| Version Control | Git + GitHub |

---

## Instalasi Lokal

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL / SQLite
- Node.js (opsional, untuk assets)

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/reieieii/Kantin-Digital.git
cd Kantin-Digital

# 2. Install dependensi PHP
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Konfigurasi database di .env
# Untuk SQLite (mudah):
DB_CONNECTION=sqlite
# Untuk MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=kantin_digital
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Jalankan migrasi dan seeder
php artisan migrate --seed

# 7. Buat storage link
php artisan storage:link

# 8. Jalankan server
php artisan serve
```

Buka browser: `http://localhost:8000`

---

## Struktur Akun Default

Setelah menjalankan seeder, akun berikut tersedia:

### Admin
| Email | Password |
|---|---|
| admin@kantindigital.com | password |

### Penjaga Stand (8 akun)
| Stand | Email | Password |
|---|---|---|
| Rekayasa Perangkat Lunak | penjaga.rpl@kantindigital.com | password |
| Bisnis Digital | penjaga.bd@kantindigital.com | password |
| Management Perkantoran 1 | penjaga.mp1@kantindigital.com | password |
| Management Perkantoran 2 | penjaga.mp2@kantindigital.com | password |
| Akuntansi 1 | penjaga.ak1@kantindigital.com | password |
| Akuntansi 2 | penjaga.ak2@kantindigital.com | password |
| Es Buah | penjaga.esbuah@kantindigital.com | password |
| Kuliner | penjaga.kuliner@kantindigital.com | password |

### Pembeli
Daftar akun baru melalui halaman registrasi.

---

## Alur Pesanan

```
Pembeli memilih produk
        ↓
Masuk Keranjang / Checkout Cepat
        ↓
Isi Data Diri + Pilih Metode Bayar
        ↓
Pesanan dibuat → Status: PENDING
        ↓
Penjaga Stand menerima pesanan → Status: DIPROSES
        ↓
Pesanan siap diambil → Status: SELESAI
        ↓
Pendapatan otomatis terakumulasi di dashboard penjaga
```

---

## Catatan Penting

- **Pergantian penjaga**: Gunakan menu **Reset Stand** di admin setiap awal minggu baru agar data tidak bercampur antar penjaga
- **QRIS**: Gambar QR yang ditampilkan adalah QR statis pemilik sistem
- **Stok**: Stok produk otomatis berkurang setiap kali pesanan berhasil dibuat
- **Pendapatan**: Hanya pesanan berstatus **Selesai** yang menambah total pendapatan stand

---

## Lisensi

Proyek ini dibuat untuk keperluan pendidikan di **SMKN 20 Jakarta**.

---

*Dibuat dengan ❤️ untuk Kantin Digital SMKN 20 Jakarta*
