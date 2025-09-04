<?php
include 'config/koneksi.php';

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
$sql = "SELECT * FROM jadwal_karyawan";
if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY nama ASC";

$result = $conn->query($sql);
$queryError = false;
if (!$result) {
    error_log("SQL Error ({$conn->errno}): {$conn->error} — Query: {$sql}");
    $queryError = true;
}

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
  <style>
    :root { --sb-wide: 220px; --sb-narrow: 72px; }
    body { background-color: #f8f9fa; }
    .sidebar{ height:100vh; background:linear-gradient(180deg,#052a6b,#031433); padding-top:1rem; position:fixed; top:0; left:0; width:var(--sb-wide); transition:width .28s ease; overflow:hidden; }
    .sidebar a{ color:#fff; display:flex; align-items:center; gap:.65rem; padding:10px 16px; text-decoration:none; white-space:nowrap; }
    .sidebar a:hover{ background:#495057; }
    .menu-text{ transition:opacity .18s ease; }
    .sidebar.collapsed .menu-text{ opacity:0; visibility:hidden; }
    .pin-btn{ display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border:1px solid rgba(255,255,255,.5); background:transparent; color:#fff; border-radius:8px; font-size:16px; }
    .main{ margin-left:var(--sb-wide); padding:20px; transition:margin-left .28s ease; }
    .sidebar.collapsed ~ .main{ margin-left:var(--sb-narrow); }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="d-flex align-items-center justify-content-between px-3 mb-3">
      <div class="d-flex align-items-center gap-2">
        <button id="pinSidebar" class="pin-btn" title="Collapse/Expand">📌</button>
        <h4 class="m-0 ms-3 text-light">MENU</h4>
      </div>
    </div>
    <a href="index.php">🏠 <span class="menu-text">Beranda</span></a>
    <a href="pages/jadwalbulanan.php">📅 <span class="menu-text">Jadwal Bulanan</span></a>
    <a href="pages/rekap.php">✉️ <span class="menu-text">Rekap</span></a>
  </aside>

  <!-- Main -->
  <main class="main">
    <!-- Topbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded mb-4">
      <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
          <img src="assets/images/TVRI.png" alt="TVRI" width="90" class="me-2">
        </a>
        <form method="get" class="d-flex flex-grow-1 mx-3">
          <input class="form-control me-2 flex-grow-1"
                 id="searchInput"
                 name="search"
                 type="text"
                 placeholder="Cari ID / Nama / Pekerjaan"
                 value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">

          <select class="form-select me-2" style="width:150px;" name="lokasi" onchange="this.form.submit()">
            <option value="Senayan" <?= $lokasi === 'Senayan' ? 'selected' : ''; ?>>Senayan</option>
            <option value="Joglo"   <?= $lokasi === 'Joglo' ? 'selected' : ''; ?>>Joglo</option>
            <option value="Semua"   <?= $lokasi === 'Semua' ? 'selected' : ''; ?>>Semua</option>
          </select>

          <button class="btn btn-primary" type="submit">🔍 Cari</button>
        </form>
      </div>
    </nav>
    

<!-- Content -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold">📋 Jadwal Hari Ini</h2>
  </div>

    <div class="card shadow">
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
          <table class="table table-striped table-hover align-middle" id="scheduleTable">
            <thead class="table-dark">
              <tr>
                <th>ID (NIP)</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Shift</th>
                <th>Jam</th>
                <th>Pekerjaan</th>
                <th>File</th>
                <th>Lokasi</th>
              </tr>
            </thead>
            <tbody>
            <?php
              if ($result && $result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      $shiftVal = $row['shift'] ?? '';
                      $fileHTML = "-";
                      if (!empty($row['file_path'])) {
                          $filename = basename(str_replace('\\', '/', $row['file_path']));
                          $fileUrl = "uploads/" . $filename;
                          $fileHTML = "<a href='" . htmlspecialchars($fileUrl, ENT_QUOTES, 'UTF-8') . "' target='_blank' class='btn btn-sm btn-outline-info'>Lihat File</a>";
                      }
                      echo "<tr>".
                           "<td>".highlight_terms($row['nip'] ?? '', $searchTerms)."</td>".
                           "<td>".highlight_terms($row['nama'] ?? '', $searchTerms)."</td>".
                           "<td>".highlight_terms($row['tanggal'] ?? '', $searchTerms)."</td>".
                           "<td>".highlight_terms($shiftVal, $searchTerms)."</td>".
                           "<td>".highlight_terms($row['jam'] ?? '', $searchTerms)."</td>".
                           "<td>".highlight_terms($row['pekerjaan'] ?? '', $searchTerms)."</td>".
                           "<td>".$fileHTML."</td>".
                           "<td>".highlight_terms($row['lokasi'] ?? '', $searchTerms)."</td>".
                           "</tr>";
                  }
              } else {
                  echo "<tr><td colspan='8' class='text-center'>⚠️ Tidak ada data</td></tr>";
              }
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
