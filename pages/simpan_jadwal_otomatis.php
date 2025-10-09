<?php
include '../config/koneksi.php';

$bulan = $_POST['bulan'];
$lokasi = $_POST['lokasi'];
$grup_A = $_POST['grup_A'] ?? [];
$grup_B = $_POST['grup_B'] ?? [];
$grup_C = $_POST['grup_C'] ?? [];
$grup_D = $_POST['grup_D'] ?? [];

$pola = ($lokasi==='Senayan') ? ['A','B','C','D'] : ['A','B','C'];
$shift_map = ['A'=>1,'B'=>2,'C'=>3,'D'=>1];
$jam_map = [1=>"00:00 - 08:00",2=>"08:00 - 16:00",3=>"16:00 - 00:00"];
$jumlah_hari = date('t', strtotime("$bulan-01"));

$all_groups = ['A'=>$grup_A,'B'=>$grup_B,'C'=>$grup_C];
if($lokasi==='Senayan') $all_groups['D']=$grup_D;

foreach($all_groups as $kode=>$list){
  foreach($list as $id_peg){
    for($d=1;$d<=$jumlah_hari;$d++){
      $tanggal = sprintf("%s-%02d", $bulan, $d);
      $shift = $shift_map[$pola[($d-1)%count($pola)]];
      $jam = $jam_map[$shift];

      $conn->query("INSERT INTO jadwal_karyawan (id_pegawai, tanggal, shift, jam, lokasi)
                    VALUES ('$id_peg', '$tanggal', '$shift', '$jam', '$lokasi')");
    }
  }
}

echo "<script>alert('Jadwal otomatis berhasil disimpan untuk $lokasi'); window.location='jadwalbulanan.php';</script>";
