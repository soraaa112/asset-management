<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/fpdf/fpdf.php";
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


if (isset($_POST['btnPdf'])) {
    if (isset($_POST['cbKode'])) {
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(190, 10, 'LAPORAN STOK OPNAME', 0, 0, 'C');

    $pdf->Cell(10, 10, '', 0, 1);
    $pdf->SetFont('Times', 'B', 9);
    $pdf->Cell(7, 7, 'No', 1, 0, 'C');
    $pdf->Cell(22, 7, 'Kode Opname', 1, 0, 'C');
    $pdf->Cell(22, 7, 'Kode Label', 1, 0, 'C');
    $pdf->Cell(60, 7, 'Type Barang', 1, 0, 'C');
    $pdf->Cell(20, 7, 'Tgl Opname', 1, 0, 'C');
    $pdf->Cell(30, 7, 'Kondisi', 1, 0, 'C');
    $pdf->Cell(30, 7, 'Status', 1, 0, 'C');


    $pdf->Cell(20, 7, '', 0, 1);
    $pdf->SetFont('Times', '', 8);
    $no = 1;
    foreach ($_POST['cbKode'] as $indeks => $nilai) {
    $mySql  = "SELECT opname.*, barang.nm_barang, barang_inventaris.kd_inventaris 
    FROM opname
    LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
    LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
    LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
    LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori 
    WHERE opname.kd_opname = '$nilai' 
    ORDER BY opname.kd_opname ASC";
    $myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
    while ($d = mysql_fetch_array($myQry)) {
    $Kode = $d['kd_opname'];

    $pdf->Cell(7, 6, $no++, 1, 0, 'C');
    $pdf->Cell(22, 6, $d['kd_opname'], 1, 0, 'C');
    $pdf->Cell(22, 6, $d['kd_inventaris'], 1, 0, 'C');
    $pdf->Cell(60, 6, $d['nm_barang'], 1, 0, 'C');
    $pdf->Cell(20, 6, IndonesiaTgl($d['tahun_opname']), 1, 0, 'C');
    $pdf->Cell(30, 6, $d['keterangan'], 1, 0, 'C');
    $pdf->Cell(30, 6, $d['status'], 1, 1, 'C');
    }
}
$pdf->Output();
} else {

    $filterSQL = "";

    # Set Tanggal skrg
    $status = isset($_GET['statusKembali']) ? $_GET['statusKembali'] : 'Semua';
    $kodeKategori  = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
    $dataKataKunci = isset($_GET['txtKataKunci']) ? $_GET['txtKataKunci'] : '';
    
    // PILIH KATEGORI
    if ($kodeKategori == "Semua") {
      if ($status ==  "Semua") {
        if ($dataKataKunci ==  "") {
          $filterSQL   = "";
          $statusBarang = "";
          $namaKategori = "Semua";
        } else {
          $filterSQL   = " WHERE barang_inventaris.kd_inventaris ='$dataKataKunci' OR barang.nm_barang LIKE '%$dataKataKunci%'";
    
          $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
          LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
          LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
          LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
          LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
          $filterSQL";
          $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
          $kolomData   = mysql_fetch_array($infoQry);
          $statusBarang = "";
          $namaKategori = "Semua";
        }
      } else {
        if ($dataKataKunci ==  "") {
          $filterSQL   = "WHERE opname.status = '$status'";
    
          $infoSql   = "SELECT * FROM opname
          $filterSQL";
          $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
          $kolomData   = mysql_fetch_array($infoQry);
          $statusBarang = $kolomData['status'];
          $namaKategori = "Semua";
        } else {
          $filterSQL   = " WHERE barang_inventaris.kd_inventaris ='$dataKataKunci' OR barang.nm_barang LIKE '%$dataKataKunci%' AND opname.status = '$status'";
    
          $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
          LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
          LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
          LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
          LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
          $filterSQL";
          $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
          $kolomData   = mysql_fetch_array($infoQry);
          $statusBarang = $kolomData['status'];
          $namaKategori = "Semua";
        }
      }
    } else {
      if ($status ==  "Semua") {
        if ($dataKataKunci ==  "") {
          $filterSQL   = " WHERE kategori.kd_kategori ='$kodeKategori'";
    
          $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
          LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
          LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
          LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
          LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
          $filterSQL";
          $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
          $kolomData   = mysql_fetch_array($infoQry);
          $statusBarang = "";
          $namaKategori = $kolomData['nm_kategori'];
        } else {
          $filterSQL   = " WHERE kategori.kd_kategori ='$kodeKategori' AND barang_inventaris.kd_inventaris ='$dataKataKunci' OR barang.nm_barang LIKE '%$dataKataKunci%'";
    
          $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
          LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
          LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
          LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
          LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
          $filterSQL";
          $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
          $kolomData   = mysql_fetch_array($infoQry);
          $statusBarang = "";
          $namaKategori = $kolomData['nm_kategori'];
        }
      } else {
        if ($dataKataKunci ==  "") {
          $filterSQL   = "WHERE kategori.kd_kategori ='$kodeKategori' AND opname.status = '$status'";
    
          $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
          LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
          LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
          LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
          LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
          $filterSQL";
          $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
          $kolomData   = mysql_fetch_array($infoQry);
          $statusBarang = $kolomData['status'];
          $namaKategori = $kolomData['nm_kategori'];
        } else {
          $filterSQL   = " WHERE kategori.kd_kategori ='$kodeKategori' AND barang_inventaris.kd_inventaris ='$dataKataKunci' OR barang.nm_barang LIKE '%$dataKataKunci%' AND opname.status = '$status'";
    
          $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
          LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
          LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
          LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
          LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
          $filterSQL";
          $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
          $kolomData   = mysql_fetch_array($infoQry);
          $statusBarang = $kolomData['status'];
          $namaKategori = $kolomData['nm_kategori'];
        }
      }
    }
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
    
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(190, 10, 'LAPORAN STOK OPNAME', 0, 0, 'C');
    
        $pdf->Cell(10, 10, '', 0, 1);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(7, 7, 'No', 1, 0, 'C');
        $pdf->Cell(22, 7, 'Kode Opname', 1, 0, 'C');
        $pdf->Cell(22, 7, 'Kode Label', 1, 0, 'C');
        $pdf->Cell(60, 7, 'Type Barang', 1, 0, 'C');
        $pdf->Cell(20, 7, 'Tgl Opname', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Kondisi', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Status', 1, 0, 'C');
    
    
        $pdf->Cell(20, 7, '', 0, 1);
        $pdf->SetFont('Times', '', 8);
        $no = 1;
        $mySql  = "SELECT opname.*, barang.nm_barang, barang_inventaris.kd_inventaris 
        FROM opname
        LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
        LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
        LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori 
        $filterSQL 
        ORDER BY opname.kd_opname ASC";
        $myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
        while ($d = mysql_fetch_array($myQry)) {
        $Kode = $d['kd_opname'];
    
        $pdf->Cell(7, 6, $no++, 1, 0, 'C');
        $pdf->Cell(22, 6, $d['kd_opname'], 1, 0, 'C');
        $pdf->Cell(22, 6, $d['kd_inventaris'], 1, 0, 'C');
        $pdf->Cell(60, 6, $d['nm_barang'], 1, 0, 'C');
        $pdf->Cell(20, 6, IndonesiaTgl($d['tahun_opname']), 1, 0, 'C');
        $pdf->Cell(30, 6, $d['keterangan'], 1, 0, 'C');
        $pdf->Cell(30, 6, $d['status'], 1, 1, 'C');
        }
    
        $pdf->Output();
        }
    }

