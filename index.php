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
$where[] = "jk.tanggal = CURDATE()"; // selalu jadwal hari ini

if ($lokasi !== 'Semua') {
    $lokasiEsc = $conn->real_escape_string($lokasi);
    $where[] = "jk.lokasi = '{$lokasiEsc}'";
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
$sql = "SELECT jk.*, p.nama,
        IF(l.id_pegawai IS NOT NULL, 'Dinas Luar', '') AS status_luar
        FROM jadwal_karyawan jk
        LEFT JOIN pegawai p ON jk.id_pegawai = p.id
        LEFT JOIN liputan l 
           ON l.id_pegawai = jk.id_pegawai 
          AND jk.tanggal BETWEEN l.tanggal_mulai AND l.tanggal_selesai";


if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY p.nama ASC";

$result = $conn->query($sql);

// Fungsi highlight
function highlight_terms($text, $terms)
{
    if (!is_string($text)) {
        $text = (string)$text;
    }
    if ($text === '' || $text === null) {
        return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
    }
    if (empty($terms)) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    usort($terms, fn ($a, $b) => mb_strlen($b) - mb_strlen($a));
    $escapedPatterns = array_map(fn ($t) => preg_quote($t, '/'), $terms);
    $pattern = '/(' . implode('|', $escapedPatterns) . ')/iu';
    $parts = preg_split($pattern, $text, -1, PREG_SPLIT_DELIM_CAPTURE);

    if ($parts === false) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
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
    <div class="d-flex align-items-center justify-content-between px-3 mb-3">
      <div class="d-flex align-items-center gap-2">
        <button id="pinSidebar" class="pin-btn" title="Collapse/Expand">☰</button>
        <h4 class="m-0 ms-3 text-light">MENU</h4>
      </div>
    </div>
    <a href="index.php">🏠 <span class="menu-text">Beranda</span></a>
    <a href="pages/jadwalbulanan.php">📅 <span class="menu-text">Jadwal Bulanan</span></a>
    <a href="pages/rekap.php">✉️ <span class="menu-text">Rekap</span></a>

    <?php if ($loggedIn): ?>
      <?php if ($role === 'admin'): ?>
        <a href="pages/tambahpegawai.php">➕ <span class="menu-text">Tambah Pegawai</span></a>
        <a href="pages/tambahjadwal_otomatis.php">➕ <span class="menu-text">Tambah Jadwal</span></a>
      <?php endif; ?> 
      <a href="logout.php" class="text-danger">🚪 <span class="menu-text">Logout (<?= htmlspecialchars($_SESSION['user']['username']) ?>)</span></a>
    <?php else: ?>
      <a href="login.php" class="text-success">🔑 <span class="menu-text">Login</span></a>
    <?php endif; ?>
  </aside>

  <!-- Main -->
  <main class="main">
    <!-- Topbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded mb-4">
      <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="navbar-left d-flex align-items-center gap-2">
          <button id="toggleSidebar" class="btn btn-outline-primary d-lg-none" type="button">☰</button>
          <a class="navbar-brand m-0 p-0" href="#">
            <img src="assets/images/TVRI.png" alt="TVRI" width="90" class="d-block">
          </a>
        </div>

        <form method="get" class="d-flex flex-grow-1 mx-3">
          <input class="form-control me-2 flex-grow-1"
                 id="searchInput"
                 name="search"
                 type="text"
                 placeholder="Cari ID / Nama / Pekerjaan"
                 value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">

          <select class="form-select me-2" style="width:150px;" name="lokasi" onchange="this.form.submit()">
            <option value="Senayan" <?= $lokasi === 'Senayan' ? 'selected' : ''; ?>>Senayan</option>
            <option value="Joglo" <?= $lokasi === 'Joglo' ? 'selected' : ''; ?>>Joglo</option>
            <option value="Semua" <?= $lokasi === 'Semua' ? 'selected' : ''; ?>>Semua</option>
          </select>

          <button class="btn btn-primary" type="submit">🔍 Cari</button>
        </form>
      </div>
    </nav>
    
    <!-- Content -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">📋 Jadwal Hari Ini</h2>
    </div>

    <div class="card shadow-sm rounded">
      <div class="card-header bg-primary text-white">
        Jadwal Lokasi: <?= htmlspecialchars($lokasi, ENT_QUOTES, 'UTF-8') ?>
      </div>
      <div class="card-body">
        <?php if ($queryError): ?>
          <div class="alert alert-warning">Terjadi kesalahan mengambil data. Silakan cek log server.</div>
        <?php endif; ?>

        <?php if ($search !== '' && !$queryError): ?>
          <div class="alert alert-info mb-3">
            Hasil pencarian untuk: <strong><?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?></strong>
            (<?= $result ? $result->num_rows : 0 ?> data ditemukan)
          </div>
        <?php endif; ?>

        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle" id="tableJadwal">
            <thead class="table-dark">
              <tr>
                <th>Nama Petugas</th>
                <th>Tanggal</th>
                <th>Shift</th>
                <th>Jam</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
            <?php
              if ($result && $result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      echo "<tr>" .
                            "<td>" . highlight_terms($row['nama'] ?? '', $searchTerms) . "</td>" .
                            "<td>" . highlight_terms($row['tanggal'] ?? '', $searchTerms) . "</td>" .
                            "<td>" . highlight_terms($row['shift'] ?? '', $searchTerms) . "</td>" .
                            "<td>" . highlight_terms($row['jam'] ?? '', $searchTerms) . "</td>" .
                            "<td>" . highlight_terms($row['lokasi'] ?? '', $searchTerms) . "</td>" .
                            "<td>" . (!empty($row['status_luar']) ? '<span class=\"badge bg-warning text-dark\">Dinas Luar</span>' : '') . "</td>" .
                           "</tr>";
                  }
              } else {
                  echo "<tr><td colspan='8' class='text-center'>⚠️ Tidak ada data</td></tr>";
              }
?>
            </tbody>
          </table>
        </div>

        <?php if ($loggedIn && $role === 'admin'): ?>
          <div class="mb-3">
            <a href="./pages/tambah_liputan.php" class="btn btn-success">➕ Tambah Kegiatan</a>
          </div>
        <?php endif; ?>

        <!-- Tabel Liputan -->
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle" id="tableLiputan">
            <thead class="table-dark">
              <tr>
                <th>Nama Petugas</th>
                <th>Lokasi</th>
                <th>Jenis Kegiatan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Surat Tugas</th>
                <th>Bukti Liputan</th>
              </tr>
            </thead>
            <tbody>
            <?php
$resultLiputan = $conn->query("
    SELECT l.id, p.nama AS nama_petugas, l.lokasi, l.jenis_kegiatan, l.tanggal_mulai, l.tanggal_selesai,
           l.surat_tugas, l.bukti_liputan, l.id_pegawai
    FROM liputan l
    JOIN pegawai p ON l.id_pegawai = p.id
    ORDER BY l.id DESC
");

if ($resultLiputan && $resultLiputan->num_rows > 0) {
    while ($row = $resultLiputan->fetch_assoc()) {

        // Inisialisasi default agar tidak undefined
        $fileSurat = "-";
        $fileBukti = "-";

        // Ambil id liputan
        $idLiputan = intval($row['id']);

        // Siapkan nilai yang aman untuk ditampilkan
        $namaPetugas       = htmlspecialchars($row['nama_petugas'] ?? '-', ENT_QUOTES, 'UTF-8');
        $lokasi            = htmlspecialchars($row['lokasi'] ?? '-', ENT_QUOTES, 'UTF-8');
        $jenis             = htmlspecialchars($row['jenis_kegiatan'] ?? '-', ENT_QUOTES, 'UTF-8');
        $tanggal_mulai     = htmlspecialchars($row['tanggal_mulai'] ?? '-', ENT_QUOTES, 'UTF-8');
        $tanggal_selesai   = htmlspecialchars($row['tanggal_selesai'] ?? '-', ENT_QUOTES, 'UTF-8'); 

        // Surat tugas (jika ada) -> buat link relatif ke folder uploads/
        if (!empty($row['surat_tugas'])) {
            $suratBasename = basename(str_replace('\\', '/', $row['surat_tugas']));
            $suratUrl = "uploads/" . $suratBasename; // sesuaikan jika struktur berbeda
            $fileSurat = "<a href='" . htmlspecialchars($suratUrl, ENT_QUOTES, 'UTF-8') . "' target='_blank' class='btn btn-sm btn-outline-info'>📄 Lihat</a>";
        }

        // Bukti liputan (jika ada) -> link ke uploads/bukti/
        if (!empty($row['bukti_liputan'])) {
            $buktiBasename = basename(str_replace('\\', '/', $row['bukti_liputan']));
            $buktiUrl = "uploads/bukti/" . $buktiBasename; // sesuaikan jika diperlukan
            $fileBukti = "<a href='" . htmlspecialchars($buktiUrl, ENT_QUOTES, 'UTF-8') . "' target='_blank' class='btn btn-sm btn-success'>✅ Lihat Bukti</a>";
        } else {
            // Tampilkan tombol upload hanya jika login sebagai petugas yang ditugaskan
            if (isset($_SESSION['user'])
                && $_SESSION['user']['role'] === 'petugas'
                && intval($_SESSION['user']['id']) === intval($row['id_pegawai'])) {

                $fileBukti = "<a href='pages/upload_bukti.php?id={$idLiputan}' class='btn btn-sm btn-warning'>📤 Upload Bukti</a>";
            } elseif (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
                // Untuk admin kita bisa tampilkan tombol placeholder atau teks
                $fileBukti = "<span class='text-muted'>Belum ada</span>";
            }
        }

        echo "<tr>
                <td>{$namaPetugas}</td>
                <td>{$lokasi}</td>
                <td>{$jenis}</td>
                <td>{$tanggal_mulai}</td>
                <td>{$tanggal_selesai}</td>
                <td>{$fileSurat}</td>
                <td>{$fileBukti}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>⚠️ Tidak ada data liputan</td></tr>";
}

// jangan tutup koneksi di tengah jika masih butuh $conn setelah ini
// $conn->close();
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
