<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pegawai = $conn->real_escape_string($_POST['id_pegawai']);
    $tanggal    = $conn->real_escape_string($_POST['tanggal']);
    $shift      = $conn->real_escape_string($_POST['shift']);
    $lokasi     = $conn->real_escape_string($_POST['lokasi']);

    // Tentukan jam berdasarkan shift
    if ($shift == "1") {
        $jam = "00:00 - 08:00";
    } elseif ($shift == "2") {
        $jam = "08:00 - 16:00";
    } elseif ($shift == "3") {
        $jam = "16:00 - 00:00";
    } else {
        $jam = "-";
    }

    // Jika ada file diupload
    $file_path = '';
    if (!empty($_FILES['file_path']['name'])) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_path = $target_dir . basename($_FILES["file_path"]["name"]);
        move_uploaded_file($_FILES["file_path"]["tmp_name"], $file_path);
    }

    // Simpan ke database
    $sql = "INSERT INTO jadwal_karyawan (id_pegawai, tanggal, shift, jam, lokasi, file_path)
            VALUES ('$id_pegawai', '$tanggal', '$shift', '$jam', '$lokasi', '$file_path')";

    if ($conn->query($sql)) {
        echo "<script>alert('Jadwal berhasil ditambahkan!');window.location.href='jadwalbulanan.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
