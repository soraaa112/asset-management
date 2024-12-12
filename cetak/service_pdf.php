<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/fpdf/fpdf.php";

// Variabel SQL
$filterSQL    = "";
# Set Tanggal skrg
$kodeKategori  = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
$dataKataKunci = isset($_GET['txtKataKunci']) ? $_GET['txtKataKunci'] : '';

if ($kodeKategori == "Semua") {
    if ($dataKataKunci == "") {
        $filterSQL = "";
        $namaKategori = "Semua";
    } else {
        $filterSQL = "WHERE barang.nm_barang LIKE'%$dataKataKunci%'";
        $namaKategori = "Semua";
    }
} else {
    if ($dataKataKunci == "") {
        $filterSQL = "WHERE barang.kd_kategori='$kodeKategori'";
    } else {
        $filterSQL = "WHERE barang.kd_kategori='$kodeKategori' AND barang.nm_barang LIKE'%$dataKataKunci%'";
    }
}
?>

<?php

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(270, 10, 'LAPORAN SERVICE BARANG', 0, 0, 'C');

$pdf->Cell(10, 10, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(7, 7, 'No', 1, 0, 'C');
$pdf->Cell(15, 7, 'Tanggal', 1, 0, 'C');
$pdf->Cell(20, 7, 'No. Service', 1, 0, 'C');
$pdf->Cell(20, 7, 'Kode Label', 1, 0, 'C');
$pdf->Cell(70, 7, 'Type Barang', 1, 0, 'C');
$pdf->Cell(30, 7, 'Keterangan', 1, 0, 'C');
$pdf->Cell(40, 7, 'Departemen & Lokasi', 1, 0, 'C');
$pdf->Cell(30, 7, 'Vendor Service', 1, 0, 'C');
$pdf->Cell(25, 7, 'Total Biaya', 1, 0, 'C');

$pdf->Cell(20, 7, '', 0, 1);
$pdf->SetFont('Times', '', 8);
$no = 1;
$mySql  = "SELECT services.*, vendor_service.nm_vendor_service, barang.nm_barang, barang_inventaris.*, departemen.nm_departemen, service_item.keterangan
FROM services 
LEFT JOIN vendor_service ON services.kd_vendor_service=vendor_service.kd_vendor_service
LEFT JOIN service_item on services.no_service=service_item.no_service
LEFT JOIN barang_inventaris on service_item.kd_inventaris=barang_inventaris.kd_inventaris
LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
LEFT JOIN pengadaan on barang_inventaris.no_pengadaan=pengadaan.no_pengadaan
LEFT JOIN petugas on pengadaan.kd_petugas=petugas.kd_petugas
LEFT JOIN departemen on petugas.kd_departemen=departemen.kd_departemen 
$filterSQL
ORDER BY services.no_service DESC";
$myQry  = mysqli_query($koneksidb, $mySql)  or die("Query  salah : " . mysql_error());
while ($d = mysqli_fetch_array($myQry)) {

    $Kode = $d['no_service'];
    $inventaris = $d['kd_inventaris'];

    // Mencari lokasi Penempatan Barang
    if ($d['status_barang'] == "Ditempatkan") {
        $my2Sql = "SELECT lokasi.nm_lokasi, departemen.nm_departemen FROM penempatan_item as PI
              LEFT JOIN penempatan ON PI.no_penempatan=penempatan.no_penempatan
              LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
              LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
              WHERE PI.status_aktif='Yes' AND PI.kd_inventaris='$inventaris'";
        $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
        $my2Data = mysql_fetch_array($my2Qry);
        $infoLokasi  = $my2Data['nm_lokasi'];
        $infoDepartemen = $my2Data['nm_departemen'];
    }

    // Mencari Siapa Penempatan Barang
    if ($d['status_barang'] == "Dipinjam") {
        $my3Sql = "SELECT pegawai.nm_pegawai, departemen.nm_departemen FROM peminjaman_item as PI
              LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
              LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
              LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
              WHERE peminjaman.status_kembali='Pinjam' AND PI.kd_inventaris='$inventaris'";
        $my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query 3 salah : " . mysql_error());
        $my3Data = mysql_fetch_array($my3Qry);
        $infoLokasi  = $my3Data['nm_pegawai'];
        $infoDepartemen = $my2Data['nm_departemen'];
    }

    if ($d['status_barang'] == "Tersedia") {
        $my4Sql = "SELECT pengadaan.*, barang_inventaris.*, petugas.nm_petugas, departemen.nm_departemen FROM pengadaan 
              LEFT JOIN barang_inventaris ON pengadaan.no_pengadaan=barang_inventaris.no_pengadaan
              LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas
              LEFT JOIN departemen ON petugas.kd_departemen=departemen.kd_departemen
              WHERE barang_inventaris.kd_inventaris='$inventaris'";
        $my4Qry = mysql_query($my4Sql, $koneksidb)  or die("Query 4 salah : " . mysql_error());
        $my4Data = mysql_fetch_array($my4Qry);
        $infoLokasi  = $my4Data['status_barang'];
        $infoDepartemen = $my4Data['nm_departemen'];
    }

    # Menghitung Total pengadaan (belanja) setiap nomor transaksi
    $my2Sql = "SELECT harga_service
      FROM service_item WHERE no_service='$Kode'";
    $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
    $my2Data = mysql_fetch_array($my2Qry);

    $pdf->Cell(7, 6, $no++, 1, 0, 'C');
    $pdf->Cell(15, 6, IndonesiaTgl($d['tgl_service']), 1, 0, 'C');
    $pdf->Cell(20, 6, $d['no_service'], 1, 0);
    $pdf->Cell(20, 6, $d['kd_inventaris'], 1, 0);
    $pdf->Cell(70, 6, $d['nm_barang'], 1, 0);
    $pdf->Cell(30, 6, $d['keterangan'], 1, 0);
    $pdf->Cell(40, 6, $infoLokasi . ', ' . $infoDepartemen, 1, 0);
    $pdf->Cell(30, 6, $d['nm_vendor_service'], 1, 0, 'C');
    $pdf->Cell(25, 6, 'Rp. ' . format_angka($my2Data['harga_service']), 1, 1, 'C');
}

$pdf->Output();
?>