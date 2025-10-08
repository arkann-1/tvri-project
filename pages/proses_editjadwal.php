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

    // 🔹 Ambil data lama untuk cek file
    $result = $conn->query("SELECT file_path FROM jadwal_karyawan WHERE id = $id");
    $oldData = $result->fetch_assoc();
    $old_file = $oldData['file_path'] ?? '';

    // 🔹 Proses file baru jika ada upload
    $file_path = $old_file; // default: pakai file lama
    if (!empty($_FILES['file_path']['name'])) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $new_file = $target_dir . basename($_FILES["file_path"]["name"]);
        if (move_uploaded_file($_FILES["file_path"]["tmp_name"], $new_file)) {
            // hapus file lama jika ada
            if ($old_file && file_exists($old_file)) {
                unlink($old_file);
            }
            $file_path = $new_file;
        }
    }

    // 🔹 Update data ke tabel jadwal_karyawan
    $sql = "UPDATE jadwal_karyawan 
            SET id_pegawai='$id_pegawai',
                tanggal='$tanggal',
                shift='$shift',
                jam='$jam',
                lokasi='$lokasi',
                file_path='$file_path'
            WHERE id='$id'";

    if ($conn->query($sql)) {
        echo "<script>alert('Jadwal berhasil diperbarui!');window.location.href='jadwalbulanan.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
