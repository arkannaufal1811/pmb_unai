<?php
require 'config.php';

$error = '';
$role = $_POST['role'] ?? 'user';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] === 'admin' ? 'admin' : 'user';

    if ($role === 'admin') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $stmt = mysqli_prepare($koneksi, "SELECT id, nama, username, password FROM admin WHERE username = ?");
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $admin = mysqli_fetch_assoc($res);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_nama'] = $admin['nama'];
            header('Location: admin/dashboard.php');
            exit;
        } else {
            $error = 'Username atau password admin salah.';
        }
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $stmt = mysqli_prepare($koneksi, "SELECT id, nama, email, password, nomor_test FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($res);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nama'] = $user['nama'];
            $_SESSION['user_nomor_test'] = $user['nomor_test'];
            header('Location: user/dashboard.php');
            exit;
        } else {
            $error = 'Email atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login — PMB UNAI</title>
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
    <h1>Satu langkah lagi menuju kampus pilihanmu.</h1>
    <p>Universitas Arkan Indonesia membuka jalur pendaftaran untuk seluruh program studi. Daftar, ikuti tes seleksi, dan dapatkan Nomor Induk Mahasiswamu di sini.</p>
  </div>

  <div class="auth-card">
    <img src="assets/img/logo-unai.png" alt="Logo UNAI" class="seal-lg">
    <h2 id="form-title" style="margin-bottom:22px"><?= $role === 'admin' ? 'Login Admin' : 'Login Calon Mahasiswa' ?></h2>

    <div class="role-toggle">
      <button type="button" id="btn-role-user" class="<?= $role !== 'admin' ? 'active' : '' ?>" onclick="setRole('user')">Calon Mahasiswa</button>
      <button type="button" id="btn-role-admin" class="<?= $role === 'admin' ? 'active' : '' ?>" onclick="setRole('admin')">Admin</button>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= h($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <input type="hidden" name="role" id="role-input" value="<?= h($role) ?>">

      <div id="user-fields" style="<?= $role === 'admin' ? 'display:none' : '' ?>">
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" placeholder="nama@email.com">
        </div>
      </div>
      <div id="admin-fields" style="<?= $role === 'admin' ? '' : 'display:none' ?>">
        <div class="field">
          <label>Username</label>
          <input type="text" name="username" placeholder="Username admin">
        </div>
      </div>

      <div class="field">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%">Masuk</button>
    </form>

    <p class="helper" id="register-hint" style="<?= $role === 'admin' ? 'display:none' : '' ?>">
      Belum punya akun? <a href="register.php" style="color:var(--violet-800);font-weight:700">Daftar di sini</a>
    </p>
    <p class="helper"><a href="index.php" style="color:var(--violet-800);font-weight:700">← Kembali ke Beranda</a></p>
  </div>
</div>

<script src="assets/js/script.js"></script>
<script>
  // keep the two field groups (email vs username) in sync with the toggle
  const origSetRole = setRole;
  setRole = function (role) {
    origSetRole(role);
    document.getElementById('user-fields').style.display = role === 'admin' ? 'none' : 'block';
    document.getElementById('admin-fields').style.display = role === 'admin' ? 'block' : 'none';
  };
</script>
</body>
</html>
