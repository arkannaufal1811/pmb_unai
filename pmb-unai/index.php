<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>PMB UNAI — Penerimaan Mahasiswa Baru Universitas Arkan Indonesia</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="topbar">
  <div class="container">
    <span>Pendaftaran Gelombang 4 · Semester Gasal 2026/2027 · Dibuka 24 Jam</span>
    <a href="https://wa.me/6285811095659" target="_blank">WhatsApp Admin PMB</a>
  </div>
</div>

<header class="navbar">
  <div class="container">
    <div class="brand">
      <img src="assets/img/logo-unai.png" alt="Logo UNAI" class="seal">
      <div class="brand-text">
        <div class="name">Universitas Arkan<br>Indonesia</div>
        <div class="tagline">A Place To Create Your Success</div>
      </div>
    </div>
    <nav class="navlinks">
      <a href="#jalur">Jalur Seleksi</a>
      <a href="#jurusan">Program Studi</a>
      <a href="#alur">Alur Pendaftaran</a>
      <a href="#kontak">Kontak</a>
    </nav>
    <a href="login.php" class="btn btn-primary">Masuk / Daftar</a>
  </div>
</header>

<section class="hero">
  <div class="container">
    <div>
      <span class="eyebrow">● Penerimaan Mahasiswa Baru 2026/2027</span>
      <h1>Langkah pertamamu menuju <em>gelar sarjana</em> dimulai di sini.</h1>
      <p class="lead">UNAI membuka pendaftaran untuk jenjang D3, D4, dan S1 dengan jurusan bebas dipilih sesuai minatmu. Daftar online, ikuti tes CBT, dan pantau hasilnya — semua dalam satu portal.</p>
      <div class="cta-row">
        <a href="register.php" class="btn btn-gold">Daftar Sekarang</a>
        <a href="login.php" class="btn btn-outline" style="color:#fff;border-color:rgba(255,255,255,.5)">Cek Status Pendaftaran</a>
      </div>
      <div class="stats">
        <div class="stat"><b>8</b><span>Program Studi</span></div>
        <div class="stat"><b>24 Jam</b><span>Pendaftaran Online</span></div>
        <div class="stat"><b>60+</b><span>Skor Minimal Lulus CBT</span></div>
      </div>
    </div>

    <div class="ticket">
      <div class="head">
        <div>
          <div class="label">Kartu Peserta</div>
          <div class="wave">UNAI PMB 2026</div>
        </div>
        <div class="qr-wrap">
          <div id="ticket-qr"></div>
          <img src="assets/img/logo-unai.png" alt="UNAI" class="qr-logo">
        </div>
      </div>
      <div class="tline"></div>
      <div class="row"><span>Nomor Test</span><b>UNAI2026048291</b></div>
      <div class="row"><span>Jenjang</span><b>S1 · Reguler</b></div>
      <div class="row"><span>Gelombang</span><b>Gelombang 4</b></div>
      <div class="row"><span>Status</span><b style="color:#1B8A5A">Terdaftar</b></div>
    </div>
  </div>
</section>

<section class="section" id="jalur">
  <div class="container">
    <div class="section-head">
      <div class="kicker">Pilih jalurmu</div>
      <h2>Jalur Seleksi Penerimaan</h2>
      <p>Beberapa jalur seleksi yang tersedia untuk calon mahasiswa baru UNAI.</p>
    </div>
    <div class="grid-3">
      <div class="path-card">
        <div class="art"><span class="num">01</span><span class="kicker">Bebas Tes</span><span class="t">Jalur Bersinar</span></div>
        <div class="body"><p>Seleksi berdasarkan nilai rapor tanpa perlu mengikuti tes tertulis.</p><a href="register.php" class="btn btn-ghost btn-sm">Lihat Jalur</a></div>
      </div>
      <div class="path-card">
        <div class="art"><span class="num">02</span><span class="kicker">CBT</span><span class="t">Computer Based Test</span></div>
        <div class="body"><p>Ikuti tes seleksi berbasis komputer langsung dari portal PMB.</p><a href="register.php" class="btn btn-ghost btn-sm">Lihat Jalur</a></div>
      </div>
      <div class="path-card">
        <div class="art"><span class="num">03</span><span class="kicker">Bantuan Biaya</span><span class="t">Jalur Beasiswa</span></div>
        <div class="body"><p>Bagi calon mahasiswa berprestasi dengan keterbatasan biaya pendidikan.</p><a href="register.php" class="btn btn-ghost btn-sm">Lihat Jalur</a></div>
      </div>
      <div class="path-card">
        <div class="art"><span class="num">04</span><span class="kicker">Skor UTBK</span><span class="t">Jalur SNBT</span></div>
        <div class="body"><p>Seleksi Nasional Berdasarkan Tes — menggunakan skor UTBK yang sudah dimiliki calon mahasiswa.</p><a href="register.php" class="btn btn-ghost btn-sm">Lihat Jalur</a></div>
      </div>
      <div class="path-card">
        <div class="art"><span class="num">05</span><span class="kicker">Kelas Karyawan</span><span class="t">Jalur RPL</span></div>
        <div class="body"><p>Rekognisi Pembelajaran Lampau bagi calon mahasiswa yang sudah bekerja atau memiliki pengalaman relevan.</p><a href="register.php" class="btn btn-ghost btn-sm">Lihat Jalur</a></div>
      </div>
      <div class="path-card">
        <div class="art"><span class="num">06</span><span class="kicker">Ujian Mandiri</span><span class="t">Jalur Mandiri</span></div>
        <div class="body"><p>Seleksi mandiri yang diselenggarakan langsung oleh UNAI di luar jadwal seleksi nasional.</p><a href="register.php" class="btn btn-ghost btn-sm">Lihat Jalur</a></div>
      </div>
    </div>
  </div>
