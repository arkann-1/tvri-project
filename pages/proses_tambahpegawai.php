<?php
include '../config/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = $conn->real_escape_string($_POST['nip']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $tim = $conn->real_escape_string($_POST['tim']);

    $sql = "INSERT INTO pegawai (nip, nama, tim) VALUES ('$nip','$nama','$tim')";
    if ($conn->query($sql)) {
        header("Location: daftarpegawai.php?success=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>