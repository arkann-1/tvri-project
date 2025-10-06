<?php
include '../config/koneksi.php';

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-warning text-dark">
      <h4 class="m-0">✏️ Edit Jadwal</h4>
    </div>
    <div class="card-body">
      <form action="proses_editjadwal.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div class="mb-3">
          <label class="form-label">NIP</label>
          <input type="text" name="nip" class="form-control" value="<?= $data['nip'] ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Pekerjaan</label>
          <input type="text" name="pekerjaan" class="form-control" value="<?= $data['pekerjaan'] ?>" required>
        </div>

        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal'] ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Shift</label>
          <select name="shift" class="form-select" required>
            <option value="">-- Pilih Shift --</option>
            <option value="1" <?= ($data['shift'] == "1" ? "selected" : "") ?>>Shift 1 (00.00 - 08.00)</option>
            <option value="2" <?= ($data['shift'] == "2" ? "selected" : "") ?>>Shift 2 (08.00 - 16.00)</option>
            <option value="3" <?= ($data['shift'] == "3" ? "selected" : "") ?>>Shift 3 (16.00 - 00.00)</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Lokasi</label>
          <select name="lokasi" class="form-select" required>
            <option value="Senayan" <?= ($data['lokasi'] == "Senayan" ? "selected" : "") ?>>Senayan</option>
            <option value="Joglo" <?= ($data['lokasi'] == "Joglo" ? "selected" : "") ?>>Joglo</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">File saat ini</label><br>
          <?php if ($data['file_path']): ?>
            <a href="<?= $data['file_path'] ?>" target="_blank">📂 Lihat File</a>
          <?php else: ?>
            <span class="text-muted">Belum ada file</span>
          <?php endif; ?>
        </div>

        <div class="mb-3">
          <label class="form-label">Upload File Baru (opsional)</label>
          <input type="file" name="file_path" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">💾 Update</button>
        <a href="jadwalbulanan.php" class="btn btn-secondary">↩️ Kembali</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