</section>

<section class="section tint" id="jurusan">
  <div class="container">
    <div class="section-head">
      <div class="kicker">Program studi</div>
      <h2>Jurusan Bebas Dipilih Sesuai Minatmu</h2>
      <p>Semua program studi UNAI terbuka untuk jenjang D3, D4, dan S1.</p>
    </div>
    <div class="grid-3">
      <?php
      $q = mysqli_query($koneksi, "SELECT nama_jurusan, jenjang FROM jurusan ORDER BY nama_jurusan");
      while ($row = mysqli_fetch_assoc($q)) {
          echo '<div class="path-card"><div class="body" style="padding-top:22px">
                  <div class="kicker" style="color:#C4922A;font-weight:800;font-size:11px;letter-spacing:.1em;text-transform:uppercase">' . h($row['jenjang']) . '</div>
                  <h3 style="font-size:18px;margin-top:6px">' . h($row['nama_jurusan']) . '</h3>
                  <p style="margin-bottom:0">Program reguler &amp; kelas karyawan tersedia.</p>
                </div></div>';
      }
      ?>
    </div>
  </div>
</section>

<section class="section" id="alur">
  <div class="container">
    <div class="section-head">
      <div class="kicker">Panduan</div>
      <h2>Alur Pendaftaran</h2>
      <p>Empat langkah sederhana dari registrasi hingga menjadi mahasiswa UNAI.</p>
    </div>
    <div class="steps">
      <div class="step"><div class="dot">1</div><h4>Registrasi Akun</h4><p>Buat akun & lengkapi data diri.</p></div>
      <div class="step"><div class="dot">2</div><h4>Nomor Test</h4><p>Dapatkan nomor test otomatis.</p></div>
      <div class="step"><div class="dot">3</div><h4>Tes CBT</h4><p>Kerjakan tes seleksi online.</p></div>
      <div class="step"><div class="dot">4</div><h4>Daftar Ulang</h4><p>Lulus? Lakukan daftar ulang & dapatkan NIM.</p></div>
    </div>
  </div>
</section>

<footer class="footer" id="kontak">
  <div class="container">
    <div>
      <div class="brand" style="margin-bottom:14px">
        <img src="assets/img/logo-unai.png" alt="Logo UNAI" class="seal">
        <div class="brand-text"><div class="name">Universitas Arkan Indonesia</div></div>
      </div>
      <p>Portal resmi Penerimaan Mahasiswa Baru (PMB) Universitas Arkan Indonesia.</p>
    </div>
    <div>
      <h4>Navigasi</h4>
      <ul>
        <li><a href="#jalur">Jalur Seleksi</a></li>
        <li><a href="#jurusan">Program Studi</a></li>
        <li><a href="login.php">Masuk / Daftar</a></li>
      </ul>
    </div>
    <div>
      <h4>Kontak</h4>
      <ul>
        <li>Admin PMB — 085811095659</li>
        <li>pmb@unai.ac.id</li>
      </ul>
    </div>
  </div>
  <div class="container bottom">
    <span>© <?= date('Y') ?> PMB Universitas Arkan Indonesia</span>
    <span>Dibangun dengan PHP &amp; MySQL</span>
  </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
  new QRCode(document.getElementById("ticket-qr"), {
    text: "https://pmb.unai.ac.id/status?no=UNAI2026048291",
    width: 64,
    height: 64,
    colorDark: "#211334",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
  });
</script>
</body>
</html>
