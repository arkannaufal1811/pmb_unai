<?php
require '../config.php';
require '../includes/auth_admin.php';
$active = 'dashboard';

$total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM users"))['c'];
$sudahTest = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM users WHERE status_test = 'sudah_test'"))['c'];
$lulus = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM users WHERE status_kelulusan = 'lulus'"))['c'];
$daftarUlang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM users WHERE status_daftar_ulang = 'sudah'"))['c'];

$terbaru = mysqli_query($koneksi, "SELECT u.*, j.nama_jurusan FROM users u LEFT JOIN jurusan j ON j.id = u.jurusan_id ORDER BY u.created_at DESC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin — PMB UNAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="shell">
  <?php include '../includes/admin_sidebar.php'; ?>
  <div class="main">
    <div class="topbar-dash"><h2>Dashboard Admin</h2></div>
    <div class="content">

      <div class="cards-row">
        <div class="stat-card"><div class="lbl">Total Pendaftar</div><div class="val"><?= $total ?></div></div>
        <div class="stat-card"><div class="lbl">Sudah Tes CBT</div><div class="val"><?= $sudahTest ?></div></div>
        <div class="stat-card gold"><div class="lbl">Dinyatakan Lulus</div><div class="val"><?= $lulus ?></div></div>
        <div class="stat-card"><div class="lbl">Sudah Daftar Ulang</div><div class="val"><?= $daftarUlang ?></div></div>
      </div>

      <div class="panel">
        <h3>Pendaftar Terbaru</h3>
        <table>
          <thead><tr><th>Nomor Test</th><th>Nama</th><th>Jurusan</th><th>Status Tes</th><th>Kelulusan</th></tr></thead>
          <tbody>
            <?php if (mysqli_num_rows($terbaru) === 0): ?>
              <tr><td colspan="5" style="text-align:center;color:var(--ink-soft)">Belum ada pendaftar.</td></tr>
            <?php endif; ?>
            <?php while ($r = mysqli_fetch_assoc($terbaru)): ?>
              <tr>
                <td><?= h($r['nomor_test']) ?></td>
                <td><?= h($r['nama']) ?></td>
                <td><?= h($r['nama_jurusan']) ?: '-' ?></td>
                <td><?= $r['status_test'] === 'sudah_test' ? '<span class="badge badge-ok">Selesai</span>' : '<span class="badge badge-neutral">Belum</span>' ?></td>
                <td>
                  <?php if ($r['status_kelulusan'] === 'lulus'): ?><span class="badge badge-ok">Lulus</span>
                  <?php elseif ($r['status_kelulusan'] === 'tidak_lulus'): ?><span class="badge badge-bad">Tidak Lulus</span>
                  <?php else: ?><span class="badge badge-warn">Menunggu</span><?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
</body>
</html>
