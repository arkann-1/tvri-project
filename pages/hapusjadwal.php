<?php

include '../config/koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data lama untuk hapus file
$data = $conn->query("SELECT file_path FROM jadwal_karyawan WHERE id=$id")->fetch_assoc();

if ($data) {
    // Hapus file terkait jika ada dan file memang ada di server
    if (!empty($data['file_path']) && file_exists($data['file_path'])) {
        unlink($data['file_path']);
    }
    // Hapus data jadwal dari tabel jadwal_karyawan
    $conn->query("DELETE FROM jadwal_karyawan WHERE id=$id");
}

// Redirect ke halaman jadwal bulanan dengan notifikasi
header("Location: jadwalbulanan.php?deleted=1");
exit;
