<?php
// cron_send_liputan_reminder.php
include '../config/koneksi.php';

// === Konfigurasi Bot Telegram ===
$botToken = "8199095361:AAEV0Ftgqr2IfkJ8-X9YAl_SGLBRK_jkEbM"; // Ganti dengan token kamu
$chatId   = "5181772967"; // Ganti dengan chat ID tujuan
$baseUrl  = "https://jadwaldinastransmisi.my.id"; // URL websitemu

// === Ambil liputan yang dimulai hari ini ===
$today = date('Y-m-d');
$sql = "
    SELECT l.*, p.nama AS nama_petugas
    FROM liputan l
    JOIN pegawai p ON l.id_pegawai = p.id
    WHERE l.tanggal_mulai = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Tidak ada liputan yang dimulai hari ini.\n";
    exit;
}

// === Loop dan kirim notifikasi ===
while ($row = $result->fetch_assoc()) {
    $nama      = $row['nama_petugas'];
    $lokasi    = $row['lokasi'];
    $kegiatan  = $row['jenis_kegiatan'];
    $mulai     = date('d M Y', strtotime($row['tanggal_mulai']));
    $selesai   = date('d M Y', strtotime($row['tanggal_selesai']));
    $fileLink  = $row['surat_tugas'] 
                    ? $baseUrl . "/uploads/" . basename($row['surat_tugas'])
                    : null;

    $pesan  = "📅 *Pengingat Liputan Hari Ini*\n\n";
    $pesan .= "👤 Petugas: *{$nama}*\n";
    $pesan .= "📍 Lokasi: *{$lokasi}*\n";
    $pesan .= "📝 Kegiatan: *{$kegiatan}*\n";
    $pesan .= "📆 Jadwal: *{$mulai}* s/d *{$selesai}*\n";
    if ($fileLink) {
        $pesan .= "\n📄 [Lihat Surat Tugas]($fileLink)";
    }

    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $pesan,
        'parse_mode' => 'Markdown'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_exec($ch);
    curl_close($ch);
}

echo "✅ Notifikasi pengingat berhasil dikirim.\n";

$stmt->close();
$conn->close();
?>
