<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pegawai     = intval($_POST['id_pegawai']);
    $tanggal        = $conn->real_escape_string($_POST['tanggal']);
    $lokasi         = $conn->real_escape_string($_POST['lokasi']);
    $jenis_kegiatan = $conn->real_escape_string($_POST['jenis_kegiatan']);

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
        // Jika tidak ada file, masukkan NULL untuk kolom surat_tugas
        $stmt = $conn->prepare("
            INSERT INTO liputan (tanggal, lokasi, jenis_kegiatan, surat_tugas, id_pegawai)
            VALUES (?, ?, ?, NULL, ?)
        ");
        $stmt->bind_param("sssi", $tanggal, $lokasi, $jenis_kegiatan, $id_pegawai);

    } else {
        // Jika ada file, masukkan path-nya
        $stmt = $conn->prepare("
            INSERT INTO liputan (tanggal, lokasi, jenis_kegiatan, surat_tugas, id_pegawai)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssssi", $tanggal, $lokasi, $jenis_kegiatan, $surat_tugas, $id_pegawai);

    }

    if ($stmt->execute()) {
        echo "<script>alert('✅ Data liputan berhasil disimpan.');window.location='../index.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal menyimpan data: " . $stmt->error . "');history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Metode tidak valid.');history.back();</script>";
}
?>
