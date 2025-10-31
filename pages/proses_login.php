<?php
session_start();
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $query = "SELECT * FROM pegawai WHERE username='$username' LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Jika password disimpan dalam bentuk hash
        if (password_verify($password, $data['password'])) {
            $_SESSION['id_pegawai'] = $data['id'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['username'] = $data['username'];

            header("Location: index.php");
            exit();
        }

        // Jika password masih plain text (belum di-hash)
        if ($password === $data['password']) {
            $_SESSION['id_pegawai'] = $data['id'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['username'] = $data['username'];

            header("Location: index.php");
            exit();
        }
    }

    header("Location: login.php?error=Username atau password salah!");
    exit();
}
?>
