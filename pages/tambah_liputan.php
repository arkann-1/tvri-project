<?php
include '../config/koneksi.php';
$pegawai = $conn->query("SELECT id, nama FROM pegawai ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tambah Jadwal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h4 class="m-0">➕ Tambah Liputan</h4>
    </div>
    <div class="card-body">
      <form action="proses_tambahliputan.php" method="post" enctype="multipart/form-data">
        
        <div class="mb-3">
          <label class="form-label">Pegawai</label>
          <select name="id_pegawai" class="form-select" required>
            <option value="">-- Pilih Pegawai --</option>
            <?php while ($p = $pegawai->fetch_assoc()): ?>
              <option value="<?= $p['id'] ?>">
                <?= $p['nama'] ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal</label>
          <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Lokasi</label>
          <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Gedung TVRI Senayan" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Jenis Kegiatan</label>
          <input type="text" name="jenis_kegiatan" class="form-control" placeholder="Contoh: Peliputan Upacara HUT RI" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Upload Surat Tugas</label>
          <input type="file" name="file_path" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">💾 Simpan</button>
        <a href="../index.php" class="btn btn-secondary">↩️ Kembali</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
