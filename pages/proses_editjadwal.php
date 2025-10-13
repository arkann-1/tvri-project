<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = intval($_POST['id']);
    $id_pegawai = $conn->real_escape_string($_POST['id_pegawai']);
    $tanggal    = $conn->real_escape_string($_POST['tanggal']);
    $shift      = $conn->real_escape_string($_POST['shift']);
    $lokasi     = $conn->real_escape_string($_POST['lokasi']);

    // 🔹 Tentukan jam otomatis berdasarkan shift
    if ($shift == "1") {
        $jam = "00:00 - 08:00";
    } elseif ($shift == "2") {
        $jam = "08:00 - 16:00";
    } elseif ($shift == "3") {
        $jam = "16:00 - 00:00";
    } else {
        $jam = "-";
    }

    $sql = "UPDATE jadwal_karyawan SET 
            id_pegawai = '$id_pegawai',
            tanggal = '$tanggal',
            shift = '$shift',
            jam = '$jam',
            lokasi = '$lokasi'
            WHERE id = $id";

    if ($conn->query($sql)) {
        echo "<script>alert('Jadwal berhasil diperbarui!');window.location.href='jadwalbulanan.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
