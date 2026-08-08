<?php
require '../config.php';
require '../includes/auth_user.php';
$active = 'test';

$stmt = mysqli_prepare($koneksi, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ($user['status_test'] === 'sudah_test') {
    header('Location: hasil.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jawaban = $_POST['jawaban'] ?? [];
    $soalRes = mysqli_query($koneksi, "SELECT id, jawaban_benar FROM soal_test");
    $total = 0;
    $benar = 0;

    while ($soal = mysqli_fetch_assoc($soalRes)) {
        $total++;
        $pilihUser = $jawaban[$soal['id']] ?? null;

        $ins = mysqli_prepare($koneksi, "INSERT INTO jawaban_user (user_id, soal_id, jawaban_dipilih) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($ins, 'iis', $_SESSION['user_id'], $soal['id'], $pilihUser);
        mysqli_stmt_execute($ins);

        if ($pilihUser === $soal['jawaban_benar']) {
            $benar++;
        }
    }

    $skor = $total > 0 ? (int) round(($benar / $total) * 100) : 0;
    $status_kelulusan = $skor >= PASSING_GRADE ? 'lulus' : 'tidak_lulus';

    $upd = mysqli_prepare($koneksi, "UPDATE users SET skor_test = ?, status_test = 'sudah_test', status_kelulusan = ? WHERE id = ?");
    mysqli_stmt_bind_param($upd, 'isi', $skor, $status_kelulusan, $_SESSION['user_id']);
    mysqli_stmt_execute($upd);

    header('Location: hasil.php');
    exit;
}

$soalList = mysqli_query($koneksi, "SELECT * FROM soal_test ORDER BY id");
$soalCount = mysqli_num_rows($soalList);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tes CBT — PMB UNAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="shell">
  <?php include '../includes/user_sidebar.php'; ?>
  <div class="main">
    <div class="topbar-dash">
      <h2>Tes CBT</h2>
      <span class="badge badge-neutral"><?= $soalCount ?> Soal</span>
    </div>
    <div class="content">
      <?php if ($soalCount === 0): ?>
        <div class="empty"><div class="ic">📭</div>Belum ada soal test yang tersedia. Hubungi admin.</div>
      <?php else: ?>
      <div class="panel" style="max-width:760px;margin:0 auto">
        <div class="alert alert-error" style="display:none" id="js-warning"></div>
        <p style="color:var(--ink-soft);margin-bottom:24px">Jawab seluruh <?= $soalCount ?> soal di bawah ini, lalu klik <b>Kumpulkan Jawaban</b>. Skor minimal kelulusan adalah <b><?= PASSING_GRADE ?></b>.</p>
        <form method="POST" onsubmit="return confirmAction('Kumpulkan jawaban sekarang? Jawaban tidak dapat diubah setelah dikumpulkan.');">
          <?php $no = 1; while ($soal = mysqli_fetch_assoc($soalList)): ?>
            <div class="question-card" style="margin-bottom:20px">
              <div class="qnum">Soal <?= $no ?> dari <?= $soalCount ?></div>
              <h3><?= h($soal['pertanyaan']) ?></h3>
              <?php foreach (['A' => $soal['pilihan_a'], 'B' => $soal['pilihan_b'], 'C' => $soal['pilihan_c'], 'D' => $soal['pilihan_d']] as $key => $val): ?>
                <label class="option" data-soal="<?= $soal['id'] ?>" onclick="selectOption(this, <?= $soal['id'] ?>)">
                  <input type="radio" name="jawaban[<?= $soal['id'] ?>]" value="<?= $key ?>" required>
                  <span class="key"><?= $key ?></span>
                  <span><?= h($val) ?></span>
                </label>
              <?php endforeach; ?>
            </div>
          <?php $no++; endwhile; ?>
          <button type="submit" class="btn btn-primary" style="width:100%">Kumpulkan Jawaban</button>
        </form>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
