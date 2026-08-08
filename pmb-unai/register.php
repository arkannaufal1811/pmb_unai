<?php
require 'config.php';

$error = '';
$nama = $email = $no_hp = '';
$jurusan_id = '';

$jurusanList = mysqli_query($koneksi, "SELECT id, nama_jurusan, jenjang FROM jurusan ORDER BY nama_jurusan");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $jurusan_id = $_POST['jurusan_id'] ?? '';
    $password = $_POST['password'] ?? '';
    $konfirmasi = $_POST['konfirmasi_password'] ?? '';

    if ($nama === '' || $email === '' || $password === '') {
        $error = 'Nama, email, dan password wajib diisi.';
    } elseif ($password !== $konfirmasi) {
        $error = 'Password dan konfirmasi password tidak sama.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } else {
        $cek = mysqli_prepare($koneksi, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($cek, 's', $email);
        mysqli_stmt_execute($cek);
        if (mysqli_num_rows(mysqli_stmt_get_result($cek)) > 0) {
            $error = 'Email sudah terdaftar. Silakan login.';
        } else {
            $nomor_test = generate_nomor_test($koneksi);
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $jurusanIdVal = $jurusan_id !== '' ? (int) $jurusan_id : null;

            $stmt = mysqli_prepare($koneksi, "INSERT INTO users (nomor_test, nama, email, password, no_hp, jurusan_id) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'sssssi', $nomor_test, $nama, $email, $hash, $no_hp, $jurusanIdVal);

            if (mysqli_stmt_execute($stmt)) {
                $newId = mysqli_insert_id($koneksi);
                $_SESSION['user_id'] = $newId;
                $_SESSION['user_nama'] = $nama;
                $_SESSION['user_nomor_test'] = $nomor_test;
                header('Location: user/dashboard.php?registrasi=sukses');
                exit;
            } else {
                $error = 'Terjadi kesalahan saat menyimpan data. Coba lagi.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar — PMB UNAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="auth-wrap">
  <div class="auth-side">
    <div class="brand" style="margin-bottom:26px">
      <img src="assets/img/logo-unai.png" alt="Logo UNAI" class="seal">
      <div class="brand-text"><div class="name" style="color:#fff">Universitas Arkan<br>Indonesia</div></div>
    </div>
    <h1>Buat akunmu, dapatkan nomor test seketika.</h1>
    <p>Setelah registrasi berhasil, kamu akan langsung mendapatkan nomor test untuk mengikuti seleksi CBT.</p>
  </div>

  <div class="auth-card" style="width:560px">
    <img src="assets/img/logo-unai.png" alt="Logo UNAI" class="seal-lg">
    <h2 style="margin-bottom:22px">Registrasi Calon Mahasiswa</h2>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= h($error) ?></div>
    <?php endif; ?>

    <form method="POST" id="register-form">
      <div class="field">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?= h($nama) ?>" required>
      </div>
      <div class="form-grid">
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" value="<?= h($email) ?>" required>
        </div>
        <div class="field">
          <label>No. HP / WhatsApp</label>
          <input type="text" name="no_hp" value="<?= h($no_hp) ?>">
        </div>
      </div>
      <div class="field">
        <label>Pilihan Jurusan</label>
        <select name="jurusan_id">
          <option value="">— Belum menentukan —</option>
          <?php while ($j = mysqli_fetch_assoc($jurusanList)): ?>
            <option value="<?= $j['id'] ?>" <?= (string) $jurusan_id === (string) $j['id'] ? 'selected' : '' ?>>
              <?= h($j['nama_jurusan']) ?> (<?= h($j['jenjang']) ?>)
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-grid">
        <div class="field">
          <label>Password</label>
          <input type="password" name="password" id="password" required>
        </div>
        <div class="field">
          <label>Konfirmasi Password</label>
          <input type="password" name="konfirmasi_password" id="konfirmasi_password" required>
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%">Daftar &amp; Dapatkan Nomor Test</button>
    </form>

    <p class="helper">Sudah punya akun? <a href="login.php" style="color:var(--violet-800);font-weight:700">Login di sini</a></p>
  </div>
</div>
<script src="assets/js/script.js"></script>
</body>
</html>
