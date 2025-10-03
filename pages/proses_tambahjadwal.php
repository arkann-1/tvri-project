<?php

include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip        = $conn->real_escape_string($_POST['nip']);
    $nama       = $conn->real_escape_string($_POST['nama']);
    $pekerjaan  = $conn->real_escape_string($_POST['pekerjaan']);
    $tanggal    = $conn->real_escape_string($_POST['tanggal']);
    // $jam_mulai  = $conn->real_escape_string($_POST['jam_mulai']);
    // $jam_selesai = $conn->real_escape_string($_POST['jam_selesai']);
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

    $sql = "INSERT INTO jadwal_karyawan (nip, nama, pekerjaan, tanggal, jam, shift, file_path, lokasi)
            VALUES ('$nip','$nama','$pekerjaan','$tanggal','$jam','$shift','$filePath','$lokasi')";

    if ($conn->query($sql)) {
        header("Location: jadwalbulanan.php?success=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
