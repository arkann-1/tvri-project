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
      <h4 class="m-0">➕ Tambah Jadwal</h4>
    </div>
    <div class="card-body">
      <form action="proses_tambahjadwal.php" method="post" enctype="multipart/form-data">
        
        <div class="mb-3">
          <label class="form-label">NIP</label>
          <input type="text" name="nip" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Pekerjaan</label>
          <input type="text" name="pekerjaan" class="form-control" required>
        </div>

        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">Jam Mulai</label>
            <input type="time" name="jam_mulai" class="form-control" required>
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">Jam Selesai</label>
            <input type="time" name="jam_selesai" class="form-control" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Shift</label>
          <select name="shift" class="form-select" required>
            <option value="">-- Pilih Shift --</option>
            <option value="Pagi">Pagi</option>
            <option value="Siang">Siang</option>
            <option value="Malam">Malam</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Lokasi</label>
          <select name="lokasi" class="form-select" required>
            <option value="Senayan">Senayan</option>
            <option value="Joglo">Joglo</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Upload File (opsional)</label>
          <input type="file" name="file_path" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">💾 Simpan</button>
        <a href="jadwalbulanan.php" class="btn btn-secondary">↩️ Kembali</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
