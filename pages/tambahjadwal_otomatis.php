<?php
include '../config/koneksi.php';
$pegawai = $conn->query("SELECT id, nama FROM pegawai ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Buat Jadwal Otomatis</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
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
              while($p = $pegawai->fetch_assoc()):
              ?>
              <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <?php endforeach; ?>
        </div>

        <button type="submit" class="btn btn-success">🔍 Lihat Pratinjau Jadwal</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
