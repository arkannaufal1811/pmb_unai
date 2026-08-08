<?php
// Panggil file ini di paling atas setiap halaman User setelah require config.php
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
