<?php

session_start();
include 'config/koneksi.php';
$loggedIn = isset($_SESSION['user']);
$role = $loggedIn ? $_SESSION['user']['role'] : null;

$queryError = false;


// Ambil lokasi (default Senayan)
$lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : 'Senayan';

// Ambil kata kunci pencarian (default kosong)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Siapkan array kata kunci
$searchTerms = [];
if ($search !== '') {
    $parts = preg_split('/\s+/u', $search, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($parts as $p) {
        $p = trim($p);
        if ($p !== '') {
            $searchTerms[] = $p;
        }
    }
}

// Kondisi WHERE
$where = [];
$where[] = "tanggal = CURDATE()"; // selalu jadwal hari ini

if ($lokasi !== 'Semua') {
    $lokasiEsc = $conn->real_escape_string($lokasi);
    $where[] = "lokasi = '{$lokasiEsc}'";
}

if (!empty($searchTerms)) {
    $columns = ['nip', 'nama', 'shift', 'jam', 'pekerjaan', 'lokasi'];
    foreach ($searchTerms as $term) {
        $termEsc = $conn->real_escape_string($term);
        $like = "%{$termEsc}%";
        $orParts = [];
        foreach ($columns as $col) {
            $orParts[] = "{$col} LIKE '{$like}'";
        }
        $where[] = '(' . implode(' OR ', $orParts) . ')';
    }
}

// Susun query akhir
// Susun query akhir (pakai filter lokasi dan pencarian)
$sql = "SELECT jk.*, p.nama 
        FROM jadwal_karyawan jk
        LEFT JOIN pegawai p ON jk.id_pegawai = p.id";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY p.nama ASC";

$result = $conn->query($sql);


// Fungsi highlight
function highlight_terms($text, $terms)
{
    if ($text === null || $text === '') {
        return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
    }
    if (empty($terms)) {
        return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
    }

    usort($terms, fn ($a, $b) => mb_strlen($b) - mb_strlen($a));
    $escapedPatterns = array_map(fn ($t) => preg_quote($t, '/'), $terms);
    $pattern = '/(' . implode('|', $escapedPatterns) . ')/iu';
    $parts = preg_split($pattern, $text, -1, PREG_SPLIT_DELIM_CAPTURE);

    if ($parts === false) {
        return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
    }

    $out = '';
    foreach ($parts as $part) {
        if ($part === '') {
            continue;
        }
        if (preg_match($pattern, $part)) {
            $out .= '<mark class="bg-warning text-dark">' . htmlspecialchars($part, ENT_QUOTES, 'UTF-8') . '</mark>';
        } else {
            $out .= htmlspecialchars($part, ENT_QUOTES, 'UTF-8');
        }
    }
    return $out;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Jadwal Hari Ini — Sistem Jadwal</title>

  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
  <div class="px-3 my-3 text-light fw-bold">MENU</div>

  <a href="index.php">🏠 <span class="menu-text">Beranda</span></a>
  <a href="pages/jadwalbulanan.php">📅 <span class="menu-text">Jadwal Bulanan</span></a>
  <a href="pages/rekap.php">📨 <span class="menu-text">Rekap</span></a>

  <?php if ($loggedIn): ?>
      <a href="pages/tambahpegawai.php">👤 Tambah Pegawai</a>
      <a href="pages/tambahjadwal_otomatis.php">📂 Tambah Jadwal</a>
      <a href="logout.php" class="text-danger">🚪 Logout (<?= htmlspecialchars($_SESSION['user']['username']) ?>)</a>
  <?php else: ?>
      <a href="login.php" class="text-success">🔑 Login</a>
  <?php endif; ?>
</aside>

<!-- Main Content -->
<main class="main">

<nav class="navbar navbar-light bg-white shadow-sm px-3 mb-3">
    <div class="d-flex align-items-center w-100">

      <!-- Mobile Sidebar Button -->
      <button class="btn btn-outline-primary d-lg-none me-2" id="toggleSidebarBtn">☰</button>

      <img src="assets/images/TVRI.png" width="80" class="me-2">

      <form method="get" class="d-flex flex-grow-1 gap-2 ms-3 searchForm">
        <input class="form-control" name="search" placeholder="Cari ID / Nama / Pekerjaan"
               value="<?= htmlspecialchars($search) ?>">

        <select class="form-select" name="lokasi" onchange="this.form.submit()">
          <option value="Senayan" <?= $lokasi === 'Senayan' ? 'selected' : '' ?>>Senayan</option>
          <option value="Joglo"   <?= $lokasi === 'Joglo' ? 'selected' : '' ?>>Joglo</option>
          <option value="Semua"   <?= $lokasi === 'Semua' ? 'selected' : '' ?>>Semua</option>
        </select>

        <button class="btn btn-primary">🔍 Cari</button>
      </form>

    </div>
</nav>

<h4 class="fw-bold mb-2">📋 Jadwal Hari Ini</h4>

<div class="card shadow mb-4">
  <div class="card-header bg-primary text-white">
    Jadwal Lokasi: <?= htmlspecialchars($lokasi) ?>
  </div>
  <div class="card-body">

    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark text-center">
          <tr>
            <th>Nama Petugas</th>
            <th>Tanggal</th>
            <th>Shift</th>
            <th>Jam</th>
            <th>Lokasi</th>
          </tr>
        </thead>
        <tbody>
        <?php
          if ($result && $result->num_rows > 0) {
              while ($r = $result->fetch_assoc()) {
                  echo "<tr>
                        <td>{$r['nama']}</td>
                        <td>{$r['tanggal']}</td>
                        <td>{$r['shift']}</td>
                        <td>{$r['jam']}</td>
                        <td>{$r['lokasi']}</td>
                    </tr>";
              }
          } else {
              echo "<tr><td colspan='5' class='text-center'>Tidak ada data</td></tr>";
          }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card shadow">
  <div class="card-header bg-secondary text-white">📁 Jadwal Liputan</div>
  <div class="card-body">

    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark text-center">
          <tr>
            <th>Nama Petugas</th>
            <th>Lokasi</th>
            <th>Jenis</th>
            <th>Tanggal</th>
            <th>Surat</th>
          </tr>
        </thead>

        <tbody>
        <?php
            include './config/koneksi.php';
            $lip = $conn->query("SELECT p.nama, l.* FROM liputan l JOIN pegawai p ON l.id_pegawai=p.id ORDER BY l.id DESC");

            if ($lip && $lip->num_rows > 0) {
                while ($row = $lip->fetch_assoc()) {
                    $file = $row['surat_tugas'] ? "<a href='uploads/".basename($row['surat_tugas'])."' target='_blank' class='btn btn-sm btn-outline-info'>📄</a>" : "-";
                    echo "<tr>
                            <td>{$row['nama']}</td>
                            <td>{$row['lokasi']}</td>
                            <td>{$row['jenis_kegiatan']}</td>
                            <td>{$row['tanggal']}</td>
                            <td class='text-center'>$file</td>
                          </tr>";
                }
            } else echo "<tr><td colspan='5' class='text-center'>Tidak ada data</td></tr>";
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</main>

<script src="assets/js/script.js"></script>

</body>
</html>

