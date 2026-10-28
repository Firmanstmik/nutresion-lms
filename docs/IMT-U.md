# Status Gizi (IMT/U) — Nutresion LMS

Fitur ini menghitung Indeks Massa Tubuh (IMT), Z-score IMT menurut umur (IMT/U), dan
kategori status gizi untuk siswa usia **14 tahun 0 bulan sampai sebelum 19 tahun**.
Hasilnya adalah penilaian antropometri, **bukan diagnosis medis**.

## Cara pakai

### Siswa
1. Buka menu **Status Gizi** (navbar desktop, menu akun, atau tombol *Cek Status Gizi* di halaman Profil).
2. **Langkah 1 – Data profil:** isi tanggal lahir dan jenis kelamin, lalu *Simpan data profil*.
3. **Langkah 2 – Pengukuran baru:** isi tanggal pengukuran, berat badan (kg), dan tinggi badan (cm), lalu *Hitung & simpan*.
4. Halaman hasil menampilkan IMT, Z-score, kategori, usia saat pengukuran, dan tanggal pengukuran.
   Setiap pengukuran disimpan sebagai riwayat baru; riwayat lama tidak ditimpa.

### Admin
1. **Admin › Siswa**, klik ikon ❤ (*Status Gizi*) pada baris siswa, atau tombol *Status Gizi* di halaman Aktivitas.
2. Admin dapat melengkapi/mengoreksi tanggal lahir & jenis kelamin siswa, menambah pengukuran
   (tercatat sebagai *Dicatat oleh* admin tersebut), dan melihat seluruh riwayat siswa.

## Metode perhitungan

| Langkah | Aturan |
|---|---|
| IMT | `berat_kg / (tinggi_cm / 100)²` |
| Usia (validasi & tampilan) | Bulan kalender penuh antara tanggal lahir dan tanggal pengukuran. Lahir tgl 31 → bulan dianggap genap pada hari terakhir bulan yang lebih pendek; lahir 29 Feb → ulang tahun di tahun non-kabisat jatuh 28 Feb. |
| Usia (lookup referensi) | `selisih_hari / 30.4375` (konstanta `ANTHRO_DAYS_OF_MONTH` WHO). L, M, S diinterpolasi linear antara dua bulan bulat di sekitarnya — sama dengan paket R resmi WHO `anthroplus` (`zscore_indicator`). |
| Z-score | Metode LMS: `z = ((IMT/M)^L − 1) / (L·S)`; jika `L = 0` dipakai limitnya `ln(IMT/M)/S`. |
| Koreksi ekstrem | Jika `z > 3`: `z* = 3 + (IMT − SD3pos) / (SD3pos − SD2pos)`. Jika `z < −3`: `z* = −3 + (IMT − SD3neg) / (SD2neg − SD3neg)`. Sesuai WHO *computation.pdf* dan `anthro::compute_zscore_adjusted`. |
| Pembulatan | Tidak ada pembulatan sebelum kategori ditentukan. Database menyimpan IMT & Z dengan 4 desimal. Tampilan: IMT 1 desimal, Z 2 desimal. |

Seluruh perhitungan ada di `app/Services/NutritionAssessmentService.php`. Controller hanya memvalidasi
input dan menyimpan hasil; IMT, Z-score, kategori, dan `user_id` **tidak pernah** diambil dari browser.

## Kategori (Permenkes No. 2 Tahun 2020, IMT/U; batas WHO 2007)

| Kategori | Kode | Batas Z-score |
|---|---|---|
| Gizi buruk (*severely thinness*) | `severely_thinness` | Z < −3 |
| Gizi kurang (*thinness*) | `thinness` | −3 ≤ Z < −2 |
| Gizi baik (*normal*) | `normal` | −2 ≤ Z ≤ +1 |
| Gizi lebih (*overweight*) | `overweight` | +1 < Z ≤ +2 |
| Obesitas (*obese*) | `obese` | Z > +2 |

Karena kategori memakai Z yang belum dibulatkan, nilai seperti −2,004 tampil sebagai "−2,00" tetapi
termasuk *Gizi kurang*. Kategori IMT dewasa (kurus/normal/BB lebih/obesitas I–II) **tidak** dipakai.

## Rentang usia

- Didukung: 168–227 bulan penuh (14 th 0 bl s.d. 18 th 11 bl, yaitu sebelum ulang tahun ke-19).
- Di luar rentang itu pengukuran **ditolak** dengan pesan yang jelas; tidak ada fallback ke kategori dewasa.
- Batas atas mengikuti cakupan IMT/U Permenkes 2/2020 Pasal 4 ayat (1) huruf e ("lebih dari 5 sampai dengan 18 tahun"),
  walaupun tabel WHO mencakup sampai 228 bulan. Baris 61–228 tetap disimpan agar interpolasi di batas usia memakai data resmi.

## Sumber referensi

| Berkas | Keterangan |
|---|---|
| `resources/data/who2007/bmi-boys-z-who-2007-exp.xlsx` | Salinan resmi WHO, laki-laki. SHA-256 `0a60849673f34a06b8e2fe4defe5d00348de687b6c9fce0278f1525fff89eb6d` |
| `resources/data/who2007/bmi-girls-z-who-2007-exp.xlsx` | Salinan resmi WHO, perempuan. SHA-256 `66f5c6284b44579ad6135fc639f22c09e36fe5a695b04390377113f6a00deb72` |
| `resources/data/who2007/bmi_for_age.php` | Data yang dipakai aplikasi (L, M, S, −3…+3 SD per bulan 61–228), dibuat dari dua xlsx di atas tanpa pembulatan ulang. Tidak ada request HTTP saat siswa menghitung. |

