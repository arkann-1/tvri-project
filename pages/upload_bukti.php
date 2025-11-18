<?php
session_start();
include '../config/koneksi.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'petugas') {
    die("Akses ditolak");
}

if (!isset($_GET['id'])) {
    die("ID liputan tidak ditemukan");
}

$id_liputan = intval($_GET['id']);

// Ambil data liputan dan cek apakah pemiliknya
$q = $conn->query("SELECT id_pegawai FROM liputan WHERE id=$id_liputan LIMIT 1");
$row = $q->fetch_assoc();

if (!$row || $row['id_pegawai'] != $_SESSION['user']['id']) {
    die("Tidak berhak upload untuk liputan ini");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Bukti Liputan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- tambahkan ini -->
    <style>
        /* Tambahan spesifik halaman ini */
        .upload-wrapper {
            max-width: 500px;
            margin: 60px auto;
        }
        .upload-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            background: #fff;
        }
        .upload-card .card-body {
            padding: 1.75rem;
        }
        .btn-primary {
            width: 100%;
            background-color: var(--blue);
            border: none;
        }
        .btn-primary:hover {
            background-color: var(--navy);
        }

        @media (max-width: 576px) {
            .upload-wrapper {
                margin: 30px 10px;
            }
            h3 {
                font-size: 1.25rem;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="main">
        <div class="upload-wrapper">
            <div class="card upload-card">
                <div class="card-body">
                    <h3 class="mb-4 text-center">Upload Bukti Liputan</h3>

                    <form action="proses_upload_bukti.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_liputan" value="<?= $id_liputan ?>">

                        <div class="mb-3">
                            <label class="form-label">Pilih File Bukti (jpg/png/pdf)</label>
                            <input type="file" name="bukti" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
