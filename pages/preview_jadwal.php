<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Akses tidak valid.");
}

$bulan = $_POST['bulan'];         // format YYYY-MM
$lokasi = $_POST['lokasi'];
$grup_A = $_POST['grup_A'] ?? [];
$grup_B = $_POST['grup_B'] ?? [];
$grup_C = $_POST['grup_C'] ?? [];
$grup_D = $_POST['grup_D'] ?? [];

// Jumlah hari di bulan tersebut
$jumlah_hari = date('t', strtotime("$bulan-01"));

// Pola per shift bergantung lokasi
if ($lokasi === 'Senayan') {
    $pola_shift1 = ['C','D','A','B'];
    $pola_shift2 = ['B','C','D','A'];
    $pola_shift3 = ['D','A','B','C'];
} else { // Joglo (3 grup)
    $pola_shift1 = ['A','B','C'];
    $pola_shift2 = ['C','A','B'];
    $pola_shift3 = ['B','C','A'];
}

// Jam per shift
$jam_map = [
    1 => "00:00 - 08:00",
    2 => "08:00 - 16:00",
    3 => "16:00 - 00:00"
];

// Gabungkan groups yang ada (jika Joglo, grup_D boleh kosong)
$all_groups = [
    'A' => $grup_A,
    'B' => $grup_B,
    'C' => $grup_C
];
if ($lokasi === 'Senayan') $all_groups['D'] = $grup_D;

// Helper: ambil nama pegawai
function getNama($conn, $id) {
    $id = intval($id);
    $q = $conn->query("SELECT nama FROM pegawai WHERE id=$id");
    $r = $q ? $q->fetch_assoc() : null;
    return $r['nama'] ?? 'Unknown';
}

// Kita bikin array jadwalData untuk dikirim ke simpan nanti
$jadwalData = [];

