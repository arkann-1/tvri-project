<?php
require '../config/koneksi.php';
require '../vendor/autoload.php'; // phpoffice/phpspreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');

$query = "
SELECT 
    p.id AS id_pegawai,
    p.nama AS nama_pegawai,
    COALESCE(jk.lokasi, '-') AS lokasi,
    COUNT(DISTINCT jk.tanggal) AS total_shift,
    COUNT(DISTINCT l.id) AS total_liputan
FROM pegawai p
LEFT JOIN jadwal_karyawan jk 
    ON p.id = jk.id_pegawai 
    AND DATE_FORMAT(jk.tanggal, '%Y-%m') = '".$conn->real_escape_string($bulan)."'
LEFT JOIN liputan l 
    ON p.id = l.id_pegawai 
    AND (
        DATE_FORMAT(l.tanggal_mulai, '%Y-%m') = '".$conn->real_escape_string($bulan)."'
        OR DATE_FORMAT(l.tanggal_selesai, '%Y-%m') = '".$conn->real_escape_string($bulan)."'
    )
GROUP BY p.id, jk.lokasi
ORDER BY p.nama ASC, jk.lokasi ASC
";


$result = $conn->query($query);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Judul kolom
$sheet->setCellValue('A1', 'Nama Pegawai');
$sheet->setCellValue('B1', 'Lokasi Jadwal');
$sheet->setCellValue('C1', 'Jumlah Shift');
$sheet->setCellValue('D1', 'Jumlah Liputan');
$sheet->setCellValue('E1', 'Nama & Lokasi Liputan');

// Gaya header
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FFB4C6E7']
    ],
    'alignment' => ['horizontal' => 'center']
];
$sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

$row = 2;

if ($result && $result->num_rows > 0) {
    while ($data = $result->fetch_assoc()) {
        $idPegawai = $data['id_pegawai'];
        $lokasiJadwal = $data['lokasi'] !== '-' ? $data['lokasi'] : null;

        $liputanQuery = "
            SELECT jenis_kegiatan, lokasi 
            FROM liputan 
            WHERE id_pegawai = $idPegawai
            AND (
                    DATE_FORMAT(tanggal_mulai, '%Y-%m') = '".$conn->real_escape_string($bulan)."'
                OR DATE_FORMAT(tanggal_selesai, '%Y-%m') = '".$conn->real_escape_string($bulan)."'
            )
        ";
        $liputanResult = $conn->query($liputanQuery);
        $namaLiputan = [];


        while ($lp = $liputanResult->fetch_assoc()) {
            $lokLip = $lp['lokasi'] ?: '-';
            $namaLiputan[] = $lp['jenis_kegiatan'] . " (" . $lokLip . ")";
        }

        $sheet->setCellValue("A$row", $data['nama_pegawai']);
        $sheet->setCellValue("B$row", $lokasiJadwal ?? '-');
        $sheet->setCellValue("C$row", $data['total_shift']);
        $sheet->setCellValue("D$row", $data['total_liputan']);
        $sheet->setCellValue("E$row", !empty($namaLiputan) ? implode(', ', $namaLiputan) : '-');

        $row++;
    }
}

// Auto width untuk semua kolom
foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Tambahkan total di akhir
$sheet->setCellValue("A$row", "TOTAL");
$sheet->setCellValue("C$row", "=SUM(C2:C".($row-1).")");
$sheet->setCellValue("D$row", "=SUM(D2:D".($row-1).")");
$sheet->getStyle("A$row:D$row")->getFont()->setBold(true);

$filename = "Rekap_Bulanan_Gabungan_{$bulan}.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
