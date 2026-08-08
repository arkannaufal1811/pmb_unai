<?php
require '../config.php';
require '../includes/auth_user.php';
$active = 'daftar_ulang';

$stmt = mysqli_prepare($koneksi, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user['status_kelulusan'] === 'lulus' && $user['status_daftar_ulang'] === 'belum') {
    $tahun = date('Y');
    $nim = $tahun . str_pad((string) $user['id'], 5, '0', STR_PAD_LEFT);

    $upd = mysqli_prepare($koneksi, "UPDATE users SET status_daftar_ulang = 'sudah', nim = ? WHERE id = ?");
    mysqli_stmt_bind_param($upd, 'si', $nim, $_SESSION['user_id']);
    mysqli_stmt_execute($upd);

    header('Location: daftar_ulang.php?sukses=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Ulang — PMB UNAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="shell">
  <?php include '../includes/user_sidebar.php'; ?>
  <div class="main">
    <div class="topbar-dash"><h2>Daftar Ulang</h2></div>
    <div class="content">

      <?php if (isset($_GET['sukses'])): ?>
        <div class="alert alert-ok">Daftar ulang berhasil! Selamat datang menjadi mahasiswa UNAI 🎉</div>
      <?php endif; ?>

      <?php if ($user['status_kelulusan'] !== 'lulus'): ?>
        <div class="empty">
          <div class="ic">🔒</div>
          Daftar ulang hanya tersedia untuk calon mahasiswa yang dinyatakan <b>LULUS</b> seleksi.
        </div>
      <?php elseif ($user['status_daftar_ulang'] === 'sudah'): ?>
        <div class="panel result-hero">
          <div class="lbl" style="color:var(--ink-soft);text-transform:uppercase;letter-spacing:.1em;font-weight:700;font-size:12.5px">Nomor Induk Mahasiswa</div>
          <div class="score" style="font-size:52px"><?= h($user['nim']) ?></div>
          <p style="color:var(--ink-soft);margin-top:16px">Selamat! Kamu resmi menjadi mahasiswa Universitas Arkan Indonesia.</p>
        </div>
      <?php else: ?>
        <div class="panel" style="max-width:600px">
          <h3>Konfirmasi Daftar Ulang</h3>
          <p style="color:var(--ink-soft);margin-bottom:20px">Kamu dinyatakan <b style="color:var(--ok)">LULUS</b> seleksi PMB UNAI dengan skor <b><?= h($user['skor_test']) ?></b>. Klik tombol di bawah untuk menyelesaikan daftar ulang dan mendapatkan Nomor Induk Mahasiswa (NIM).</p>
          <form method="POST" onsubmit="return confirmAction('Selesaikan daftar ulang sekarang?');">
            <button type="submit" class="btn btn-gold" style="width:100%">Selesaikan Daftar Ulang</button>
          </form>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
