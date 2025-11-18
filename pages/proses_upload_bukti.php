<?php
include '../config/koneksi.php';

$id_liputan = intval($_POST['id_liputan']);

if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/bukti/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $fileName = basename($_FILES['bukti']['name']);
    $fileTmp  = $_FILES['bukti']['tmp_name'];
    $fileSize = $_FILES['bukti']['size'];
    $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed  = ['jpg', 'jpeg', 'png', 'pdf'];

    if (!in_array($fileExt, $allowed)) {
        die("<script>alert('Format tidak diizinkan. Gunakan JPG / PNG / PDF');history.back();</script>");
    }

    if ($fileSize > 5 * 1024 * 1024) {
        die("<script>alert('Ukuran maksimal 5MB');history.back();</script>");
    }

    $newFileName = uniqid('bukti_', true) . '.' . $fileExt;
    $targetPath = $uploadDir . $newFileName;

    if (!move_uploaded_file($fileTmp, $targetPath)) {
        die("<script>alert('Upload gagal!');history.back();</script>");
    }

    // Simpan ke DB
    $conn->query("UPDATE liputan SET bukti_liputan = '$targetPath' WHERE id = $id_liputan");

    echo "<script>alert('✅ Bukti liputan berhasil diupload');window.location='../index.php';</script>";
} else {
    echo "<script>alert('File tidak valid');history.back();</script>";
}
?>
