<?php
require '../config.php';
require '../includes/auth_admin.php';
$active = 'pendaftar';

$dataList = mysqli_query($koneksi, "SELECT u.*, j.nama_jurusan FROM users u LEFT JOIN jurusan j ON j.id=u.jurusan_id ORDER BY u.created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>List Pendaftar — Admin PMB UNAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="shell">
  <?php include '../includes/admin_sidebar.php'; ?>
  <div class="main">
    <div class="topbar-dash"><h2>List User yang Sudah Mendaftar</h2></div>
    <div class="content">
      <div class="panel">
        <table>
          <thead><tr><th>Nomor Test</th><th>Nama</th><th>Email</th><th>No. HP</th><th>Jurusan</th><th>Tgl Daftar</th><th>Status Tes</th></tr></thead>
          <tbody>
            <?php if (mysqli_num_rows($dataList) === 0): ?>
              <tr><td colspan="7" style="text-align:center;color:var(--ink-soft)">Belum ada pendaftar.</td></tr>
            <?php endif; ?>
            <?php while ($r = mysqli_fetch_assoc($dataList)): ?>
              <tr>
                <td><?= h($r['nomor_test']) ?></td>
                <td><?= h($r['nama']) ?></td>
                <td><?= h($r['email']) ?></td>
                <td><?= h($r['no_hp']) ?: '-' ?></td>
                <td><?= h($r['nama_jurusan']) ?: '-' ?></td>
                <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                <td><?= $r['status_test'] === 'sudah_test' ? '<span class="badge badge-ok">Selesai</span>' : '<span class="badge badge-neutral">Belum Test</span>' ?></td>
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
