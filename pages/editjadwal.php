<?php
include '../config/koneksi.php';

// Ambil daftar pegawai untuk dropdown
$pegawai = $conn->query("SELECT id, nama, nip FROM pegawai");

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$result = $conn->query("SELECT * FROM jadwal_karyawan WHERE id=$id");
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit Jadwal</title>
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
    <a href="/tvri-project/auth/logout.php" class="mt-auto">⚠️ <span class="menu-text">Logout</span></a>
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
    <div class="card-header bg-warning text-dark">
      <h4 class="m-0">✏️ Edit Jadwal</h4>
    </div>
    <div class="card-body">
      <form action="proses_editjadwal.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div class="mb-3">
          <label class="form-label">Pegawai</label>
          <select name="id_pegawai" class="form-select" required>
            <option value="">-- Pilih Pegawai --</option>
            <?php while ($p = $pegawai->fetch_assoc()): ?>
              <option value="<?= $p['id'] ?>" <?= ($data['id_pegawai'] == $p['id'] ? "selected" : "") ?>>
                <?= $p['nama'] ?> (<?= $p['nip'] ?>)
              </option>
            <?php endwhile; ?>
          </select>
        </div>

              <div class="row">
          <div class="col-md-4 mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal'] ?>" required>
          </div>

          <div class="col-md-4 mb-3">
            <label class="form-label">Shift</label>
            <select name="shift" class="form-select" required>
              <option value="1" <?= ($data['shift'] == "1" ? "selected" : "") ?>>Shift 1 (00.00 - 08.00)</option>
              <option value="2" <?= ($data['shift'] == "2" ? "selected" : "") ?>>Shift 2 (08.00 - 16.00)</option>
              <option value="3" <?= ($data['shift'] == "3" ? "selected" : "") ?>>Shift 3 (16.00 - 00.00)</option>
            </select>
          </div>

          <div class="col-md-4 mb-3">
            <label class="form-label">Lokasi</label>
            <select name="lokasi" class="form-select" required>
              <option value="Senayan" <?= ($data['lokasi'] == "Senayan" ? "selected" : "") ?>>Senayan</option>
              <option value="Joglo" <?= ($data['lokasi'] == "Joglo" ? "selected" : "") ?>>Joglo</option>
            </select>
          </div>
        </div>


        <div class="mb-3">
          <label class="form-label">Lokasi</label>
          <select name="lokasi" class="form-select" required>
            <option value="Senayan" <?= ($data['lokasi'] == "Senayan" ? "selected" : "") ?>>Senayan</option>
            <option value="Joglo" <?= ($data['lokasi'] == "Joglo" ? "selected" : "") ?>>Joglo</option>
          </select>
        </div>
        
        <button type="submit" class="btn btn-primary">💾 Update</button>
        <a href="jadwalbulanan.php" class="btn btn-secondary">↩️ Kembali</a>
      </form>
    </div>
  </div>
</div>
  
  <script src="../assets/js/script.js"></script>
</body>
</html>