<?php
// rekap.php
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
$lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : 'Senayan';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Rekap Bulanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f5f7fa; }
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: 0.3s;
    }
    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }
    .card-header {
        font-weight: bold;
        background: linear-gradient(135deg, #0061ff, #60efff);
        color: white;
        border-radius: 16px 16px 0 0;
    }
  </style>
</head>
<body>

<div class="container py-4">
  <h2 class="mb-4 text-center">📊 Dashboard Rekap Bulanan Pegawai</h2>

  <!-- Filter Bulan & Lokasi -->
  <form method="get" class="mb-4 text-center">
      <div class="row justify-content-center g-2">
          <div class="col-auto">
              <input type="month" name="bulan" class="form-control" value="<?= htmlspecialchars($bulan); ?>">
          </div>
          <div class="col-auto">
              <select name="lokasi" class="form-select">
                  <option value="Senayan" <?= $lokasi == 'Senayan' ? 'selected' : ''; ?>>Senayan</option>
                  <option value="Joglo" <?= $lokasi == 'Joglo' ? 'selected' : ''; ?>>Joglo</option>
              </select>
          </div>
          <div class="col-auto">
              <button class="btn btn-primary">Tampilkan</button>
              <a href="rekap.php" class="btn btn-secondary">Reset</a>
          </div>
      </div>
  </form>

  <!-- Area Card Rekap -->
  <div class="row g-4">
      <?php include 'proses_rekap.php'; ?>
  </div>
</div>

</body>
</html>
