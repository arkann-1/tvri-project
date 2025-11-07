<?php
include "config/koneksi.php";

$default_pass = password_hash("GantiSaya!123", PASSWORD_DEFAULT);

$sql = "
INSERT INTO users (username, password, role, pegawai_id)
SELECT 
    p.nip,
    '$default_pass',
    'petugas',
    p.id
FROM pegawai p
LEFT JOIN users u ON p.id = u.pegawai_id
WHERE u.pegawai_id IS NULL;
";

if ($conn->query($sql)) {
    echo "✅ User berhasil dibuat dengan password bcrypt.";
} else {
    echo "❌ Error: " . $conn->error;
}
