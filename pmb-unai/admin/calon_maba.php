<?php
require '../config.php';
require '../includes/auth_admin.php';
$active = 'calon_maba';

$jurusanList = mysqli_query($koneksi, "SELECT id, nama_jurusan, jenjang FROM jurusan ORDER BY nama_jurusan");
$jurusanListForm = mysqli_query($koneksi, "SELECT id, nama_jurusan, jenjang FROM jurusan ORDER BY nama_jurusan");

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$error = '';

// ---------- DELETE ----------
if ($action === 'delete' && $id) {
    $stmt = mysqli_prepare($koneksi, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    header('Location: calon_maba.php?deleted=1');
    exit;
}

// ---------- ADD / EDIT SUBMIT ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $jurusan_id = $_POST['jurusan_id'] !== '' ? (int) $_POST['jurusan_id'] : null;
    $editId = (int) ($_POST['id'] ?? 0);

    if ($nama === '' || $email === '') {
        $error = 'Nama dan email wajib diisi.';
    } elseif ($editId) {
        // update
        $stmt = mysqli_prepare($koneksi, "UPDATE users SET nama=?, email=?, no_hp=?, jurusan_id=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'sssii', $nama, $email, $no_hp, $jurusan_id, $editId);
        mysqli_stmt_execute($stmt);
        header('Location: calon_maba.php?updated=1');
        exit;
    } else {
        // add new
        $password = $_POST['password'] ?? 'unai12345';
        $nomor_test = generate_nomor_test($koneksi);
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = mysqli_prepare($koneksi, "INSERT INTO users (nomor_test, nama, email, password, no_hp, jurusan_id) VALUES (?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, 'sssssi', $nomor_test, $nama, $email, $hash, $no_hp, $jurusan_id);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: calon_maba.php?added=1');
            exit;
        } else {
            $error = 'Gagal menambah data. Pastikan email belum terdaftar.';
        }
    }
}

$editData = null;
if ($action === 'edit' && $id) {
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $editData = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$dataList = mysqli_query($koneksi, "SELECT u.*, j.nama_jurusan FROM users u LEFT JOIN jurusan j ON j.id=u.jurusan_id ORDER BY u.created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Calon Maba — Admin PMB UNAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="shell">
  <?php include '../includes/admin_sidebar.php'; ?>
  <div class="main">
    <div class="topbar-dash">
      <h2>Data Calon Mahasiswa Baru</h2>
      <?php if ($action === 'list'): ?>
        <a href="?action=add" class="btn btn-primary btn-sm">+ Tambah Calon Maba</a>
      <?php else: ?>
        <a href="calon_maba.php" class="btn btn-ghost btn-sm">← Kembali ke List</a>
      <?php endif; ?>
    </div>
    <div class="content">

      <?php if (isset($_GET['added'])): ?><div class="alert alert-ok">Data calon maba berhasil ditambahkan.</div><?php endif; ?>
      <?php if (isset($_GET['updated'])): ?><div class="alert alert-ok">Data berhasil diperbarui.</div><?php endif; ?>
      <?php if (isset($_GET['deleted'])): ?><div class="alert alert-ok">Data berhasil dihapus.</div><?php endif; ?>
      <?php if ($error): ?><div class="alert alert-error"><?= h($error) ?></div><?php endif; ?>

      <?php if ($action === 'add' || $action === 'edit'): ?>
        <div class="panel" style="max-width:640px">
          <h3><?= $action === 'edit' ? 'Edit Data Calon Maba' : 'Tambah Calon Maba Baru' ?></h3>
          <form method="POST">
            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
            <div class="field">
              <label>Nama Lengkap</label>
              <input type="text" name="nama" value="<?= h($editData['nama'] ?? '') ?>" required>
            </div>
            <div class="form-grid">
              <div class="field">
                <label>Email</label>
                <input type="email" name="email" value="<?= h($editData['email'] ?? '') ?>" required>
              </div>
              <div class="field">
                <label>No. HP</label>
                <input type="text" name="no_hp" value="<?= h($editData['no_hp'] ?? '') ?>">
              </div>
            </div>
            <div class="field">
              <label>Jurusan</label>
              <select name="jurusan_id">
                <option value="">— Belum menentukan —</option>
                <?php while ($j = mysqli_fetch_assoc($jurusanListForm)): ?>
                  <option value="<?= $j['id'] ?>" <?= isset($editData['jurusan_id']) && $editData['jurusan_id'] == $j['id'] ? 'selected' : '' ?>>
                    <?= h($j['nama_jurusan']) ?> (<?= h($j['jenjang']) ?>)
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
            <?php if ($action === 'add'): ?>
            <div class="field">
              <label>Password Awal</label>
              <input type="text" name="password" value="unai12345" required>
            </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary"><?= $action === 'edit' ? 'Simpan Perubahan' : 'Tambah Data' ?></button>
          </form>
        </div>

      <?php else: ?>
        <div class="panel">
          <table>
            <thead>
              <tr><th>Nomor Test</th><th>Nama</th><th>Email</th><th>Jurusan</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
              <?php if (mysqli_num_rows($dataList) === 0): ?>
                <tr><td colspan="6" style="text-align:center;color:var(--ink-soft)">Belum ada data calon maba.</td></tr>
              <?php endif; ?>
              <?php while ($r = mysqli_fetch_assoc($dataList)): ?>
                <tr>
                  <td><?= h($r['nomor_test']) ?></td>
                  <td><?= h($r['nama']) ?></td>
                  <td><?= h($r['email']) ?></td>
                  <td><?= h($r['nama_jurusan']) ?: '-' ?></td>
                  <td>
                    <?php if ($r['status_kelulusan'] === 'lulus'): ?><span class="badge badge-ok">Lulus</span>
                    <?php elseif ($r['status_kelulusan'] === 'tidak_lulus'): ?><span class="badge badge-bad">Tidak Lulus</span>
                    <?php else: ?><span class="badge badge-warn">Menunggu</span><?php endif; ?>
                  </td>
                  <td class="actions">
                    <a href="?action=edit&id=<?= $r['id'] ?>" class="btn btn-ghost btn-sm">Edit</a>
                    <a href="?action=delete&id=<?= $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirmAction('Hapus data ' + <?= json_encode($r['nama']) ?> + '?')">Hapus</a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
