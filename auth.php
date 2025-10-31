<?php
// auth.php
// Letakkan file ini di folder yang sama dengan index.php / login.php
// Tujuan: menyediakan helper untuk mengecek/menuntut login

// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Cek apakah user sudah login
 * @return bool
 */
function is_logged_in(): bool {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Memaksa user untuk login. Jika belum, simpan halaman tujuan dan redirect ke login.php
 */
function require_login(): void {
    if (!is_logged_in()) {
        // simpan page yang diminta supaya bisa redirect kembali setelah login
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? '/index.php';
        header('Location: /login.php'); // sesuaikan path jika aplikasi di subfolder
        exit;
    }
}