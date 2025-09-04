<?php

include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = intval($_POST['id']);
    $nip        = $conn->real_escape_string($_POST['nip']);
    $nama       = $conn->real_escape_string($_POST['nama']);
    $pekerjaan  = $conn->real_escape_string($_POST['pekerjaan']);
    $tanggal    = $conn->real_escape_string($_POST['tanggal']);
    $jam_mulai  = $conn->real_escape_string($_POST['jam_mulai']);
    $jam_selesai = $conn->real_escape_string($_POST['jam_selesai']);
    $shift      = $conn->real_escape_string($_POST['shift']);
    $lokasi     = $conn->real_escape_string($_POST['lokasi']);

    // gabungan jam mulai & selesai jadi satu string
    $jam = $jam_mulai . ' - ' . $jam_selesai;

    // ambil data lama
    $oldData = $conn->query("SELECT file_path FROM jadwal_karyawan WHERE id=$id")->fetch_assoc();
    $filePath = $oldData['file_path'];

    // upload file baru
    if (!empty($_FILES['file_path']['name'])) {
        $uploadDir = "../uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = time() . "_" . basename($_FILES['file_path']['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['file_path']['tmp_name'], $targetFile)) {
            // Hapus file lama jika ada
            if ($filePath && file_exists($filePath)) {
                unlink($filePath);
            }
            $filePath = $targetFile;
        }
    }

    $sql = "UPDATE jadwal_karyawan 
            SET nip='$nip', nama='$nama', pekerjaan='$pekerjaan',
                tanggal='$tanggal', jam='$jam', shift='$shift',
                file_path='$filePath', lokasi='$lokasi'
            WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: jadwalbulanan.php?updated=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
