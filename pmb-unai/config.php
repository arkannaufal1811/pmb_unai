<?php
/**
 * Konfigurasi koneksi database
 * Sesuaikan DB_USER / DB_PASS dengan pengaturan MySQL/XAMPP di komputer Anda.
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pmb_unai');

define('PASSING_GRADE', 60); // skor minimal (dari 100) untuk dinyatakan LULUS

$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error() .
        '<br>Pastikan MySQL aktif dan database "pmb_unai" sudah di-import (lihat database.sql).');
}

mysqli_set_charset($koneksi, 'utf8mb4');

session_start();

function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function generate_nomor_test($koneksi) {
    $tahun = date('Y');
    $prefix = 'UNAI' . $tahun;
    do {
        $angka = str_pad((string) random_int(0, 99999), 5, '0', STR_PAD_LEFT);
        $nomor = $prefix . $angka;
        $cek = mysqli_query($koneksi, "SELECT id FROM users WHERE nomor_test = '" . mysqli_real_escape_string($koneksi, $nomor) . "'");
    } while (mysqli_num_rows($cek) > 0);
    return $nomor;
}
