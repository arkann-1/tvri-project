<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil ID dari form edit
    $id         = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    if ($id === 0) {
        die("ID tidak ditemukan.");
    }

    // Ambil data dari form
    $id_pegawai = $conn->real_escape_string($_POST['id_pegawai']);
    $pekerjaan  = $conn->real_escape_string($_POST['pekerjaan']);
    $tanggal    = $conn->real_escape_string($_POST['tanggal']);
    $shift      = $conn->real_escape_string($_POST['shift']);
    $lokasi     = $conn->real_escape_string($_POST['lokasi']);

    // Ambil file lama
    $result = $conn->query("SELECT file_path FROM jadwal_karyawan WHERE id = $id");
    $old_file = "";
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $old_file = $row['file_path'];
    }

    // Upload file baru (jika ada)
    if (!empty($_FILES['file_path']['name'])) {
        $uploadDir = "../uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = time() . "_" . basename($_FILES['file_path']['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['file_path']['tmp_name'], $targetFile)) {
            // Hapus file lama
            if (!empty($old_file) && file_exists($old_file)) {
                unlink($old_file);
            }
            $filePath = $targetFile;
        } else {
            $filePath = $old_file;
        }
    } else {
        $filePath = $old_file;
    }

    // Tentukan jam
    switch ($shift) {
        case "1":
            $jam = "00.00 - 08.00";
            break;
        case "2":
            $jam = "08.00 - 16.00";
            break;
        case "3":
            $jam = "16.00 - 00.00";
            break;
        default:
            $jam = "";
    }

    // Update data
    $sql = "UPDATE jadwal_karyawan 
        SET tanggal='$tanggal', shift='$shift', jam='$jam',
            file_path='$filePath', lokasi='$lokasi'
        WHERE id=$id";


    if ($conn->query($sql)) {
        header("Location: jadwalbulanan.php?updated=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
