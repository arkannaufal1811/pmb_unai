<?php
require '../config.php';
require '../includes/auth_user.php';
$active = 'dashboard';

$stmt = mysqli_prepare($koneksi, "SELECT u.*, j.nama_jurusan, j.jenjang FROM users u LEFT JOIN jurusan j ON j.id = u.jurusan_id WHERE u.id = ?");
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$sukses = isset($_GET['registrasi']);

// Status untuk kartu peserta
if ($user['status_daftar_ulang'] === 'sudah') {
    $ticketStatus = 'Mahasiswa Aktif';
    $ticketColor = '#6EE7B7';
} elseif ($user['status_kelulusan'] === 'lulus') {
    $ticketStatus = 'Lulus Seleksi';
    $ticketColor = '#6EE7B7';
} elseif ($user['status_kelulusan'] === 'tidak_lulus') {
    $ticketStatus = 'Tidak Lulus';
    $ticketColor = '#FCA5A5';
} elseif ($user['status_test'] === 'sudah_test') {
    $ticketStatus = 'Menunggu Hasil';
    $ticketColor = '#E9B949';
} else {
    $ticketStatus = 'Terdaftar';
    $ticketColor = '#DDD1F7';
}
$jenjangText = $user['jenjang'] ? h($user['jenjang']) . ' · Reguler' : 'Reguler';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard — PMB UNAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="shell">
  <?php include '../includes/user_sidebar.php'; ?>
  <div class="main">
    <div class="topbar-dash">
      <h2>Dashboard</h2>
      <span class="badge badge-neutral">Nomor Test: <?= h($user['nomor_test']) ?></span>
    </div>
    <div class="content">

      <?php if ($sukses): ?>
        <div class="alert alert-ok">Registrasi berhasil! Nomor test kamu adalah <b><?= h($user['nomor_test']) ?></b>. Silakan lanjutkan ke Tes CBT.</div>
      <?php endif; ?>

      <div class="dash-ticket">
        <div class="top">
          <div>
            <div class="label">Kartu Peserta</div>
            <div class="wave">UNAI PMB 2026</div>
          </div>
          <div class="qr-wrap">
            <div id="dash-ticket-qr"></div>
            <img src="../assets/img/logo-unai.png" alt="UNAI" class="qr-logo">
          </div>
        </div>
        <div class="tline"></div>
        <div class="grid">
          <div class="item"><span>Nama</span><b><?= h($user['nama']) ?></b></div>
          <div class="item"><span>Nomor Test</span><b><?= h($user['nomor_test']) ?></b></div>
          <div class="item"><span>Jenjang</span><b><?= $jenjangText ?></b></div>
          <div class="item"><span>Status</span><b style="color:<?= $ticketColor ?>"><?= $ticketStatus ?></b></div>
        </div>
      </div>

      <div class="cards-row">
        <div class="stat-card">
          <div class="lbl">Nomor Test</div>
          <div class="val" style="font-size:20px"><?= h($user['nomor_test']) ?></div>
        </div>
        <div class="stat-card">
          <div class="lbl">Status Tes</div>
          <div class="val" style="font-size:20px">
            <?= $user['status_test'] === 'sudah_test' ? 'Selesai' : 'Belum Test' ?>
          </div>
        </div>
        <div class="stat-card gold">
          <div class="lbl">Skor Test</div>
          <div class="val"><?= $user['skor_test'] !== null ? h($user['skor_test']) : '-' ?></div>
        </div>
        <div class="stat-card">
          <div class="lbl">Status Kelulusan</div>
          <div class="val" style="font-size:20px">
            <?php if ($user['status_kelulusan'] === 'lulus'): ?>
              <span class="badge badge-ok">LULUS</span>
            <?php elseif ($user['status_kelulusan'] === 'tidak_lulus'): ?>
              <span class="badge badge-bad">TIDAK LULUS</span>
            <?php else: ?>
              <span class="badge badge-warn">MENUNGGU</span>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="panel">
        <h3>Data Diri</h3>
        <table>
          <tbody>
            <tr><td style="width:220px;color:var(--ink-soft)">Nama Lengkap</td><td><b><?= h($user['nama']) ?></b></td></tr>
            <tr><td style="color:var(--ink-soft)">Email</td><td><?= h($user['email']) ?></td></tr>
            <tr><td style="color:var(--ink-soft)">No. HP</td><td><?= h($user['no_hp']) ?: '-' ?></td></tr>
            <tr><td style="color:var(--ink-soft)">Pilihan Jurusan</td><td><?= h($user['nama_jurusan']) ?: 'Belum menentukan' ?></td></tr>
            <tr><td style="color:var(--ink-soft)">Status Daftar Ulang</td><td>
              <?= $user['status_daftar_ulang'] === 'sudah' ? '<span class="badge badge-ok">Sudah Daftar Ulang</span>' : '<span class="badge badge-neutral">Belum</span>' ?>
            </td></tr>
            <?php if ($user['nim']): ?>
            <tr><td style="color:var(--ink-soft)">NIM</td><td><b style="color:var(--violet-800)"><?= h($user['nim']) ?></b></td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="panel">
        <h3>Langkah Selanjutnya</h3>
        <?php if ($user['status_test'] !== 'sudah_test'): ?>
          <p style="color:var(--ink-soft);margin-bottom:16px">Kamu belum mengerjakan Tes CBT. Kerjakan sekarang untuk melanjutkan proses seleksi.</p>
          <a href="test.php" class="btn btn-primary">Mulai Tes CBT</a>
        <?php elseif ($user['status_kelulusan'] === 'menunggu'): ?>
          <p style="color:var(--ink-soft)">Tes sudah selesai. Hasil kelulusan sedang diverifikasi oleh admin.</p>
        <?php elseif ($user['status_kelulusan'] === 'lulus' && $user['status_daftar_ulang'] === 'belum'): ?>
          <p style="color:var(--ink-soft);margin-bottom:16px">Selamat, kamu dinyatakan LULUS! Segera lakukan daftar ulang untuk mendapatkan NIM.</p>
          <a href="daftar_ulang.php" class="btn btn-gold">Daftar Ulang Sekarang</a>
        <?php elseif ($user['status_kelulusan'] === 'tidak_lulus'): ?>
          <p style="color:var(--ink-soft)">Mohon maaf, kamu belum lulus seleksi kali ini.</p>
        <?php else: ?>
          <p style="color:var(--ink-soft)">Proses pendaftaranmu sudah lengkap. Selamat menjadi mahasiswa UNAI!</p>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
  new QRCode(document.getElementById("dash-ticket-qr"), {
    text: "https://pmb.unai.ac.id/status?no=<?= urlencode($user['nomor_test']) ?>",
    width: 64,
    height: 64,
    colorDark: "#211334",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
  });
</script>
</body>
</html>