if (isset($_POST['btnExcel'])) {
    if (!empty($_POST['cbKode'])) {
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('A1', 'LAPORAN DATA STOK OPNAME');
        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Kode Opname');
        $sheet->setCellValue('C3', 'Kode Label');
        $sheet->setCellValue('D3', 'Type Barang');
        $sheet->setCellValue('E3', 'Tgl Opname');
        $sheet->setCellValue('F3', 'Kondisi');
        $sheet->setCellValue('G3', 'Status');

        $i = 4;
        $no = 1;

        foreach ($_POST['cbKode'] as $indeks => $nilai) {
            $mySql  = "SELECT opname.*, barang.nm_barang, barang_inventaris.kd_inventaris 
            FROM opname
            LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
            LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
            LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
            LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori 
            WHERE opname.kd_opname = '$nilai' 
            GROUP BY opname.kd_opname ASC";
            $myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
            while ($d = mysql_fetch_array($myQry)) {
            $Kode = $d['kd_opname'];

            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $d['kd_opname']);
            $sheet->setCellValue('C' . $i, $d['kd_inventaris']);
            $sheet->setCellValue('D' . $i, $d['nm_barang']);
            $sheet->setCellValue('E' . $i, IndonesiaTgl($d['tahun_opname']));
            $sheet->setCellValue('F' . $i, $d['keterangan']);
            $sheet->setCellValue('G' . $i, $d['status']);
            $i++;
        }
    }
        $writer = new Xlsx($spreadsheet);
        $writer->save('file/Opname Excel.xlsx');
        echo "<script>window.location = 'file/Opname Excel.xlsx'</script>";
    } else {
        $filterSQL = "";

# Set Tanggal skrg
$status = isset($_GET['statusKembali']) ? $_GET['statusKembali'] : 'Semua';
$kodeKategori  = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
$dataKataKunci = isset($_GET['txtKataKunci']) ? $_GET['txtKataKunci'] : '';

// PILIH KATEGORI
if ($kodeKategori == "Semua") {
  if ($status ==  "Semua") {
    if ($dataKataKunci ==  "") {
      $filterSQL   = "";
      $statusBarang = "";
      $namaKategori = "Semua";
    } else {
      $filterSQL   = " WHERE barang_inventaris.kd_inventaris ='$dataKataKunci' OR barang.nm_barang LIKE '%$dataKataKunci%'";

      $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
      LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
      LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = "";
      $namaKategori = "Semua";
    }
  } else {
    if ($dataKataKunci ==  "") {
      $filterSQL   = "WHERE opname.status = '$status'";

      $infoSql   = "SELECT * FROM opname
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = $kolomData['status'];
      $namaKategori = "Semua";
    } else {
      $filterSQL   = " WHERE barang_inventaris.kd_inventaris ='$dataKataKunci' OR barang.nm_barang LIKE '%$dataKataKunci%' AND opname.status = '$status'";

      $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
      LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
      LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = $kolomData['status'];
      $namaKategori = "Semua";
    }
  }
} else {
  if ($status ==  "Semua") {
    if ($dataKataKunci ==  "") {
      $filterSQL   = " WHERE kategori.kd_kategori ='$kodeKategori'";

      $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
      LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
      LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = "";
      $namaKategori = $kolomData['nm_kategori'];
    } else {
      $filterSQL   = " WHERE kategori.kd_kategori ='$kodeKategori' AND barang_inventaris.kd_inventaris ='$dataKataKunci' OR barang.nm_barang LIKE '%$dataKataKunci%'";

      $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
      LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
      LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = "";
      $namaKategori = $kolomData['nm_kategori'];
    }
  } else {
    if ($dataKataKunci ==  "") {
      $filterSQL   = "WHERE kategori.kd_kategori ='$kodeKategori' AND opname.status = '$status'";

      $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
      LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
      LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = $kolomData['status'];
      $namaKategori = $kolomData['nm_kategori'];
    } else {
      $filterSQL   = " WHERE kategori.kd_kategori ='$kodeKategori' AND barang_inventaris.kd_inventaris ='$dataKataKunci' OR barang.nm_barang LIKE '%$dataKataKunci%' AND opname.status = '$status'";

      $infoSql   = "SELECT opname.*, kategori.nm_kategori, barang.nm_barang FROM opname
      LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
      LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
      $filterSQL";
      $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
      $kolomData   = mysql_fetch_array($infoQry);
      $statusBarang = $kolomData['status'];
      $namaKategori = $kolomData['nm_kategori'];
    }
  }
}
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            $sheet->mergeCells('A1:I1');
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('A1', 'LAPORAN DATA STOK OPNAME');
            $sheet->setCellValue('A3', 'No');
            $sheet->setCellValue('B3', 'Kode Opname');
            $sheet->setCellValue('C3', 'Kode Label');
            $sheet->setCellValue('D3', 'Type Barang');
            $sheet->setCellValue('E3', 'Tgl Opname');
            $sheet->setCellValue('F3', 'Kondisi');
            $sheet->setCellValue('G3', 'Status');
    
           
            $mySql  = "SELECT opname.*, barang.nm_barang, barang_inventaris.kd_inventaris 
            FROM opname
            LEFT JOIN opname_item ON opname.kd_opname = opname_item.kd_opname
            LEFT JOIN barang_inventaris ON opname_item.kd_inventaris = barang_inventaris.kd_inventaris
            LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
            LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori 
            $filterSQL
            ORDER BY opname.kd_opname ASC";
            $myQry  = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
            $i = 4;
            $no = 1;
            while ($d = mysql_fetch_array($myQry)) {
            $Kode = $d['kd_opname'];

            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $d['kd_opname']);
            $sheet->setCellValue('C' . $i, $d['kd_inventaris']);
            $sheet->setCellValue('D' . $i, $d['nm_barang']);
            $sheet->setCellValue('E' . $i, IndonesiaTgl($d['tahun_opname']));
            $sheet->setCellValue('F' . $i, $d['keterangan']);
            $sheet->setCellValue('G' . $i, $d['status']);
            $i++;
            }
            $writer = new Xlsx($spreadsheet);
            $writer->save('file/Opname Excel.xlsx');
            echo "<script>window.location = 'file/Opname Excel.xlsx'</script>";
        }
    }
?>