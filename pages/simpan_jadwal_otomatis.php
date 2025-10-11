<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Akses tidak valid.");
}

$jadwalJson = $_POST['jadwalData'] ?? '';
if (!$jadwalJson) {
    die("Data jadwal kosong.");
}
$jadwalData = json_decode($jadwalJson, true);
if (!is_array($jadwalData)) {
    die("Format data jadwal tidak valid.");
}

$success = 0;
$skip = 0;
$fail = 0;

foreach ($jadwalData as $j) {
    $id_pegawai = intval($j['id_pegawai']);
    $tanggal = $conn->real_escape_string($j['tanggal']);
    $shift = intval($j['shift']);
    $jam = $conn->real_escape_string($j['jam']);
    $lokasi = $conn->real_escape_string($j['lokasi']);

    // Cek duplikat: id_pegawai + tanggal + shift + lokasi
    $cek = $conn->query("SELECT id FROM jadwal_karyawan WHERE id_pegawai=$id_pegawai AND tanggal='$tanggal' AND shift=$shift AND lokasi='$lokasi'");
    if ($cek && $cek->num_rows > 0) {
        $skip++;
        continue;
    }

    $sql = "INSERT INTO jadwal_karyawan (id_pegawai, tanggal, shift, jam, lokasi)
            VALUES ($id_pegawai, '$tanggal', $shift, '$jam', '$lokasi')";
    if ($conn->query($sql)) $success++; else $fail++;
}

echo "<div style='padding:20px;font-family:Arial;'>";
echo "<h4>Hasil Simpan Jadwal</h4>";
echo "<p>Berhasil: <strong>$success</strong></p>";
echo "<p>Lewat (sudah ada): <strong>$skip</strong></p>";
echo "<p>Gagal: <strong>$fail</strong></p>";
echo "<a href='jadwalbulanan.php' class='btn btn-primary'>Lihat Jadwal Bulanan</a> ";
echo "<a href='tambahjadwal_otomatis.php' class='btn btn-secondary'>Kembali</a>";
echo "</div>";
