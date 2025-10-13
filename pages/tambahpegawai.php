<?php
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tambah Pegawai</title>
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
      <h4 class="m-0">➕ Tambah Pegawai</h4>
    </div>
    <div class="card-body">
      <form action="proses_tambahpegawai.php" method="post" enctype="multipart/form-data">
        
        <div class="mb-3">
          <label class="form-label">NIP</label>
          <input type="text" name="nip" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Divisi</label>
          <select name="id_divisi" class="form-select" required>
            <option value="">-- Pilih Divisi --</option>
            <?php
            $divisi = $conn->query("SELECT id, divisi FROM divisi");
while ($d = $divisi->fetch_assoc()):
    ?>
              <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['divisi']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <button type="submit" class="btn btn-success">💾 Simpan</button>
        <a href="daftarpegawai.php" class="btn btn-secondary">↩️ Kembali</a>
      </form>
    </div>
  </div>
</div>
</main>
</body>
</html>
