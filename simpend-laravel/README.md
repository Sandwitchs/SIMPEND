# SIMPEND v2 - Sistem Pendaftaran Pendakian Berbasis Laravel

Sistem pendaftaran pendakian yang lebih lengkap dengan fitur-fitur baru yang sebelumnya kurang.


## Fitur yang Ditambahkan
1. **Autentikasi Pendaki & Admin** - Pendaki bisa daftar dan login, admin memiliki akses khusus
2. **Data Detail Anggota Tim** - Menyimpan nama, KTP, usia, dan no HP setiap anggota
3. **Upload Dokumen** - Upload KTP dan surat keterangan sehat
4. **Validasi Kuota Otomatis** - Pengecekan kuota saat menyimpan pendaftaran
5. **Keamanan Lebih Baik** - Password di-hash, CSRF protection, prepared statement
6. **Edit & Cancel Pendaftaran** - Pendaki bisa mengedit/membatalkan pendaftaran yang belum diverifikasi
7. **Cetak Bukti Pendaftaran** - Cetak bukti pendaftaran yang sudah disetujui
8. **Log Aktivitas Admin** - Mencatat siapa yang menyetujui/menolak pendaftaran
9. **Edit Data Gunung** - Admin bisa mengedit data gunung dan kuota


## Cara Setup
1. **Instal Dependensi**
   ```bash
   composer install
   ```

2. **Konfigurasi Database**
   - Buat database baru di MySQL dengan nama `simpend_db`
   - Edit file `.env` sesuai konfigurasi database Anda

3. **Generate APP_KEY**
   ```bash
   php artisan key:generate
   ```

4. **Jalankan Migrasi**
   ```bash
   php artisan migrate
   ```

5. **Buat Akun Admin**
   - Jalankan tinker:
     ```bash
     php artisan tinker
     ```
   - Jalankan perintah ini untuk membuat admin:
     ```php
     User::create([
         'name' => 'Admin',
         'email' => 'admin@simpend.com',
         'password' => Hash::make('password123'),
         'role' => 'admin'
     ]);
     ```

6. **Jalankan Server**
   ```bash
   php artisan serve
   ```

7. **Akses Aplikasi**
   - Pendaki: http://localhost:8000
   - Admin: Login dengan email `admin@simpend.com` dan password `password123`


## Struktur Database
- **users**: Menyimpan data pengguna (pendaki dan admin)
- **gunung**: Menyimpan data gunung dan jalur beserta kuota
- **pendaftaran**: Menyimpan data pendaftaran pendakian
- **anggota_pendaftaran**: Menyimpan data detail anggota tim
- **log_admin**: Mencatat aktivitas admin


## Catatan Penting
- Pastikan direktori `storage` dan `bootstrap/cache` writable
- Untuk upload file, pastikan konfigurasi `upload_max_filesize` dan `post_max_size` di php.ini cukup besar
- Untuk notifikasi email, konfigurasi mail driver di file `.env`
