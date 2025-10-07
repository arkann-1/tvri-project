<?php
include '../config/koneksi.php';
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
          <label class="form-label">Tim</label>
          <input type="text" name="tim" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">💾 Simpan</button>
        <a href="daftarpegawai.php" class="btn btn-secondary">↩️ Kembali</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
