<?php
include '../config/koneksi.php';

$bulan  = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
$lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : 'Semua';

// Buat kondisi lokasi dinamis
$whereLokasi = "";
if ($lokasi != 'Semua') {
    $whereLokasi = "AND j.lokasi = '$lokasi'";
}

$sql = "
    SELECT 
        p.id AS id_pegawai,
        p.nama AS nama_pegawai,
        COUNT(DISTINCT j.id) AS total_hari_kerja,
        COUNT(DISTINCT l.id) AS total_liputan,
        GROUP_CONCAT(DISTINCT l.jenis_kegiatan SEPARATOR ', ') AS nama_liputan,
        GROUP_CONCAT(DISTINCT l.lokasi SEPARATOR ', ') AS lokasi_liputan
    FROM pegawai p
    LEFT JOIN jadwal_karyawan j 
        ON p.id = j.id_pegawai 
        AND DATE_FORMAT(j.tanggal, '%Y-%m') = '$bulan'
        $whereLokasi
    LEFT JOIN liputan l 
        ON p.id = l.id_pegawai 
        AND DATE_FORMAT(l.tanggal, '%Y-%m') = '$bulan'
    GROUP BY p.id
    HAVING total_hari_kerja > 0
    ORDER BY p.nama ASC
";

$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h4 class="mb-3">
        Rekap Data Bulan <?= htmlspecialchars($bulan); ?> 
        <?= $lokasi != 'Semua' ? "- Lokasi: " . htmlspecialchars($lokasi) : "- Semua Lokasi"; ?>
    </h4>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Total Hari Kerja</th>
                        <th>Jumlah Liputan</th>
                        <th>Nama Liputan</th>
                        <th>Lokasi Liputan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_pegawai']); ?></td>
                            <td class="text-center"><?= (int)$row['total_hari_kerja']; ?></td>
                            <td class="text-center"><?= (int)$row['total_liputan']; ?></td>
                            <td><?= htmlspecialchars($row['nama_liputan'] ?: '-'); ?></td>
                            <td><?= htmlspecialchars($row['lokasi_liputan'] ?: '-'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-center text-muted">
            Tidak ada data untuk bulan ini 
            <?= $lokasi != 'Semua' ? "di lokasi <strong>" . htmlspecialchars($lokasi) . "</strong>." : "." ?>
        </div>
    <?php endif; ?>
</div>
