<div class="sidebar">
  <div class="brand">
    <img src="../assets/img/logo-unai.png" alt="Logo UNAI" class="seal" style="width:42px;height:42px">
    <div class="brand-text"><div class="name" style="font-size:15px">UNAI PMB</div></div>
  </div>
  <nav>
    <a href="dashboard.php" class="<?= $active === 'dashboard' ? 'active' : '' ?>">🏠 Dashboard</a>
    <a href="test.php" class="<?= $active === 'test' ? 'active' : '' ?>">📝 Tes CBT</a>
    <a href="hasil.php" class="<?= $active === 'hasil' ? 'active' : '' ?>">📊 Hasil Test</a>
    <a href="daftar_ulang.php" class="<?= $active === 'daftar_ulang' ? 'active' : '' ?>">🎓 Daftar Ulang</a>
  </nav>
  <div class="foot">
    <p style="font-size:12.5px;color:var(--violet-200);margin:0 0 10px">Masuk sebagai<br><b style="color:#fff"><?= h($_SESSION['user_nama']) ?></b></p>
    <a href="../logout.php" class="btn btn-ghost btn-sm" style="width:100%">Keluar</a>
  </div>
</div>
