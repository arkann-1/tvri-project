<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pegawai      = intval($_POST['id_pegawai']);
    $lokasi          = $conn->real_escape_string($_POST['lokasi']);
    $jenis_kegiatan  = $conn->real_escape_string($_POST['jenis_kegiatan']);
    $tanggal_mulai   = $conn->real_escape_string($_POST['tanggal_mulai']);
    $tanggal_selesai = $conn->real_escape_string($_POST['tanggal_selesai']);

    // ==== Ambil nama pegawai dari tabel pegawai ====
    $result = $conn->query("SELECT nama FROM pegawai WHERE id = $id_pegawai LIMIT 1");
    if ($result && $row = $result->fetch_assoc()) {
        $nama_petugas = $row['nama'];
    } else {
        die("<script>alert('Pegawai tidak ditemukan!');history.back();</script>");
    }

    // ==== Upload file surat tugas (opsional) ====
    $surat_tugas = null;
    if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['file_path']['name']);
        $fileTmp  = $_FILES['file_path']['tmp_name'];
        $fileSize = $_FILES['file_path']['size'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed  = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

        // Validasi ekstensi
        if (!in_array($fileExt, $allowed)) {
            die("<script>alert('Format file tidak diizinkan. Gunakan PDF, DOCX, JPG, atau PNG.');history.back();</script>");
        }

        // Validasi ukuran (maks 5 MB)
        if ($fileSize > 5 * 1024 * 1024) {
            die("<script>alert('Ukuran file maksimal 5MB.');history.back();</script>");
        }

        // Buat nama file unik agar tidak bentrok
        $newFileName = uniqid('surat_', true) . '.' . $fileExt;
        $targetPath  = $uploadDir . $newFileName;

        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($fileTmp, $targetPath)) {
            $surat_tugas = $targetPath;
        } else {
            die("<script>alert('Gagal mengupload file.');history.back();</script>");
        }
    }

    // ==== Simpan data ke database ====
    if ($surat_tugas === null) {
        // Jika tidak ada file
        $stmt = $conn->prepare("
            INSERT INTO liputan (tanggal_mulai, tanggal_selesai, lokasi, jenis_kegiatan, surat_tugas, id_pegawai)
            VALUES (?, ?, ?, ?, ?, NULL, ?)
        ");
        $stmt->bind_param("ssssi", $tanggal_mulai, $tanggal_selesai, $lokasi, $jenis_kegiatan, $id_pegawai);

    } else {
        // Jika ada file
        $stmt = $conn->prepare("
            INSERT INTO liputan (tanggal_mulai, tanggal_selesai, lokasi, jenis_kegiatan, surat_tugas, id_pegawai)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        // ❗️Perbaikan di sini: "ssssssi" tanpa spasi
        $stmt->bind_param("sssssi", $tanggal_mulai, $tanggal_selesai, $lokasi, $jenis_kegiatan, $surat_tugas, $id_pegawai);
    }

    if ($stmt->execute()) {
        // ==== Kirim notifikasi ke Telegram ====
        $botToken = "8199095361:AAEV0Ftgqr2IfkJ8-X9YAl_SGLBRK_jkEbM";
        $chatId   = "5181772967";

        // Jika ada file surat tugas, buat link publik
        $baseUrl = "https://jadwaldinastransmisi.my.id";
        $linkSurat = $baseUrl;

        // Format pesan
        $pesan  = "📢 *Liputan Baru Ditambahkan*\n\n";
        $pesan .= "👤 Petugas: *{$nama_petugas}*\n";
        $pesan .= "📅 Tanggal: *{$tanggal_mulai}* s/d *{$tanggal_selesai}*\n";
        $pesan .= "📍 Lokasi: *{$lokasi}*\n";
        $pesan .= "📝 Kegiatan: *{$jenis_kegiatan}*\n";
        if ($linkSurat) {
            $pesan .= "\n📄 [Lihat Surat Tugas]($linkSurat)";
        }

        // Kirim ke Telegram
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

        echo "<script>alert('✅ Data liputan berhasil disimpan dan notifikasi terkirim.');window.location='../index.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal menyimpan data: " . $stmt->error . "');history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Metode tidak valid.');history.back();</script>";
}
?>
