<?php

include_once "library/inc.connection.php";

$id             = $_POST['kode'];
$statusBarang   = $_POST['statusBarang'];

$mySql = "UPDATE pengadaan SET status = '$statusBarang' WHERE no_pengadaan='$id'";
$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status" . mysql_error());
var_dump($myQry);

echo "<script>alert('Status Barang Berhasil Diupdate')</script>";
echo "<meta http-equiv='refresh' content='5; url=?open=Pengadaan-Tampil'>";
