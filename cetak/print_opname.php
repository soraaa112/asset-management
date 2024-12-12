<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

# Set Tanggal skrg

$kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua';

// PILIH KATEGORI
if ($kodeDepartemen == "Semua") {
    $filterSQL = "";
} else {
    $filterSQL = "AND departemen.kd_departemen = '$kodeDepartemen'";

    $cekSql = "SELECT * FROM departemen WHERE kd_departemen='$kodeDepartemen'";
    $cekQry = mysql_query($cekSql, $koneksidb) or die("Eror Query" . mysql_error());
    $dataCek = mysql_fetch_array($cekQry);
    $namaDepartemen = $dataCek['nm_departemen'];
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();

// Set the picture name
$drawing->setName('PhpSpreadsheet logo');

// Set the picture path
$drawing->setPath('../images/oase.png');

// Set the cell address where the picture will be inserted
$drawing->setCoordinates('A2');
$drawing->setHeight(187);
$drawing->setWidth(105);

// Add the drawing to the worksheet
$drawing->setWorksheet($spreadsheet->getActiveSheet());

$hari = date('Y-m-d');
$tanggal = hari_ini() . ", " . Indonesia2Tgl($hari);
$tahunSekarang = date('Y');
$tahunLalu = $tahunSekarang - 1;
$duaTahunLalu = $tahunSekarang - 2;
$tigaTahunLalu = $tahunSekarang - 3;

$sheet->getStyle('D1:I4')->getFont()->setSize(16)->setBold(true);
$sheet->getStyle('K1:M4')->getFont()->setSize(9);
$sheet->getStyle('A10:M11')->getFont()->setBold(true);
$sheet->getStyle('D1:I4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER_CONTINUOUS);
$sheet->getStyle('A10:M11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER_CONTINUOUS);
$sheet->getStyle('A1:M4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$sheet->getStyle('L5:M5')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
$sheet->getStyle('A5:M5')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);

$sheet->getColumnDimension('A')->setWidth(4.29);
$sheet->getColumnDimension('B')->setWidth(5.29);
$sheet->getColumnDimension('C')->setWidth(5.57);
$sheet->getColumnDimension('F')->setWidth(3.86);
$sheet->getColumnDimension('G')->setWidth(3.86);
$sheet->getColumnDimension('K')->setWidth(10.29);
$sheet->getRowDimension('1')->setRowHeight(12.00);
$sheet->getRowDimension('2')->setRowHeight(12.00);
$sheet->getRowDimension('3')->setRowHeight(12.00);
$sheet->getRowDimension('4')->setRowHeight(12.00);
$sheet->getRowDimension('10')->setRowHeight(10.50);
$sheet->getRowDimension('11')->setRowHeight(10.50);

$sheet->mergeCells('A1:C4');
$sheet->mergeCells('D1:I2');
$sheet->mergeCells('J1:J2');
$sheet->mergeCells('J3:J4');
$sheet->mergeCells('L1:M1');
$sheet->mergeCells('L2:M2');
$sheet->mergeCells('D3:I4');
$sheet->mergeCells('L3:M3');
$sheet->mergeCells('L4:M4');
$sheet->mergeCells('A6:C6');
$sheet->mergeCells('A7:C7');
$sheet->mergeCells('A10:A11');
$sheet->mergeCells('B10:E11');
$sheet->mergeCells('F10:G11');
$sheet->mergeCells('H10:H11');
$sheet->mergeCells('I10:I11');
$sheet->mergeCells('J10:J11');
$sheet->mergeCells('K10:M11');
$sheet->setCellValue('D1', 'FORMULIR');
$sheet->setCellValue('K1', 'No Dokumen');
$sheet->setCellValue('K2', 'Tgl Berlaku');
$sheet->setCellValue('D3', 'OPNAME INVENTARIS TAHUNAN');
$sheet->setCellValue('K3', 'No Revisi');
$sheet->setCellValue('K4', 'Halaman');
$sheet->setCellValue('A6', 'Unit');
if ($kodeDepartemen == "Semua") {
    $sheet->setCellValue('D6', ': Semua');
} else {
    $sheet->setCellValue('D6', ': ' . $namaDepartemen);
}
$sheet->setCellValue('A7', 'Hari/Tanggal');
$sheet->setCellValue('D7', ': ' . $tanggal);
$sheet->setCellValue('A10', 'No');
$sheet->setCellValue('B10', 'Jenis Barang');
$sheet->setCellValue('F10', $tigaTahunLalu);
$sheet->setCellValue('H10', $duaTahunLalu);
$sheet->setCellValue('I10', $tahunLalu);
$sheet->setCellValue('J10', $tahunSekarang);
$sheet->setCellValue('K10', 'Keterangan');

$mySql  = "SELECT opname.kd_opname, barang.nm_barang, barang.kd_barang, barang_inventaris.kd_inventaris, lokasi.nm_lokasi, pegawai.nm_pegawai, petugas.nm_petugas, departemen.nm_departemen, opname.status
        FROM opname
        LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
        LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
        LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
        LEFT JOIN penempatan_item ON barang_inventaris.kd_inventaris = penempatan_item.kd_inventaris
        LEFT JOIN penempatan ON penempatan_item.no_penempatan = penempatan.no_penempatan
        LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
        LEFT JOIN peminjaman_item ON barang_inventaris.kd_inventaris = peminjaman_item.kd_inventaris
        LEFT JOIN peminjaman ON peminjaman_item.no_peminjaman = peminjaman.no_peminjaman
        LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
        LEFT JOIN pengadaan ON barang_inventaris.no_pengadaan = pengadaan.no_pengadaan
        LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
        LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen OR pegawai.kd_departemen = departemen.kd_departemen
        WHERE barang.kd_barang != barang.kd_barang AND barang_inventaris.status_barang = 'Tersedia' $filterSQL OR (peminjaman.status_kembali = 'Pinjam' $filterSQL) OR (penempatan_item.status_aktif = 'Yes' $filterSQL) GROUP BY barang.kd_barang ASC";
$myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
$i = 12;
$no = 1;
while ($d = mysql_fetch_array($myQry)) {
    $Kode = $d['kd_opname'];
    $barang = $d['kd_barang'];

    if ($kodeDepartemen == "Semua") {

        $my4Sql = "SELECT COUNT(barang.kd_barang) AS jumlah FROM opname_item
                LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
                LEFT JOIN opname ON opname_item.kd_opname = opname.kd_opname
                WHERE barang.kd_barang = '$barang' AND opname_item.kd_opname != '' AND SUBSTRING(opname.tahun_opname, 1, 4) = '$tahunSekarang'";
        $my4Qry = mysql_query($my4Sql, $koneksidb)  or die("Query salah : " . mysql_error());
        $my4Data = mysql_fetch_array($my4Qry);

        $my3Sql = "SELECT COUNT(barang.kd_barang) AS jumlah FROM opname_item
                LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
                LEFT JOIN opname ON opname_item.kd_opname = opname.kd_opname
                WHERE barang.kd_barang = '$barang' AND opname_item.kd_opname != '' AND SUBSTRING(opname.tahun_opname, 1, 4) = '$tahunLalu'";
        $my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query salah : " . mysql_error());
        $my3Data = mysql_fetch_array($my3Qry);

        $my2Sql = "SELECT COUNT(barang.kd_barang) AS jumlah FROM opname_item
                LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
                LEFT JOIN opname ON opname_item.kd_opname = opname.kd_opname
                WHERE barang.kd_barang = '$barang' AND opname_item.kd_opname != '' AND SUBSTRING(opname.tahun_opname, 1, 4) = '$duaTahunLalu'";
        $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query salah : " . mysql_error());
        $my2Data = mysql_fetch_array($my2Qry);

        $my1Sql = "SELECT COUNT(barang.kd_barang) AS jumlah FROM opname_item
                LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
                LEFT JOIN opname ON opname_item.kd_opname = opname.kd_opname
                WHERE barang.kd_barang = '$barang' AND opname_item.kd_opname != '' AND SUBSTRING(opname.tahun_opname, 1, 4) = '$tigaTahunLalu'";
        $my1Qry = mysql_query($my1Sql, $koneksidb)  or die("Query salah : " . mysql_error());
        $my1Data = mysql_fetch_array($my1Qry);
    } else {

        $my4Sql = "SELECT COUNT(barang.kd_barang) AS jumlah FROM opname
                LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
                LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
                LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
                LEFT JOIN penempatan_item ON barang_inventaris.kd_inventaris = penempatan_item.kd_inventaris
                LEFT JOIN penempatan ON penempatan_item.no_penempatan = penempatan.no_penempatan
                LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
                LEFT JOIN peminjaman_item ON barang_inventaris.kd_inventaris = peminjaman_item.kd_inventaris
                LEFT JOIN peminjaman ON peminjaman_item.no_peminjaman = peminjaman.no_peminjaman
                LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
                LEFT JOIN pengadaan ON barang_inventaris.no_pengadaan = pengadaan.no_pengadaan
                LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
                LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen OR pegawai.kd_departemen = departemen.kd_departemen
                WHERE barang.kd_barang = '$barang' AND opname_item.kd_opname != '' AND SUBSTRING(opname.tahun_opname, 1, 4) = '$tahunSekarang' $filterSQL";
        $my4Qry = mysql_query($my4Sql, $koneksidb)  or die("Query salah : " . mysql_error());
        $my4Data = mysql_fetch_array($my4Qry);

        $my3Sql = "SELECT COUNT(barang.kd_barang) AS jumlah FROM opname
                LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
                LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
                LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
                LEFT JOIN penempatan_item ON barang_inventaris.kd_inventaris = penempatan_item.kd_inventaris
                LEFT JOIN penempatan ON penempatan_item.no_penempatan = penempatan.no_penempatan
                LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
                LEFT JOIN peminjaman_item ON barang_inventaris.kd_inventaris = peminjaman_item.kd_inventaris
                LEFT JOIN peminjaman ON peminjaman_item.no_peminjaman = peminjaman.no_peminjaman
                LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
                LEFT JOIN pengadaan ON barang_inventaris.no_pengadaan = pengadaan.no_pengadaan
                LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
                LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen OR pegawai.kd_departemen = departemen.kd_departemen
                WHERE barang.kd_barang = '$barang' AND opname_item.kd_opname != '' AND SUBSTRING(opname.tahun_opname, 1, 4) = '$tahunLalu' $filterSQL";
        $my3Qry = mysql_query($my3Sql, $koneksidb)  or die("Query salah : " . mysql_error());
        $my3Data = mysql_fetch_array($my3Qry);

        $my2Sql = "SELECT COUNT(barang.kd_barang) AS jumlah FROM opname
                LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
                LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
                LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
                LEFT JOIN penempatan_item ON barang_inventaris.kd_inventaris = penempatan_item.kd_inventaris
                LEFT JOIN penempatan ON penempatan_item.no_penempatan = penempatan.no_penempatan
                LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
                LEFT JOIN peminjaman_item ON barang_inventaris.kd_inventaris = peminjaman_item.kd_inventaris
                LEFT JOIN peminjaman ON peminjaman_item.no_peminjaman = peminjaman.no_peminjaman
                LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
                LEFT JOIN pengadaan ON barang_inventaris.no_pengadaan = pengadaan.no_pengadaan
                LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
                LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen OR pegawai.kd_departemen = departemen.kd_departemen
                WHERE barang.kd_barang = '$barang' AND opname_item.kd_opname != '' AND SUBSTRING(opname.tahun_opname, 1, 4) = '$duaTahunLalu' $filterSQL";
        $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query salah : " . mysql_error());
        $my2Data = mysql_fetch_array($my2Qry);

        $my1Sql = "SELECT COUNT(barang.kd_barang) AS jumlah FROM opname
                LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
                LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
                LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
                LEFT JOIN penempatan_item ON barang_inventaris.kd_inventaris = penempatan_item.kd_inventaris
                LEFT JOIN penempatan ON penempatan_item.no_penempatan = penempatan.no_penempatan
                LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
                LEFT JOIN peminjaman_item ON barang_inventaris.kd_inventaris = peminjaman_item.kd_inventaris
                LEFT JOIN peminjaman ON peminjaman_item.no_peminjaman = peminjaman.no_peminjaman
                LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
                LEFT JOIN pengadaan ON barang_inventaris.no_pengadaan = pengadaan.no_pengadaan
                LEFT JOIN petugas ON pengadaan.kd_petugas = petugas.kd_petugas
                LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen OR pegawai.kd_departemen = departemen.kd_departemen
                WHERE barang.kd_barang = '$barang' AND opname_item.kd_opname != '' AND SUBSTRING(opname.tahun_opname, 1, 4) = '$tigaTahunLalu' $filterSQL";
        $my1Qry = mysql_query($my1Sql, $koneksidb)  or die("Query salah : " . mysql_error());
        $my1Data = mysql_fetch_array($my1Qry);
    }

    $sheet->setCellValue('A' . $i, $no++);
    $sheet->mergeCells('B' . $i . ':E' . $i);
    $sheet->setCellValue('B' . $i, $d['nm_barang']);
    $sheet->mergeCells('F' . $i . ':G' . $i);
    if ($my1Data['jumlah'] == 0) {
        $sheet->setCellValue('F' . $i, ' ');
    } else {
        $sheet->setCellValue('F' . $i, $my1Data['jumlah'] . ' unit');
    }

    if ($my2Data['jumlah'] == 0) {
        $sheet->setCellValue('H' . $i, ' ');
    } else {
        $sheet->setCellValue('H' . $i, $my2Data['jumlah'] . ' unit');
    }

    if ($my3Data['jumlah'] == 0) {
        $sheet->setCellValue('I' . $i, ' ');
    } else {
        $sheet->setCellValue('I' . $i, $my3Data['jumlah'] . ' unit');
    }

    if ($my4Data['jumlah'] == 0) {
        $sheet->setCellValue('J' . $i, ' ');
    } else {
        $sheet->setCellValue('J' . $i, $my4Data['jumlah'] . ' unit');
    }
    $sheet->mergeCells('K' . $i . ':M' . $i);
    $sheet->setCellValue('K' . $i, '');
    $sheet->getStyle('A' . $i . ':M' . $i)->getFont()->setSize(10);
    $sheet->getStyle('F' . $i . ':J' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $sheet->getStyle('A10:M' . $i)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $i++;

}

$writer = new Xlsx($spreadsheet);
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=opname.xlsx");
header("Cache-Control: max-age=0");
header("Expires: Fri, 11 Nov 2011 11:11:11 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: cache, must-revalidate");
header("Pragma: public");
$writer->save("php://output");
