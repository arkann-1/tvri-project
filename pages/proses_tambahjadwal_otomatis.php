<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bulan = $_POST['bulan'];
    $lokasi = $_POST['lokasi'];

    // Ambil input grup lalu ubah ke array
    $grup_A = array_filter(explode(",", $_POST['grup_A'] ?? ''));
    $grup_B = array_filter(explode(",", $_POST['grup_B'] ?? ''));
    $grup_C = array_filter(explode(",", $_POST['grup_C'] ?? ''));
    $grup_D = array_filter(explode(",", $_POST['grup_D'] ?? ''));

    // Ambil pola input user per minggu
    $pola = [
        explode(",", $_POST['pola_m1']),
        explode(",", $_POST['pola_m2']),
        explode(",", $_POST['pola_m3']),
        explode(",", $_POST['pola_m4'])
    ];

    // Mapping shift
    $shift_map = ['A'=>1,'B'=>2,'C'=>3,'D'=>1];

    // Generate jadwal 4 minggu
    for ($minggu = 0; $minggu < 4; $minggu++) {
        $awal_minggu = date("Y-m-d", strtotime("$bulan-01 +$minggu week"));

        foreach ($pola[$minggu] as $group) {
            $list_pegawai = ${"grup_" . $group};

            foreach ($list_pegawai as $id_pegawai) {
                $shift = $shift_map[$group] ?? null;

                $jam = match($shift) {
                    1 => "00:00 - 08:00",
                    2 => "08:00 - 16:00",
                    3 => "16:00 - 00:00",
                    default => "-"
                };

                $conn->query("INSERT INTO jadwal_karyawan (id_pegawai, tanggal, shift, jam, lokasi) 
                              VALUES ('$id_pegawai', '$awal_minggu', '$shift', '$jam', '$lokasi')");
            }
        }
    }

    echo "<script>alert('Jadwal dibuat berdasarkan input pola!'); window.location='jadwalbulanan.php';</script>";
}

?>
