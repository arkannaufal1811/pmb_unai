<?php
require '../config.php';
require '../includes/auth_admin.php';
$active = 'daftar_ulang';

$dataList = mysqli_query($koneksi, "SELECT u.*, j.nama_jurusan FROM users u LEFT JOIN jurusan j ON j.id=u.jurusan_id WHERE u.status_daftar_ulang = 'sudah' ORDER BY u.nim");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>List Daftar Ulang — Admin PMB UNAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="shell">
  <?php include '../includes/admin_sidebar.php'; ?>
  <div class="main">
    <div class="topbar-dash"><h2>List Mahasiswa yang Sudah Daftar Ulang</h2></div>
    <div class="content">
      <div class="panel">
        <table>
          <thead><tr><th>NIM</th><th>Nama</th><th>Email</th><th>Jurusan</th><th>Skor Test</th></tr></thead>
          <tbody>
            <?php if (mysqli_num_rows($dataList) === 0): ?>
              <tr><td colspan="5" style="text-align:center;color:var(--ink-soft)">Belum ada mahasiswa yang daftar ulang.</td></tr>
            <?php endif; ?>
            <?php while ($r = mysqli_fetch_assoc($dataList)): ?>
              <tr>
                <td><b style="color:var(--violet-800)"><?= h($r['nim']) ?></b></td>
                <td><?= h($r['nama']) ?></td>
                <td><?= h($r['email']) ?></td>
                <td><?= h($r['nama_jurusan']) ?: '-' ?></td>
                <td><?= h($r['skor_test']) ?></td>
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
