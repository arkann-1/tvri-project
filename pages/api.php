    <?php
    header("Content-Type: application/json");
include "../config/koneksi.php";


$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {
    $result = $conn->query("SELECT * FROM karyawan");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

if ($method === "POST") {
    $nip       = $_POST['nip'];
    $nama      = $_POST['nama'];
    $shift     = $_POST['shift'];
    $jam       = $_POST['jam'];
    $pekerjaan = $_POST['pekerjaan'];

    $stmt = $conn->prepare("INSERT INTO karyawan (nip, nama, shift, jam, pekerjaan) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nip, $nama, $shift, $jam, $pekerjaan);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
}

if ($method === "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_DELETE['id'];
    $conn->query("DELETE FROM karyawan WHERE id = $id");
    echo json_encode(["status" => "deleted"]);
}
?>
