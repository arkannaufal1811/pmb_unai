# PMB UNAI — Aplikasi Pendaftaran Mahasiswa Baru
Universitas Arkan Indonesia (UNAI)

Aplikasi berbasis **HTML, CSS, JavaScript, PHP, dan MySQL** dengan 2 aktor:
- **Admin** — kelola data calon maba, soal test, dan pantau hasil seleksi.
- **User (Calon Maba)** — daftar, dapat nomor test, kerjakan tes CBT, lihat hasil, daftar ulang.

## 1. Kebutuhan
- Web server dengan PHP 7.4+ (disarankan pakai **XAMPP** / **Laragon**)
- MySQL / MariaDB
- Ekstensi PHP: `mysqli`

## 2. Cara Instalasi (pakai XAMPP)
1. Copy folder `pmb-unai` ke dalam `htdocs` (XAMPP) atau `www` (Laragon).
2. Jalankan Apache & MySQL dari XAMPP/Laragon Control Panel.
3. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`), buat database baru
   atau langsung **import** file `database.sql` (database `pmb_unai` akan
   otomatis dibuat beserta tabel & data contohnya).
4. Cek pengaturan koneksi di `config.php` jika username/password MySQL kamu
   berbeda dari default XAMPP (`root` tanpa password).
5. Buka browser ke:
   ```
   http://localhost/pmb-unai/setup.php
   ```
   Jalankan **satu kali saja** — ini akan meng-hash password admin default
   dengan aman. Setelah muncul pesan "Setup selesai", hapus file
   `setup.php` dari server untuk keamanan.
6. Buka `http://localhost/pmb-unai/index.php` — aplikasi siap digunakan.

## 3. Akun Login

### Admin
- Buka halaman **Login**, pilih tab **Admin**.
- Username: `Arkan Naufal`
- Password: `naufal1811`

### Calon Mahasiswa (User)
- Daftar akun baru lewat halaman **Daftar** — nomor test akan dibuat otomatis.
- Atau admin bisa menambahkan calon maba manual lewat menu **Data Calon Maba**
  (password awal default: `unai12345`, bisa diganti sesuai kebutuhan).

## 4. Struktur Folder
```
pmb-unai/
├── database.sql            # skema + data awal database
├── config.php               # koneksi database & helper
├── setup.php                # jalankan sekali untuk hash password admin
├── index.php                 # landing page publik
├── login.php                 # login gabungan admin/user (toggle role)
├── register.php               # registrasi calon maba
├── logout.php
├── assets/
│   ├── css/style.css         # tema ungu UNAI
│   └── js/script.js
├── includes/
│   ├── auth_admin.php        # guard halaman admin
│   ├── auth_user.php         # guard halaman user
│   ├── admin_sidebar.php
│   └── user_sidebar.php
├── admin/
│   ├── dashboard.php
│   ├── calon_maba.php        # CRUD data calon maba
│   ├── soal.php               # CRUD soal test CBT
│   ├── pendaftar.php          # list yang sudah mendaftar
│   ├── lulus.php               # list lulus/tidak lulus + ubah status manual
│   └── daftar_ulang.php       # list yang sudah daftar ulang
└── user/
    ├── dashboard.php
    ├── test.php                # pengerjaan tes CBT
    ├── hasil.php                # hasil test & status kelulusan
    └── daftar_ulang.php        # konfirmasi daftar ulang, dapat NIM
```

## 5. Alur Sistem
1. Calon maba **registrasi** → otomatis dapat **nomor test**.
2. Calon maba login → kerjakan **Tes CBT** di menu Tes CBT.
3. Skor dihitung otomatis; jika ≥ 60 maka **LULUS** (bisa diubah di
   `config.php` konstanta `PASSING_GRADE`, atau admin bisa override manual
   lewat menu **Lulus / Tidak Lulus**).
4. Jika lulus, calon maba melakukan **Daftar Ulang** → sistem menghasilkan
   **NIM (Nomor Induk Mahasiswa)** otomatis.
5. Admin bisa memantau semua data lewat menu **Data Calon Maba**,
   **List Pendaftar**, **Lulus/Tidak Lulus**, dan **Daftar Ulang**.

## 6. Catatan Keamanan
- Semua password di-hash menggunakan `password_hash()` (bcrypt).
- Query database menggunakan **prepared statements** untuk mencegah SQL Injection.
- Hapus `setup.php` setelah dipakai sekali di server produksi.
