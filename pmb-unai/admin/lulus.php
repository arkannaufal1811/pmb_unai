<?php
require '../config.php';
require '../includes/auth_admin.php';
$active = 'lulus';

// Admin bisa override status kelulusan secara manual jika diperlukan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['status_kelulusan'])) {
    $uid = (int) $_POST['user_id'];
    $status = in_array($_POST['status_kelulusan'], ['lulus', 'tidak_lulus', 'menunggu'], true) ? $_POST['status_kelulusan'] : 'menunggu';
    $stmt = mysqli_prepare($koneksi, "UPDATE users SET status_kelulusan = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $status, $uid);
    mysqli_stmt_execute($stmt);
    header('Location: lulus.php?updated=1');
    exit;
}

$filter = $_GET['filter'] ?? 'semua';
$where = "WHERE u.status_test = 'sudah_test'";
if ($filter === 'lulus') $where .= " AND u.status_kelulusan = 'lulus'";
if ($filter === 'tidak_lulus') $where .= " AND u.status_kelulusan = 'tidak_lulus'";

$dataList = mysqli_query($koneksi, "SELECT u.*, j.nama_jurusan FROM users u LEFT JOIN jurusan j ON j.id=u.jurusan_id $where ORDER BY u.skor_test DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Lulus / Tidak Lulus — Admin PMB UNAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="shell">
  <?php include '../includes/admin_sidebar.php'; ?>
  <div class="main">
    <div class="topbar-dash"><h2>List Kelulusan</h2></div>
    <div class="content">

      <?php if (isset($_GET['updated'])): ?><div class="alert alert-ok">Status kelulusan berhasil diperbarui.</div><?php endif; ?>

      <div style="display:flex;gap:10px;margin-bottom:20px">
        <a href="?filter=semua" class="btn <?= $filter==='semua'?'btn-primary':'btn-ghost' ?> btn-sm">Semua</a>
        <a href="?filter=lulus" class="btn <?= $filter==='lulus'?'btn-primary':'btn-ghost' ?> btn-sm">Lulus</a>
        <a href="?filter=tidak_lulus" class="btn <?= $filter==='tidak_lulus'?'btn-primary':'btn-ghost' ?> btn-sm">Tidak Lulus</a>
      </div>

      <div class="panel">
        <table>
          <thead><tr><th>Nomor Test</th><th>Nama</th><th>Jurusan</th><th>Skor</th><th>Status</th><th>Ubah Status</th></tr></thead>
          <tbody>
            <?php if (mysqli_num_rows($dataList) === 0): ?>
              <tr><td colspan="6" style="text-align:center;color:var(--ink-soft)">Belum ada data yang sudah mengikuti test.</td></tr>
            <?php endif; ?>
            <?php while ($r = mysqli_fetch_assoc($dataList)): ?>
              <tr>
                <td><?= h($r['nomor_test']) ?></td>
                <td><?= h($r['nama']) ?></td>
                <td><?= h($r['nama_jurusan']) ?: '-' ?></td>
                <td><b><?= h($r['skor_test']) ?></b></td>
                <td>
                  <?php if ($r['status_kelulusan'] === 'lulus'): ?><span class="badge badge-ok">Lulus</span>
                  <?php elseif ($r['status_kelulusan'] === 'tidak_lulus'): ?><span class="badge badge-bad">Tidak Lulus</span>
                  <?php else: ?><span class="badge badge-warn">Menunggu</span><?php endif; ?>
                </td>
                <td>
                  <form method="POST" style="display:flex;gap:8px">
                    <input type="hidden" name="user_id" value="<?= $r['id'] ?>">
                    <select name="status_kelulusan" style="padding:6px 10px;border-radius:8px;border:1px solid var(--violet-100);font-size:12.5px">
                      <option value="menunggu" <?= $r['status_kelulusan']==='menunggu'?'selected':'' ?>>Menunggu</option>
                      <option value="lulus" <?= $r['status_kelulusan']==='lulus'?'selected':'' ?>>Lulus</option>
                      <option value="tidak_lulus" <?= $r['status_kelulusan']==='tidak_lulus'?'selected':'' ?>>Tidak Lulus</option>
                    </select>
                    <button type="submit" class="btn btn-ghost btn-sm">Simpan</button>
                  </form>
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
