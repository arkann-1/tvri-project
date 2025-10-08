<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_pegawai = $conn->real_escape_string($_POST['id_pegawai']);
    $tanggal    = $conn->real_escape_string($_POST['tanggal']);
    $jam_mulai  = $conn->real_escape_string($_POST['jam_mulai']);
    $jam_selesai = $conn->real_escape_string($_POST['jam_selesai']);
    $shift      = $conn->real_escape_string($_POST['shift']);
    $lokasi     = $conn->real_escape_string($_POST['lokasi']);

    // gabungan jam mulai & selesai jadi satu string
    $jam = $jam_mulai . ' - ' . $jam_selesai;

    $filePath = null;
    if (!empty($_FILES['file_path']['name'])) {
        $uploadDir = "../uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = time() . "_" . basename($_FILES['file_path']['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['file_path']['tmp_name'], $targetFile)) {
            $filePath = $targetFile;
        }
    }

    // Query yang benar sesuai struktur tabel
    $sql = "INSERT INTO jadwal_karyawan (id_pegawai, tanggal, jam, shift, file_path, lokasi)
            VALUES ('$id_pegawai', '$tanggal', '$jam', '$shift', '$filePath', '$lokasi')";

    if ($conn->query($sql)) {
        header("Location: jadwalbulanan.php?success=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
