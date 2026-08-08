<?php
// Panggil file ini di paling atas setiap halaman Admin setelah require config.php
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit;
}