- Halaman WHO: https://www.who.int/tools/growth-reference-data-for-5to19-years/indicators/bmi-for-age
- Metode Z-score WHO: https://cdn.who.int/media/docs/default-source/child-growth/growth-reference-5-19-years/computation.pdf?sfvrsn=c2ff6a95_4
- Kode resmi WHO: https://github.com/WorldHealthOrganization/anthroplus (`R/zscores.R`) dan https://github.com/WorldHealthOrganization/anthro (`compute_zscore_adjusted`)
- Permenkes 2/2020: https://pasal.id/peraturan/permen/permenkes-no-2-tahun-2020

Unit test `test_lms_reproduces_every_published_sd_column` menghitung ulang setiap kolom SD (−3…+3) dari L, M, S
untuk kedua jenis kelamin dan semua bulan; tes ini gagal jika data atau rumus berubah.

### Tentang `Tabel_IMT_Usia_14-19_Tahun.docx`

Dokumen Word di root repo **dipertahankan tetapi tidak dipakai sebagai sumber perhitungan**:
- Dibuat dengan python-docx dari foto (tidak ada label jenis kelamin; foto asli tidak tersedia).
- 425 dari 427 nilainya cocok dengan tabel WHO 2007 **laki-laki** (dibulatkan 1 desimal), dan tidak cocok dengan tabel perempuan.
- Dua sel berbeda dari WHO: 16 th 6 bl kolom +2 SD (docx 28,2; WHO 28,271) dan 16 th 7 bl kolom +1 SD (docx 23,9; WHO 23,972).
- Tidak memuat L, M, S sehingga metode LMS tidak bisa dijalankan darinya.

## Data & migration

Dua migration baru (aditif, aman dijalankan ulang karena memakai `hasColumn`/`hasTable`):

1. `2026_10_28_000001_add_birth_date_and_sex_to_users_table` — `users.birth_date` (date, nullable) dan `users.sex` (`male`/`female`, nullable). Akun lama tetap bisa login tanpa mengisi data ini.
2. `2026_10_28_000002_create_nutrition_measurements_table` — satu baris per pengukuran: `user_id`, `recorded_by`, `measured_at`, snapshot `birth_date`/`sex`/`age_months`, `weight_kg`, `height_cm`, `bmi`, `z_score`, `category`, `reference_version`. Menghapus siswa juga menghapus pengukurannya (cascade, sama seperti hasil tes).

### Pengembangan lokal

```bash
php artisan migrate          # JANGAN migrate:fresh / db:wipe pada database berisi data
php artisan test             # atau: vendor/bin/phpunit
php artisan test --filter=Nutrition
```

Pengujian memakai SQLite in-memory (`phpunit.xml`). Pastikan `bootstrap/cache/config.php` tidak ada
sebelum menjalankan tes, agar tes tidak memakai koneksi database dari `.env`.

### Deployment (checklist)

1. Backup database produksi.
2. Deploy kode (termasuk folder `resources/data/who2007/`).
3. `php artisan migrate --force` (hanya menambah kolom/tabel; tidak menyentuh data lama).
4. Jika memakai cache: `php artisan config:cache && php artisan route:cache && php artisan view:clear`.
5. Uji cepat: login sebagai siswa → Status Gizi → isi profil → simpan satu pengukuran; login admin → Siswa → ikon Status Gizi.
6. Rollback (bila perlu): `php artisan migrate:rollback --step=2` menghapus tabel `nutrition_measurements` dan kolom baru di `users` beserta isinya.

## Catatan tampilan & pekerjaan terpisah

- Pesan validasi fitur ini berbahasa Indonesia lewat pesan kustom di `NutritionController`
  (`VALIDATION_MESSAGES`); tanggal di kartu hasil memakai `locale('id')` per tampilan.
  `APP_LOCALE` aplikasi tetap `en` dan tidak diubah.
- Riwayat pengukuran tampil sebagai kartu di layar < 640 px dan sebagai tabel mulai 640 px.
- Script layout (`layouts/app.blade.php`) dibungkus guard `window.__nrnLayoutBooted` karena Turbo
  menjalankan ulang script di `<body>` setiap navigasi (sebelumnya memicu
  `Identifier 'nrnSetupUI' has already been declared`).

Di luar ruang lingkup fitur ini (perlu tiket terpisah):

1. Lokalisasi global: halaman lain masih memakai pesan validasi bawaan bahasa Inggris dan format
   `d M Y` berbahasa Inggris. Perbaikannya butuh `lang/id/validation.php` + `APP_LOCALE=id`
   dan uji regresi seluruh halaman.
2. Halaman `/admin` (dashboard) lebih lebar 8 px dari viewport di semua ukuran; sudah ada sebelum fitur ini.
3. Halaman pre-test/post-test tidak bisa dibuka dengan data `DatabaseSeeder` (dialihkan ke halaman
   kursus oleh logika tes yang ada); visual QA halaman tes perlu data uji yang sesuai.
