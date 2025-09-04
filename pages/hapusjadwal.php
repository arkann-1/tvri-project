<?php

include '../config/koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data lama untuk hapus file
$data = $conn->query("SELECT file_path FROM jadwal_karyawan WHERE id=$id")->fetch_assoc();

if ($data) {
    if ($data['file_path'] && file_exists($data['file_path'])) {
        unlink($data['file_path']);
    }
    $conn->query("DELETE FROM jadwal_karyawan WHERE id=$id");
}

header("Location: jadwalbulanan.php?deleted=1");
exit;
