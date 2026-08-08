<div class="sidebar">
  <div class="brand">
    <img src="../assets/img/logo-unai.png" alt="Logo UNAI" class="seal" style="width:42px;height:42px">
    <div class="brand-text"><div class="name" style="font-size:15px">UNAI Admin</div></div>
  </div>
  <nav>
    <a href="dashboard.php" class="<?= $active === 'dashboard' ? 'active' : '' ?>">🏠 Dashboard</a>
    <a href="calon_maba.php" class="<?= $active === 'calon_maba' ? 'active' : '' ?>">👤 Data Calon Maba</a>
    <a href="soal.php" class="<?= $active === 'soal' ? 'active' : '' ?>">📝 Data Soal Test</a>
    <a href="pendaftar.php" class="<?= $active === 'pendaftar' ? 'active' : '' ?>">📋 List Pendaftar</a>
    <a href="lulus.php" class="<?= $active === 'lulus' ? 'active' : '' ?>">✅ Lulus / Tidak Lulus</a>
    <a href="daftar_ulang.php" class="<?= $active === 'daftar_ulang' ? 'active' : '' ?>">🎓 Daftar Ulang</a>
  </nav>
  <div class="foot">
    <p style="font-size:12.5px;color:var(--violet-200);margin:0 0 10px">Masuk sebagai<br><b style="color:#fff"><?= h($_SESSION['admin_nama']) ?></b></p>
    <a href="../logout.php" class="btn btn-ghost btn-sm" style="width:100%">Keluar</a>
  </div>
</div>
