# Nutrition Rescue Mission - LMS System (Pro Version)

Sistem Manajemen Pembelajaran (LMS) modern yang dibangun dengan Laravel, TailwindCSS, dan Blade. Didesain khusus untuk sekolah dengan alur yang mobile-first dan production-ready.

## 🚀 Fitur Utama

### Role: Siswa
- **Login Sederhana**: Masuk hanya dengan Nama dan NISN.
- **Progress Tracking**: Progress tersimpan otomatis setiap menyelesaikan bab.
- **Unlockable Post Test**: Post test hanya terbuka setelah seluruh materi selesai dibaca.
- **Hasil Instan**: Skor otomatis dihitung dan status kelulusan ditampilkan.
- **Dashboard Modern**: Visualisasi progress dan pembelajaran terbaru yang menarik.

### Role: Admin
- **Manajemen Sekolah**: Kelola daftar sekolah yang terintegrasi.
- **Manajemen Siswa**: Buat, edit, dan kelola akun siswa.
- **Manajemen Kursus**: Upload thumbnail dan deskripsi kursus.
- **Manajemen Bab (Lessons)**: Atur urutan bab dan konten video/materi.
- **Manajemen Soal**: Buat bank soal pilihan ganda untuk post test.
- **Monitoring Nilai**: Pantau seluruh hasil test siswa secara real-time.

---

## 🛠️ Instalasi Lokal

Ikuti langkah berikut untuk menjalankan proyek di komputer Anda:

1. **Clone/Download Project**
   Pastikan Anda sudah memiliki PHP >= 8.2 dan Composer.

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi & Seed Database**
   ```bash
   php artisan migrate --seed
   ```

5. **Link Storage (Untuk Thumbnail)**
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Server**
   ```bash
   # Terminal 1
   php artisan serve
   
   # Terminal 2
   npm run dev
   ```

---

## 🔑 Akun Dummy (Seeder)

Gunakan akun berikut untuk mencoba sistem:

### Admin
- **Username/Email**: `admin` / `admin@lms.com`
- **Password**: `password`

### Siswa
- **Nama (Username)**: `12345678` (NISN)
- **NISN (Password)**: `12345678`

---

## 🌐 Panduan Deployment ke VPS (Ubuntu/Nginx)

1. **Persiapan Server**
   Install Nginx, MariaDB, PHP 8.2, dan Composer.
   ```bash
   sudo apt update && sudo apt upgrade
   sudo apt install nginx mariadb-server php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl unzip
   ```

2. **Setup Database**
   Buat database baru untuk LMS.
   ```sql
   CREATE DATABASE lms_db;
   CREATE USER 'lms_user'@'localhost' IDENTIFIED BY 'password_aman';
   GRANT ALL PRIVILEGES ON lms_db.* TO 'lms_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

3. **Deploy Code**
   Upload file ke `/var/www/lms` dan jalankan perintah instalasi di atas.

4. **Konfigurasi Nginx**
   Buat file config di `/etc/nginx/sites-available/lms`:
   ```nginx
   server {
       listen 80;
       server_name domain-anda.com;
       root /var/www/lms/public;

       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";

       index index.php;
       charset utf-8;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
   }
   ```
   Lalu aktifkan: `sudo ln -s /etc/nginx/sites-available/lms /etc/nginx/sites-enabled/` dan restart nginx.

5. **SSL (Optional but Recommended)**
   Gunakan Certbot untuk HTTPS: `sudo certbot --nginx -d domain-anda.com`

---

## 🏗️ Tech Stack
- **Framework**: Laravel 12
- **Frontend**: Blade + TailwindCSS
- **Database**: MariaDB/MySQL
- **Icons**: FontAwesome 6
- **Fonts**: Plus Jakarta Sans