// Build jadwalData (loop tanggal + shift, lalu masukkan semua anggota group yang bertugas)
for ($d = 1; $d <= $jumlah_hari; $d++) {
    // index sesuai panjang pola per shift
    $idx1 = ($d - 1) % count($pola_shift1);
    $idx2 = ($d - 1) % count($pola_shift2);
    $idx3 = ($d - 1) % count($pola_shift3);

    $group1 = $pola_shift1[$idx1]; // group untuk shift 1 di tanggal d
    $group2 = $pola_shift2[$idx2]; // group untuk shift 2
    $group3 = $pola_shift3[$idx3]; // group untuk shift 3

    $tanggal_iso = sprintf("%s-%02d", $bulan, $d);

    // setiap anggota di group1 ditugaskan shift 1 pada tanggal ini
    $members1 = $all_groups[$group1] ?? [];
    foreach ($members1 as $id_p) {
        $jadwalData[] = [
            'id_pegawai' => intval($id_p),
            'tanggal' => $tanggal_iso,
            'shift' => 1,
            'jam' => $jam_map[1],
            'lokasi' => $lokasi
        ];
    }
    // group2 -> shift 2
    $members2 = $all_groups[$group2] ?? [];
    foreach ($members2 as $id_p) {
        $jadwalData[] = [
            'id_pegawai' => intval($id_p),
            'tanggal' => $tanggal_iso,
            'shift' => 2,
            'jam' => $jam_map[2],
            'lokasi' => $lokasi
        ];
    }
    // group3 -> shift 3
    $members3 = $all_groups[$group3] ?? [];
    foreach ($members3 as $id_p) {
        $jadwalData[] = [
            'id_pegawai' => intval($id_p),
            'tanggal' => $tanggal_iso,
            'shift' => 3,
            'jam' => $jam_map[3],
            'lokasi' => $lokasi
        ];
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Pratinjau Jadwal - Horizontal</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  table { font-size: 12px; white-space: nowrap; }
  th, td { text-align: center; vertical-align: middle; }
  .shift-label { text-align: left; font-weight:700; }
  .group-list { font-size: 13px; }
</style>
</head>
<body class="p-4 bg-light">
<div class="container-fluid">
  <div class="card shadow">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
      <div>
        <h5 class="m-0">Pratinjau Jadwal <?= htmlspecialchars($lokasi) ?> — <?= date('F Y', strtotime($bulan . '-01')) ?></h5>
        <small>Baris = Shift (I/II/III). Kolom = Tanggal</small>
      </div>
      <div>
        <a href="tambahjadwal_otomatis.php" class="btn btn-light btn-sm">↩️ Ubah Input</a>
      </div>
    </div>

    <div class="card-body">
      <form action="simpan_jadwal_otomatis.php" method="POST">
        <input type="hidden" name="bulan" value="<?= htmlspecialchars($bulan) ?>">
        <input type="hidden" name="lokasi" value="<?= htmlspecialchars($lokasi) ?>">
        <!-- Sertakan grup sebagai hidden agar simpan bisa berjalan -->
        <?php foreach (['A','B','C','D'] as $g): 
            if (!isset($all_groups[$g])) continue;
            foreach ($all_groups[$g] as $id): ?>
              <input type="hidden" name="grup_<?= $g ?>[]" value="<?= intval($id) ?>">
        <?php endforeach; endforeach; ?>

        <!-- input jadwalData (JSON) -->
        <input type="hidden" name="jadwalData" value="<?= htmlspecialchars(json_encode($jadwalData), ENT_QUOTES) ?>">

        <div class="table-responsive" style="overflow:auto">
          <table class="table table-bordered">
            <thead class="table-primary">
              <tr>
                <th style="min-width:180px">WAKTU DINAS</th>
                <?php for ($d = 1; $d <= $jumlah_hari; $d++): ?>
                  <th><?= $d ?></th>
                <?php endfor; ?>
              </tr>
            </thead>
            <tbody>
              <!-- Shift I -->
              <tr>
                <td class="shift-label">Shift I<br><small>Pukul <?= $jam_map[1] ?></small></td>
                <?php for ($d = 1; $d <= $jumlah_hari; $d++):
                    $idx = ($d - 1) % count($pola_shift1);
                    $g = $pola_shift1[$idx];
                ?>
                <td><?= $g ?></td>
                <?php endfor; ?>
              </tr>

              <!-- Shift II -->
              <tr>
                <td class="shift-label">Shift II<br><small>Pukul <?= $jam_map[2] ?></small></td>
                <?php for ($d = 1; $d <= $jumlah_hari; $d++):
                    $idx = ($d - 1) % count($pola_shift2);
                    $g = $pola_shift2[$idx];
                ?>
                <td><?= $g ?></td>
                <?php endfor; ?>
              </tr>

              <!-- Shift III -->
              <tr>
                <td class="shift-label">Shift III<br><small>Pukul <?= $jam_map[3] ?></small></td>
                <?php for ($d = 1; $d <= $jumlah_hari; $d++):
                    $idx = ($d - 1) % count($pola_shift3);
                    $g = $pola_shift3[$idx];
                ?>
                <td><?= $g ?></td>
                <?php endfor; ?>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Tampilkan daftar anggota tiap group di bawah -->
        <div class="row mt-3">
          <?php foreach (['A','B','C','D'] as $g): 
              if (!isset($all_groups[$g])) continue;
          ?>
          <div class="col-md-3 group-list">
            <h6>Group <?= $g ?></h6>
            <ol>
              <?php foreach ($all_groups[$g] as $id): ?>
                <li><?= htmlspecialchars(getNama($conn, $id)) ?></li>
              <?php endforeach; ?>
            </ol>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-success">💾 Simpan ke Database</button>
          <a href="tambahjadwal_otomatis.php" class="btn btn-secondary">↩️ Kembali</a>
        </div>

      </form>
    </div>
  </div>
</div>
</body>
</html>
