<?php
/**
 * JALANKAN FILE INI SATU KALI SAJA lewat browser setelah import database.sql,
 * contoh: http://localhost/pmb-unai/setup.php
 * File ini akan meng-hash password admin default dengan aman (bcrypt).
 * Setelah berhasil, sebaiknya file ini dihapus dari server.
 */
require 'config.php';

$username = 'Arkan Naufal';
$passwordBaru = 'naufal1811';
$hash = password_hash($passwordBaru, PASSWORD_BCRYPT);

$stmt = mysqli_prepare($koneksi, "UPDATE admin SET password = ? WHERE username = ?");
mysqli_stmt_bind_param($stmt, 'ss', $hash, $username);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) >= 0) {
    echo "<div style='font-family:sans-serif;max-width:520px;margin:60px auto;padding:24px;border:1px solid #ddd;border-radius:12px'>";
    echo "<h2 style='color:#4C1D95'>Setup selesai ✅</h2>";
    echo "<p>Password admin default sudah di-hash dengan aman.</p>";
    echo "<p><b>Username:</b> Arkan Naufal<br><b>Password:</b> naufal1811</p>";
    echo "<p style='color:#b91c1c'>Untuk keamanan, hapus file <code>setup.php</code> ini dari server sekarang.</p>";
    echo "<a href='login.php' style='display:inline-block;margin-top:12px;background:#4C1D95;color:#fff;padding:10px 18px;border-radius:8px;text-decoration:none'>Ke halaman Login</a>";
    echo "</div>";
} else {
    echo "Gagal setup. Pastikan database sudah di-import dengan benar.";
}
