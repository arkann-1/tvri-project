<?php
include '../config/koneksi.php';

$nip = $_POST['nip'];
$nama = $_POST['nama'];
$id_divisi = $_POST['id_divisi'];

$sql = "INSERT INTO pegawai (nip, nama, id_divisi) VALUES ('$nip', '$nama', '$id_divisi')";

if ($conn->query($sql)) {
    header("Location: daftarpegawai.php?status=success");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>
