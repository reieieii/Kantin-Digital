# MIGRASI DATABASE DARI SQLITE KE MYSQL/PHPMYADMIN

## LANGKAH 1: BUAT DATABASE DI PHPMYADMIN
1. Buka browser: http://localhost/phpmyadmin
2. Klik "New" di sidebar kiri
3. Masukkan nama database: kantin_web
4. Klik "Create"

## LANGKAH 2: UPDATE FILE .ENV
Buka file .env dan ganti konfigurasi database:

# HAPUS atau COMMENT baris ini:
# DB_CONNECTION=sqlite

# TAMBAHKAN konfigurasi MySQL ini:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kantin_web
DB_USERNAME=root
DB_PASSWORD=

## LANGKAH 3: JALANKAN MIGRASI
Buka terminal di project folder dan jalankan:

php artisan migrate

## LANGKAH 4: ISI DATA AWAL
Jalankan seeder untuk mengisi data:

php artisan db:seed

## LANGKAH 5: VERIFIKASI
Cek database di phpMyAdmin:
- Tabel stands (2 data)
- Tabel produks (3 data)
- Tabel users (1 data)

## LANGKAH 6: TEST APLIKASI
Buka: http://127.0.0.1:8000
- Landing page harus normal
- Halaman stands menampilkan data
- Detail stand menampilkan produk

## TROUBLESHOOTING
Jika error "Access denied":
- Pastikan MySQL/XAMPP running
- Username: root, Password: (kosong)
- Database name: kantin_web

Jika error migration:
- Hapus semua tabel di phpMyAdmin
- Jalankan ulang: php artisan migrate:fresh --seed
