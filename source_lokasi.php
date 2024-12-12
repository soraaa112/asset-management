<?php
include_once "library/inc.library.php";
include_once "library/inc.connection.php";

$term = $_GET['term']; // Ambil parameter dari request
$data = array();

$mySql = "SELECT * FROM lokasi WHERE nm_lokasi LIKE '%" . $term . "%' ORDER BY nm_lokasi LIMIT 10";
$myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());

while ($row = mysql_fetch_array($myQry)) {
    $data[] = array(
        'label' => $row['nm_lokasi'], // Nama yang ditampilkan dalam dropdown autocomplete
        'value' => $row['nm_lokasi'], // Nilai yang dimasukkan ke dalam input saat dipilih
    );
}

echo json_encode($data);
?>
