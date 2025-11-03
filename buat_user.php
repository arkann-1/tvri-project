<?php
include 'config/koneksi.php';

$username = 'admin';
$password_plain = '12345';
$hashed = password_hash($password_plain, PASSWORD_DEFAULT);

$conn->query("INSERT INTO users (username, password) VALUES ('$username', '$hashed')");

echo "User $username berhasil dibuat dengan password: $password_plain";
