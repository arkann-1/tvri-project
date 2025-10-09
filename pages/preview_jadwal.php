<?php
include '../config/koneksi.php';

$bulan = $_POST['bulan'];
$lokasi = $_POST['lokasi'];
$grup_A = $_POST['grup_A'] ?? [];
$grup_B = $_POST['grup_B'] ?? [];
$grup_C = $_POST['grup_C'] ?? [];
$grup_D = $_POST['grup_D'] ?? [];

// Pola rotasi
if ($lokasi === 'Senayan') {
  $pola = ['A','B','C','D'];
} else {
  $pola = ['A','B','C'];
}

$jumlah_hari = date('t', strtotime("$bulan-01"));
$shift_map = ['A'=>1,'B'=>2,'C'=>3,'D'=>1];
$jam_map = [1=>"00:00 - 08:00",2=>"08:00 - 16:00",3=>"16:00 - 00:00"];

function getNama($conn,$id){
  $r = $conn->query("SELECT nama FROM pegawai WHERE id=$id");
  $d = $r->fetch_assoc();
  return $d['nama'] ?? '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pratinjau Jadwal Otomatis</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  table { font-size: 12px; white-space: nowrap; }
  th, td { text-align: center; }
</style>
</head>
<body class="p-4 bg-light">
<div class="container-fluid">
  <div class="card shadow">
    <div class="card-header bg-info text-white">
      <h4 class="m-0">🧩 Pratinjau Jadwal Otomatis (<?= ucfirst($lokasi) ?>)</h4>
    </div>
    <div class="card-body">
      <form action="simpan_jadwal_otomatis.php" method="POST">
        <input type="hidden" name="bulan" value="<?= $bulan ?>">
        <input type="hidden" name="lokasi" value="<?= $lokasi ?>">
        <?php foreach(['A','B','C','D'] as $g): ?>
          <?php if(isset($_POST["grup_$g"])): ?>
            <?php foreach($_POST["grup_$g"] as $id): ?>
              <input type="hidden" name="grup_<?= $g ?>[]" value="<?= $id ?>">
            <?php endforeach; ?>
          <?php endif; ?>
        <?php endforeach; ?>

        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead class="table-primary">
              <tr>
                <th>Pegawai</th>
                <?php for($d=1;$d<=$jumlah_hari;$d++): ?>
                  <th><?= $d ?></th>
                <?php endfor; ?>
              </tr>
            </thead>
            <tbody>
              <?php
              $all_groups = ['A'=>$grup_A,'B'=>$grup_B,'C'=>$grup_C];
              if($lokasi==='Senayan') $all_groups['D']=$grup_D;
              
              foreach($all_groups as $kode=>$list){
                foreach($list as $id_peg){
                  echo "<tr><td>".getNama($conn,$id_peg)." (Grup $kode)</td>";
                  for($d=1;$d<=$jumlah_hari;$d++){
                    $shift = $shift_map[$pola[($d-1)%count($pola)]];
                    echo "<td>Shift $shift<br><small>".$jam_map[$shift]."</small></td>";
                  }
                  echo "</tr>";
                }
              }
              ?>
            </tbody>
          </table>
        </div>

        <button type="submit" class="btn btn-success">💾 Simpan ke Database</button>
        <a href="tambahjadwal_otomatis.php" class="btn btn-secondary">↩️ Kembali</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
