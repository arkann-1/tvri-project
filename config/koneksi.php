<?php

$servername = "localhost";
$username   = "root";      // default user XAMPP
$password   = "";          // default password XAMPP (kosong)
$dbname     = "jadwal_karyawan"; // sesuai nama database Anda

// Membuat koneksi
$conn = new mysqli($servername,  $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
