<?php
header("Content-Type: application/json");
include "../config/koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {
    // Ambil seluruh data pegawai beserta nama divisi
    $result = $conn->query("SELECT pegawai.id, pegawai.nama, pegawai.nip, divisi.divisi AS nama_divisi 
        FROM pegawai 
        LEFT JOIN divisi ON pegawai.id_divisi = divisi.ID");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

if ($method === "POST") {
    $nip        = $_POST['nip'];
    $nama       = $_POST['nama'];
    $id_divisi  = $_POST['id_divisi'];

    $stmt = $conn->prepare("INSERT INTO pegawai (nip, nama, id_divisi) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $nip, $nama, $id_divisi);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
}

if ($method === "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_DELETE['id'];
    $conn->query("DELETE FROM pegawai WHERE id = $id");
    echo json_encode(["status" => "deleted"]);
}
?>