-- =====================================================================
-- Database: pmb_unai
-- Aplikasi Pendaftaran Mahasiswa Baru - Universitas Arkan Indonesia (UNAI)
-- =====================================================================

CREATE DATABASE IF NOT EXISTS pmb_unai CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pmb_unai;

-- ---------------------------------------------------------------------
-- Tabel admin
-- ---------------------------------------------------------------------
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Akun admin default (username: Arkan Naufal / password: naufal1811)
-- Password di-hash otomatis & aman lewat setup.php (jalankan SEKALI lewat browser
-- setelah import database ini). Baris di bawah hanya membuat barisnya dahulu.
INSERT INTO admin (nama, username, password) VALUES
('Arkan Naufal', 'Arkan Naufal', 'CHANGE_ME');

-- ---------------------------------------------------------------------
-- Tabel jurusan (bebas / dapat ditambah admin)
-- ---------------------------------------------------------------------
CREATE TABLE jurusan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_jurusan VARCHAR(150) NOT NULL,
    jenjang VARCHAR(20) NOT NULL DEFAULT 'S1'
);

INSERT INTO jurusan (nama_jurusan, jenjang) VALUES
('Teknik Informatika', 'S1'),
('Sistem Informasi', 'S1'),
('Manajemen', 'S1'),
('Akuntansi', 'S1'),
('Ilmu Komunikasi', 'S1'),
('Desain Komunikasi Visual', 'S1'),
('Hukum', 'S1'),
('Psikologi', 'S1');

-- ---------------------------------------------------------------------
-- Tabel calon mahasiswa baru (user)
-- ---------------------------------------------------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_test VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    no_hp VARCHAR(20) DEFAULT NULL,
    jurusan_id INT DEFAULT NULL,
    skor_test INT DEFAULT NULL,
    status_test ENUM('belum_test','sudah_test') NOT NULL DEFAULT 'belum_test',
    status_kelulusan ENUM('menunggu','lulus','tidak_lulus') NOT NULL DEFAULT 'menunggu',
    status_daftar_ulang ENUM('belum','sudah') NOT NULL DEFAULT 'belum',
    nim VARCHAR(30) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jurusan_id) REFERENCES jurusan(id) ON DELETE SET NULL
);

-- ---------------------------------------------------------------------
-- Tabel soal test (CBT)
-- ---------------------------------------------------------------------
CREATE TABLE soal_test (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pertanyaan TEXT NOT NULL,
    pilihan_a VARCHAR(255) NOT NULL,
    pilihan_b VARCHAR(255) NOT NULL,
    pilihan_c VARCHAR(255) NOT NULL,
    pilihan_d VARCHAR(255) NOT NULL,
    jawaban_benar ENUM('A','B','C','D') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO soal_test (pertanyaan, pilihan_a, pilihan_b, pilihan_c, pilihan_d, jawaban_benar) VALUES
('Ibu kota Indonesia adalah...', 'Bandung', 'Jakarta', 'Surabaya', 'Medan', 'B'),
('9 x 8 = ...', '62', '68', '72', '81', 'C'),
('Lawan kata dari "rajin" adalah...', 'Giat', 'Malas', 'Cerdas', 'Ulet', 'B'),
('Proklamasi Kemerdekaan Indonesia dibacakan pada tanggal...', '17 Agustus 1945', '20 Mei 1908', '28 Oktober 1928', '10 November 1945', 'A'),
('Satuan SI untuk kuat arus listrik adalah...', 'Volt', 'Watt', 'Ampere', 'Ohm', 'C');

-- ---------------------------------------------------------------------
-- Tabel jawaban user per soal (opsional, untuk histori)
-- ---------------------------------------------------------------------
CREATE TABLE jawaban_user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    soal_id INT NOT NULL,
    jawaban_dipilih ENUM('A','B','C','D') DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (soal_id) REFERENCES soal_test(id) ON DELETE CASCADE
);
