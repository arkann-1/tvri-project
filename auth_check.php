<?php
session_start();

// Jika belum login
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

// Jika halaman ini hanya boleh diakses admin
if (isset($requireAdmin) && $requireAdmin && $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
?>
