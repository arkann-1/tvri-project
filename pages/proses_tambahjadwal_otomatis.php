<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bulan = $_POST['bulan']; // format YYYY-MM
    $lokasi = $_POST['lokasi'];
    $grup_A = $_POST['grup_A'] ?? [];
    $grup_B = $_POST['grup_B'] ?? [];
    $grup_C = $_POST['grup_C'] ?? [];
    $grup_D = $_POST['grup_D'] ?? [];

    // Tentukan pola berdasarkan lokasi
    if ($lokasi === 'Senayan') {
        $pola = [
            ['A','B','C','D'],
            ['B','C','D','A'],
            ['C','D','A','B'],
            ['D','A','B','C']
        ];
        $jumlah_grup = 4;
    } else { // Joglo
        $pola = [
            ['A','B','C'],
            ['C','A','B'],
            ['B','C','A'],
            ['A','B','C']
        ];
        $jumlah_grup = 3;
    }

    // Tentukan shift
    $shift_map = [
        'A' => 1,
        'B' => 2,
        'C' => 3,
        'D' => 1
    ];

    // Tentukan jumlah minggu (anggap 4 minggu)
    for ($minggu = 0; $minggu < 4; $minggu++) {
        $awal_minggu = date("Y-m-d", strtotime("$bulan-01 +$minggu week"));

        foreach ($pola[$minggu] as $idx => $group) {
            // Ambil daftar pegawai dari grup
            $list_pegawai = ${"grup_" . $group};

            foreach ($list_pegawai as $id_pegawai) {
                $tanggal = $awal_minggu;
                $shift = $shift_map[$group];
                $jam = match($shift) {
                    1 => "00:00 - 08:00",
                    2 => "08:00 - 16:00",
                    3 => "16:00 - 00:00",
                    default => "-"
                };

                // Simpan ke database
                $conn->query("INSERT INTO jadwal_karyawan (id_pegawai, tanggal, shift, jam, lokasi) 
                              VALUES ('$id_pegawai', '$tanggal', '$shift', '$jam', '$lokasi')");
            }
        }
    }

    echo "<script>alert('Jadwal otomatis berhasil dibuat untuk lokasi $lokasi!'); window.location='jadwalbulanan.php';</script>";
}
?>
