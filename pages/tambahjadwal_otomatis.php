<?php
$requireAdmin = true;  // hanya admin yang bisa akses halaman ini
include '../auth_check.php';
include '../config/koneksi.php';
$pegawai = $conn->query("SELECT id, nama FROM pegawai ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Buat Jadwal Otomatis</title>
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
    <a href="tambahpegawai.php">➕ <span class="menu-text">Tambah Pegawai</a>
    <a href="tambahjadwal_otomatis.php">➕ <span class="menu-text">Tambah Jadwal</a>
  </aside>

<!-- Main -->
<main class="main">
  <!-- Topbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded mb-4">
      <div class="container-fluid">
        <a class="navbar-brand mx-auto" href="#">
          <img src="../assets/images/TVRI.png" alt="TVRI" width="90" class="d-block mx-auto">
        </a>
       </div>
     </nav> 

<div class="card">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h4 class="m-0">🗓️ Buat Jadwal Otomatis</h4>
    </div>
    <div class="card-body">
      <form action="preview_jadwal.php" method="POST">
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Bulan</label>
            <input type="month" name="bulan" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Lokasi</label>
            <select name="lokasi" class="form-select" required>
              <option value="Senayan">Senayan</option>
              <option value="Joglo">Joglo</option>
            </select>
          </div>
        </div>

        <div class="row">
          <?php
          $grup = ['A','B','C','D'];
foreach ($grup as $g):
    ?>
          <div class="col-md-3 mb-3">
            <label class="form-label">Grup <?= $g ?></label>
            <select name="grup_<?= $g ?>[]" class="form-select" multiple>
              <?php
        $pegawai->data_seek(0);
    while ($p = $pegawai->fetch_assoc()):
        ?>
              <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <?php endforeach; ?>
        </div>
        
        <hr class="my-4">

          <h5 class="mb-3">Pola Shift (isi urutan grup, contoh: DABC / CDAB / ABCD)</h5>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">Shift 1</label>
              <input type="text" name="pola_shift1" class="form-control" placeholder="misal: DABC" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Shift 2</label>
              <input type="text" name="pola_shift2" class="form-control" placeholder="misal: CDAB" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Shift 3</label>
              <input type="text" name="pola_shift3" class="form-control" placeholder="misal: ABCD" required>
            </div>
          </div>

          <hr class="my-4">

        <button type="submit" class="btn btn-success">🔍 Lihat Pratinjau Jadwal</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
