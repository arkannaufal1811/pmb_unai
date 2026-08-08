<?php
require '../config.php';
require '../includes/auth_admin.php';
$active = 'soal';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$error = '';

if ($action === 'delete' && $id) {
    $stmt = mysqli_prepare($koneksi, "DELETE FROM soal_test WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    header('Location: soal.php?deleted=1');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pertanyaan = trim($_POST['pertanyaan'] ?? '');
    $a = trim($_POST['pilihan_a'] ?? '');
    $b = trim($_POST['pilihan_b'] ?? '');
    $c = trim($_POST['pilihan_c'] ?? '');
    $d = trim($_POST['pilihan_d'] ?? '');
    $jawaban = $_POST['jawaban_benar'] ?? 'A';
    $editId = (int) ($_POST['id'] ?? 0);

    if ($pertanyaan === '' || $a === '' || $b === '' || $c === '' || $d === '') {
        $error = 'Semua kolom pertanyaan dan pilihan wajib diisi.';
    } elseif ($editId) {
        $stmt = mysqli_prepare($koneksi, "UPDATE soal_test SET pertanyaan=?, pilihan_a=?, pilihan_b=?, pilihan_c=?, pilihan_d=?, jawaban_benar=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'ssssssi', $pertanyaan, $a, $b, $c, $d, $jawaban, $editId);
        mysqli_stmt_execute($stmt);
        header('Location: soal.php?updated=1');
        exit;
    } else {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO soal_test (pertanyaan, pilihan_a, pilihan_b, pilihan_c, pilihan_d, jawaban_benar) VALUES (?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, 'ssssss', $pertanyaan, $a, $b, $c, $d, $jawaban);
        mysqli_stmt_execute($stmt);
        header('Location: soal.php?added=1');
        exit;
    }
}

$editData = null;
if ($action === 'edit' && $id) {
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM soal_test WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $editData = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$dataList = mysqli_query($koneksi, "SELECT * FROM soal_test ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Soal Test — Admin PMB UNAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="shell">
  <?php include '../includes/admin_sidebar.php'; ?>
  <div class="main">
    <div class="topbar-dash">
      <h2>Data Soal Test (CBT)</h2>
      <?php if ($action === 'list'): ?>
        <a href="?action=add" class="btn btn-primary btn-sm">+ Tambah Soal</a>
      <?php else: ?>
        <a href="soal.php" class="btn btn-ghost btn-sm">← Kembali ke List</a>
      <?php endif; ?>
    </div>
    <div class="content">

      <?php if (isset($_GET['added'])): ?><div class="alert alert-ok">Soal berhasil ditambahkan.</div><?php endif; ?>
      <?php if (isset($_GET['updated'])): ?><div class="alert alert-ok">Soal berhasil diperbarui.</div><?php endif; ?>
      <?php if (isset($_GET['deleted'])): ?><div class="alert alert-ok">Soal berhasil dihapus.</div><?php endif; ?>
      <?php if ($error): ?><div class="alert alert-error"><?= h($error) ?></div><?php endif; ?>

      <?php if ($action === 'add' || $action === 'edit'): ?>
        <div class="panel" style="max-width:640px">
          <h3><?= $action === 'edit' ? 'Edit Soal' : 'Tambah Soal Baru' ?></h3>
          <form method="POST">
            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
            <div class="field">
              <label>Pertanyaan</label>
              <textarea name="pertanyaan" rows="3" required><?= h($editData['pertanyaan'] ?? '') ?></textarea>
            </div>
            <div class="form-grid">
              <div class="field"><label>Pilihan A</label><input type="text" name="pilihan_a" value="<?= h($editData['pilihan_a'] ?? '') ?>" required></div>
              <div class="field"><label>Pilihan B</label><input type="text" name="pilihan_b" value="<?= h($editData['pilihan_b'] ?? '') ?>" required></div>
              <div class="field"><label>Pilihan C</label><input type="text" name="pilihan_c" value="<?= h($editData['pilihan_c'] ?? '') ?>" required></div>
              <div class="field"><label>Pilihan D</label><input type="text" name="pilihan_d" value="<?= h($editData['pilihan_d'] ?? '') ?>" required></div>
            </div>
            <div class="field">
              <label>Jawaban Benar</label>
              <select name="jawaban_benar">
                <?php foreach (['A', 'B', 'C', 'D'] as $opt): ?>
                  <option value="<?= $opt ?>" <?= ($editData['jawaban_benar'] ?? '') === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary"><?= $action === 'edit' ? 'Simpan Perubahan' : 'Tambah Soal' ?></button>
          </form>
        </div>

      <?php else: ?>
        <div class="panel">
          <table>
            <thead><tr><th style="width:44%">Pertanyaan</th><th>A</th><th>B</th><th>C</th><th>D</th><th>Jawaban</th><th>Aksi</th></tr></thead>
            <tbody>
              <?php if (mysqli_num_rows($dataList) === 0): ?>
                <tr><td colspan="7" style="text-align:center;color:var(--ink-soft)">Belum ada soal.</td></tr>
              <?php endif; ?>
              <?php while ($r = mysqli_fetch_assoc($dataList)): ?>
                <tr>
                  <td><?= h($r['pertanyaan']) ?></td>
                  <td><?= h($r['pilihan_a']) ?></td>
                  <td><?= h($r['pilihan_b']) ?></td>
                  <td><?= h($r['pilihan_c']) ?></td>
                  <td><?= h($r['pilihan_d']) ?></td>
                  <td>
                    <span class="answer-hidden" id="ans-<?= $r['id'] ?>">
                      <span class="badge badge-neutral blurred"><?= h($r['jawaban_benar']) ?></span>
                      <button type="button" class="btn btn-ghost btn-sm" onclick="toggleAnswer(<?= $r['id'] ?>)">👁 Lihat</button>
                    </span>
                  </td>
                  <td class="actions">
                    <a href="?action=edit&id=<?= $r['id'] ?>" class="btn btn-ghost btn-sm">Edit</a>
                    <a href="?action=delete&id=<?= $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirmAction('Hapus soal ini?')">Hapus</a>
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
