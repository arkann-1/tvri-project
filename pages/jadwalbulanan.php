<?php
include '../config/koneksi.php';

$lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : 'Senayan';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$searchTerms = [];
if ($search !== '') {
    $parts = preg_split('/\s+/u', $search, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($parts as $p) {
        if ($p !== '') {
            $searchTerms[] = $p;
        }
    }
}

$where = [];
$where[] = "MONTH(tanggal) = MONTH(CURDATE())";
$where[] = "YEAR(tanggal) = YEAR(CURDATE())";

if ($lokasi !== 'Semua') {
    $where[] = "lokasi = '".$conn->real_escape_string($lokasi)."'";
}
if (!empty($searchTerms)) {
    $cols = ['nip','nama','shift','jam','pekerjaan','lokasi'];
    foreach ($searchTerms as $t) {
        $tEsc = $conn->real_escape_string($t);
        $like = "%$tEsc%";
        $orParts = [];
        foreach ($cols as $c) {
            $orParts[] = "$c LIKE '$like'";
        }
        $where[] = '('.implode(' OR ', $orParts).')';
    }
}

$sql = "SELECT * FROM jadwal_karyawan";
if (count($where)) {
    $sql .= " WHERE ".implode(" AND ", $where);
}
$sql .= " ORDER BY tanggal ASC, jam ASC"; // mengurutkan dari a - z

$result = $conn->query($sql);

function highlight_terms($text, $terms)
{
    if ($text === null || $text === '' || empty($terms)) {
        return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
    }
    usort($terms, fn ($a, $b) => mb_strlen($b) - mb_strlen($a));
    $pattern = '/('.implode('|', array_map(fn ($t) => preg_quote($t, '/'), $terms)).')/iu';
    return preg_replace_callback(
        $pattern,
        fn ($m) => '<mark class="bg-warning text-dark">'.htmlspecialchars($m[0], ENT_QUOTES, 'UTF-8').'</mark>',
        htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8')
    );
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Jadwal Bulanan</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
  <a href="../index.php">🏠 <span class="menu-text">Beranda</span></a>
  <a href="jadwalbulanan.php">📅 <span class="menu-text">Jadwal Bulanan</span></a>
  <a href="rekap.php">✉️ <span class="menu-text">Rekap</span></a>
</aside>

<!-- Main -->
<main class="main">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded mb-4">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="../assets/images/TVRI.png" alt="TVRI" width="90" class="me-2">
    </a>
    <form method="get" class="d-flex flex-grow-1 mx-3">
      <input class="form-control me-2 flex-grow-1"
             name="search"
             type="text"
             placeholder="Cari ID / Nama / Pekerjaan"
             value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">

      <select class="form-select me-2" style="width:150px;" name="lokasi" onchange="this.form.submit()">
        <option value="Senayan" <?= $lokasi === 'Senayan' ? 'selected' : '' ?>>Senayan</option>
        <option value="Joglo" <?= $lokasi === 'Joglo' ? 'selected' : '' ?>>Joglo</option>
        <option value="Semua" <?= $lokasi === 'Semua' ? 'selected' : '' ?>>Semua</option>
      </select>
      <button class="btn btn-primary" type="submit">🔍 Cari</button>
    </form>
  </div>
</nav>

<h2 class="fw-bold mb-3">📅 Jadwal Bulanan (Lokasi: <?= htmlspecialchars($lokasi) ?>)</h2>

<div class="mb-3">
  <a href="tambahjadwal.php" class="btn btn-success">➕ Tambah Jadwal</a>
</div>

<div class="card shadow">
  <div class="card-body table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID (NIP)</th>
          <th>Nama</th>
          <th>Pekerjaan</th>
          <th>Tanggal</th>
          <th>Jam</th>
          <th>Shift</th>
          <th>File</th>
          <th>Lokasi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $fileHTML = "-";
                if (!empty($row['file_path'])) {
                    $fileHTML = '<a href="../uploads/'.basename(str_replace("\\", "/", $row['file_path'])).'" target="_blank">Lihat File</a>';
                }
                ?>
                <tr>
          <td><?= highlight_terms($row['nip'], $searchTerms) ?></td>
          <td><?= highlight_terms($row['nama'], $searchTerms) ?></td>
          <td><?= highlight_terms($row['pekerjaan'], $searchTerms) ?></td>
          <td><?= highlight_terms($row['tanggal'], $searchTerms) ?></td>
          <td><?= highlight_terms($row['jam'], $searchTerms) ?></td>
          <td><?= highlight_terms($row['shift'], $searchTerms) ?></td>
          <td><?= $fileHTML ?></td>
          <td><?= highlight_terms($row['lokasi'], $searchTerms) ?></td>
          <td>
            <a href="editjadwal.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
            <a href="hapusjadwal.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️ Hapus</a>
          </td>
        </tr>
        <?php endwhile;
        else: ?>
        <tr>
          <td colspan="9" class="text-center text-muted">Tidak ada data.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</main>

  <script src="../assets/js/script.js"></script>
</body>
</html>
