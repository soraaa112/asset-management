<?php
include_once "library/inc.library.php";
include_once "library/inc.connection.php";

$searchTerm = $_GET['term']; // Menerima kiriman data dari inputan pengguna

$sql = "SELECT * FROM departemen WHERE nm_departemen LIKE '%" . $searchTerm . "%' ORDER BY nm_departemen ASC LIMIT 10"; // query sql untuk menampilkan data mahasiswa dengan operator LIKE

$hasil = mysqli_query($koneksidb, $sql); //Query dieksekusi

//Disajikan dengan menggunakan perulangan
while ($row = mysqli_fetch_array($hasil)) {
    $data[] = $row['nm_departemen'];
}
//Nilainya disimpan dalam bentuk json
echo json_encode($data);