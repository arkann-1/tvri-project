<?php
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Jadwal Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="mb-4 text-center">📋 Rekap Jadwal Pegawai</h3>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="bulan" class="form-label">Bulan</label>
            <input type="month" id="bulan" name="bulan" class="form-control"
                   value="<?= htmlspecialchars($_GET['bulan'] ?? date('Y-m')) ?>">
        </div>
        <select id="lokasi" name="lokasi" class="form-select">
            <option value="Semua" <?= ($lokasi ?? '') == 'Semua' ? 'selected' : '' ?>>Semua Lokasi</option>
            <option value="Senayan" <?= ($lokasi ?? '') == 'Senayan' ? 'selected' : '' ?>>Senayan</option>
            <option value="Joglo" <?= ($lokasi ?? '') == 'Joglo' ? 'selected' : '' ?>>Joglo</option>
        </select>

        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <a href="export_rekap.php?bulan=<?= urlencode($_GET['bulan'] ?? date('Y-m')) ?>&lokasi=<?= urlencode($_GET['lokasi'] ?? 'Senayan') ?>"
               class="btn btn-success w-100">📊 Export ke Excel</a>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php include 'proses_rekap.php'; ?>
        </div>
    </div>
</div>

</body>
</html>
