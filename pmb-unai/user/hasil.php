<?php
require '../config.php';
require '../includes/auth_user.php';
$active = 'hasil';

$stmt = mysqli_prepare($koneksi, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Hasil Test — PMB UNAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="shell">
  <?php include '../includes/user_sidebar.php'; ?>
  <div class="main">
    <div class="topbar-dash"><h2>Hasil Test</h2></div>
    <div class="content">

      <?php if ($user['status_test'] !== 'sudah_test'): ?>
        <div class="empty">
          <div class="ic">📝</div>
          Kamu belum mengerjakan Tes CBT.
          <div style="margin-top:16px"><a href="test.php" class="btn btn-primary">Kerjakan Sekarang</a></div>
        </div>
      <?php else: ?>
        <div class="panel result-hero">
          <div class="lbl" style="color:var(--ink-soft);text-transform:uppercase;letter-spacing:.1em;font-weight:700;font-size:12.5px">Skor Kamu</div>
          <div class="score"><?= h($user['skor_test']) ?><span>/100</span></div>

          <?php if ($user['status_kelulusan'] === 'lulus'): ?>
            <span class="badge badge-ok" style="font-size:14px;padding:8px 20px;margin-top:10px;display:inline-block">✔ LULUS SELEKSI</span>
            <p style="color:var(--ink-soft);margin-top:20px">Selamat! Silakan lanjutkan ke tahap Daftar Ulang untuk mendapatkan NIM.</p>
            <a href="daftar_ulang.php" class="btn btn-gold" style="margin-top:6px">Daftar Ulang Sekarang</a>
          <?php else: ?>
            <span class="badge badge-bad" style="font-size:14px;padding:8px 20px;margin-top:10px;display:inline-block">✘ TIDAK LULUS</span>
            <p style="color:var(--ink-soft);margin-top:20px">Skor belum mencapai minimal kelulusan (<?= PASSING_GRADE ?>). Terima kasih telah mengikuti seleksi PMB UNAI.</p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>
</body>
</html>
