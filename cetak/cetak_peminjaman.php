<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/fpdf/fpdf.php";
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

if (isset($_POST['btnPdf'])) {
    if (!empty($_POST['cbKode'])) {
        // intance object dan memberikan pengaturan halaman PDF
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(270, 10, 'LAPORAN DATA PEMINJAMAN BARANG', 0, 0, 'C');

        $pdf->Cell(10, 10, '', 0, 1);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(7, 7, 'No', 1, 0, 'C');
        $pdf->Cell(32, 7, 'Tanggal Peminjaman', 1, 0, 'C');
        $pdf->Cell(32, 7, 'Tanggal Pengembalian', 1, 0, 'C');
        $pdf->Cell(25, 7, 'No. Peminjaman', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Kategori', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Type Barang', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nama Pegawai', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Departemen', 1, 0, 'C');
        $pdf->Cell(15, 7, 'Status', 1, 0, 'C');
        $pdf->Cell(20, 7, 'Qty Barang', 1, 0, 'C');

        $pdf->Cell(20, 7, '', 0, 1);
        $pdf->SetFont('Times', '', 8);
        $no = 1;
        foreach ($_POST['cbKode'] as $indeks => $nilai) {
            $mySql = "SELECT peminjaman.*, departemen.nm_departemen, pegawai.nm_pegawai, barang.nm_barang, peminjaman_item.kd_inventaris, kategori.nm_kategori FROM peminjaman 
            LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
            LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
            LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
            LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
            LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
            LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
            WHERE peminjaman.no_peminjaman = '$nilai'
            GROUP BY peminjaman.no_peminjaman ASC";
            $myQry  = mysqli_query($koneksidb, $mySql)  or die("Query  salah : " . mysql_error());
            while ($d = mysqli_fetch_array($myQry)) {

                // Membaca Kode peminjaman/ Nomor transaksi
                $noNota = $d['no_peminjaman'];

                // Menghitung Total barang yang dipinjam
                $my2Sql = "SELECT COUNT(*) AS total_barang FROM peminjaman_item WHERE no_peminjaman='$noNota'";
                $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
                $my2Data = mysql_fetch_array($my2Qry);

                $pdf->Cell(7, 6, $no++, 1, 0, 'C');
                $pdf->Cell(32, 6, IndonesiaTgl($d['tgl_peminjaman']), 1, 0, 'C');
                if ($d['status_kembali'] == 'Kembali') {
                    $pdf->Cell(32, 6, IndonesiaTgl($d['tgl_kembali']), 1, 0, 'C');
                } else {
                    $pdf->Cell(32, 6, '-', 1, 0, 'C');
                }
                $pdf->Cell(25, 6, $d['no_peminjaman'], 1, 0, 'C');
                $pdf->Cell(30, 6, $d['nm_kategori'], 1, 0, 'C');
                $pdf->Cell(50, 6, $d['nm_barang'], 1, 0, 'C');
                $pdf->Cell(30, 6, $d['nm_pegawai'], 1, 0, 'C');
                $pdf->Cell(25, 6, $d['nm_departemen'], 1, 0, 'C');
                $pdf->Cell(15, 6, $d['status_kembali'], 1, 0, 'C');
                $pdf->Cell(20, 6, $my2Data['total_barang'], 1, 1, 'C');
            }
        }
        $pdf->Output();
    } else {
        // Baca variabel filter dari URL
        $kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua';
        $status = isset($_GET['statusKembali']) ? $_GET['statusKembali'] : 'Semua';
        $dataBarang = isset($_GET['kodeBarang']) ? $_GET['kodeBarang'] : 'Semua';
        $dataKataKunci = isset($_GET['txtKataKunci']) ? $_GET['txtKataKunci'] : '';

        if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
            if ($dataBarang == "Semua") {
                if ($status ==  "Semua") {
                    if ($dataKataKunci ==  "") {
                        $filterSQL   = "WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]'";
                    } else {
                        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'";
                    }
                } else {
                    if ($dataKataKunci ==  "") {
                        $filterSQL   = "WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]' AND peminjaman.status_kembali = '$status'";
                    } else {
                        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.nm_departemen = '$_SESSION[SES_UNIT]' AND peminjaman.status_kembali = '$status'";
                    }
                }
            } else {
                if ($status ==  "Semua") {
                    if ($dataKataKunci ==  "") {
                        $filterSQL   = "WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]' AND barang_inventaris.kd_barang = '$dataBarang'";
                    } else {
                        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.nm_departemen = '$_SESSION[SES_UNIT]' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                    }
                } else {
                    if ($dataKataKunci ==  "") {
                        $filterSQL   = " WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                    } else {
                        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.nm_departemen = '$_SESSION[SES_UNIT]' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                    }
                }
            }
        } else {
            if ($kodeDepartemen == "Semua") {
                if ($dataBarang == "Semua") {
                    if ($status ==  "Semua") {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%'";
                        }
                    } else {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "WHERE peminjaman.status_kembali = '$status'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND peminjaman.status_kembali = '$status'";
                        }
                    }
                } else {
                    if ($status ==  "Semua") {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "WHERE barang_inventaris.kd_barang = '$dataBarang'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND barang_inventaris.kd_barang = '$dataBarang'";
                        }
                    } else {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "WHERE peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                        }
                    }
                }
            } else {
                if ($dataBarang == "Semua") {
                    if ($status ==  "Semua") {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "WHERE departemen.kd_departemen = '$kodeDepartemen'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.kd_departemen = '$kodeDepartemen'";
                        }
                    } else {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "WHERE departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status'";
                        }
                    }
                } else {
                    if ($status ==  "Semua") {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "WHERE departemen.kd_departemen = '$kodeDepartemen' AND barang_inventaris.kd_barang = '$dataBarang'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                        }
                    } else {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = " WHERE departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                        }
                    }
                }
            }
        }

        // intance object dan memberikan pengaturan halaman PDF
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(270, 10, 'LAPORAN DATA PEMINJAMAN BARANG', 0, 0, 'C');

        $pdf->Cell(10, 10, '', 0, 1);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(7, 7, 'No', 1, 0, 'C');
        $pdf->Cell(32, 7, 'Tanggal Peminjaman', 1, 0, 'C');
        $pdf->Cell(32, 7, 'Tanggal Pengembalian', 1, 0, 'C');
        $pdf->Cell(25, 7, 'No. Peminjaman', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Kategori', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Type Barang', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nama Pegawai', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Departemen', 1, 0, 'C');
        $pdf->Cell(15, 7, 'Status', 1, 0, 'C');
        $pdf->Cell(20, 7, 'Qty Barang', 1, 0, 'C');

        $pdf->Cell(20, 7, '', 0, 1);
        $pdf->SetFont('Times', '', 8);
        $no = 1;
        $mySql = "SELECT peminjaman.*, departemen.nm_departemen, pegawai.nm_pegawai, barang.nm_barang, peminjaman_item.kd_inventaris, kategori.nm_kategori, barang_inventaris.kd_barang FROM peminjaman 
        LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
        LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
        LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
        LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
        $filterSQL
        GROUP BY peminjaman.no_peminjaman ASC";
        $myQry  = mysqli_query($koneksidb, $mySql)  or die("Query  salah : " . mysql_error());
        while ($d = mysqli_fetch_array($myQry)) {

            // Membaca Kode peminjaman/ Nomor transaksi
            $noNota = $d['no_peminjaman'];

            // Menghitung Total barang yang dipinjam
            $my2Sql = "SELECT COUNT(*) AS total_barang FROM peminjaman_item WHERE no_peminjaman='$noNota'";
            $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
            $my2Data = mysql_fetch_array($my2Qry);

            $pdf->Cell(7, 6, $no++, 1, 0, 'C');
            $pdf->Cell(32, 6, IndonesiaTgl($d['tgl_peminjaman']), 1, 0, 'C');
            if ($d['status_kembali'] == 'Kembali') {
                $pdf->Cell(32, 6, IndonesiaTgl($d['tgl_kembali']), 1, 0, 'C');
            } else {
                $pdf->Cell(32, 6, '-', 1, 0, 'C');
            }
            $pdf->Cell(25, 6, $d['no_peminjaman'], 1, 0, 'C');
            $pdf->Cell(30, 6, $d['nm_kategori'], 1, 0, 'C');
            $pdf->Cell(50, 6, $d['nm_barang'], 1, 0, 'C');
            $pdf->Cell(30, 6, $d['nm_pegawai'], 1, 0, 'C');
            $pdf->Cell(25, 6, $d['nm_departemen'], 1, 0, 'C');
            $pdf->Cell(15, 6, $d['status_kembali'], 1, 0, 'C');
            $pdf->Cell(20, 6, $my2Data['total_barang'], 1, 1, 'C');
        }
        $pdf->Output();
    }
}

if (isset($_POST['btnExcel'])) {
    if (!empty($_POST['cbKode'])) {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('A1', 'LAPORAN DATA PEMINJAMAN BARANG');
        $sheet->getStyle('A3:J3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:J3')->getFont()->setBold('A3:I3');
        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Tanggal Peminjaman');
        $sheet->setCellValue('C3', 'Tanggal Pengembalian');
        $sheet->setCellValue('D3', 'No. Peminjaman');
        $sheet->setCellValue('E3', 'Kategori');
        $sheet->setCellValue('F3', 'Type barang');
        $sheet->setCellValue('G3', 'Nama Pegawai');
        $sheet->setCellValue('H3', 'Departemen');
        $sheet->setCellValue('I3', 'Status');
        $sheet->setCellValue('J3', 'Qty Barang');

        // Skrip untuk menampilkan data Transaksi Peminjaman, dilengkapi informasi Nama Pegawai
        // Filter data berdasarkan Nama Pegawai dan Tahun Transaksi
        $i = 4;
        $no = 1;
        foreach ($_POST['cbKode'] as $indeks => $nilai) {
            $mySql = "SELECT peminjaman.*, departemen.nm_departemen, pegawai.nm_pegawai, barang.nm_barang, peminjaman_item.kd_inventaris, kategori.nm_kategori FROM peminjaman 
				LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
                LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
                LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
                LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
                LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
				WHERE peminjaman.no_peminjaman = '$nilai'
				GROUP BY peminjaman.no_peminjaman ASC";
            $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
            while ($d = mysql_fetch_array($myQry)) {

                // Membaca Kode peminjaman/ Nomor transaksi
                $noNota = $d['no_peminjaman'];

                // Menghitung Total barang yang dipinjam
                $my2Sql = "SELECT COUNT(*) AS total_barang FROM peminjaman_item WHERE no_peminjaman='$noNota'";
                $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
                $my2Data = mysql_fetch_array($my2Qry);

                $sheet->getStyle('A' . $i . ':' . 'D' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->setCellValue('A' . $i, $no++);
                $sheet->setCellValue('B' . $i, IndonesiaTgl($d['tgl_peminjaman']));
                if ($d['status_kembali'] == 'Kembali') {
                    $sheet->setCellValue('C' . $i, IndonesiaTgl($d['tgl_kembali']));
                } else {
                    $sheet->setCellValue('C' . $i, ' - ');
                }
                $sheet->setCellValue('D' . $i, $d['no_peminjaman']);
                $sheet->setCellValue('E' . $i, $d['nm_kategori']);
                $sheet->setCellValue('F' . $i, $d['nm_barang']);
                $sheet->setCellValue('G' . $i, $d['nm_pegawai']);
                $sheet->setCellValue('H' . $i, $d['nm_departemen']);
                $sheet->setCellValue('I' . $i, $d['status_kembali']);
                $sheet->setCellValue('J' . $i, $my2Data['total_barang']);
                $i++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('file/Peminjaman Excel.xlsx');
        echo "<script>window.location = 'file/Peminjaman Excel.xlsx'</script>";
    } else {
        // Baca variabel filter dari URL
        $kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua';
        $status = isset($_GET['statusKembali']) ? $_GET['statusKembali'] : 'Semua';
        $dataBarang = isset($_GET['kodeBarang']) ? $_GET['kodeBarang'] : 'Semua';
        $dataKataKunci = isset($_GET['txtKataKunci']) ? $_GET['txtKataKunci'] : '';

        if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
            if ($dataBarang == "Semua") {
                if ($status ==  "Semua") {
                    if ($dataKataKunci ==  "") {
                        $filterSQL   = "WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]'";
                    } else {
                        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'";
                    }
                } else {
                    if ($dataKataKunci ==  "") {
                        $filterSQL   = "WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]' AND peminjaman.status_kembali = '$status'";
                    } else {
                        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.nm_departemen = '$_SESSION[SES_UNIT]' AND peminjaman.status_kembali = '$status'";
                    }
                }
            } else {
                if ($status ==  "Semua") {
                    if ($dataKataKunci ==  "") {
                        $filterSQL   = "WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]' AND barang_inventaris.kd_barang = '$dataBarang'";
                    } else {
                        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.nm_departemen = '$_SESSION[SES_UNIT]' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                    }
                } else {
                    if ($dataKataKunci ==  "") {
                        $filterSQL   = " WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                    } else {
                        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.nm_departemen = '$_SESSION[SES_UNIT]' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                    }
                }
            }
        } else {
            if ($kodeDepartemen == "Semua") {
                if ($dataBarang == "Semua") {
                    if ($status ==  "Semua") {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%'";
                        }
                    } else {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "WHERE peminjaman.status_kembali = '$status'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND peminjaman.status_kembali = '$status'";
                        }
                    }
                } else {
                    if ($status ==  "Semua") {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "WHERE barang_inventaris.kd_barang = '$dataBarang'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND barang_inventaris.kd_barang = '$dataBarang'";
                        }
                    } else {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "WHERE peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                        }
                    }
                }
            } else {
                if ($dataBarang == "Semua") {
                    if ($status ==  "Semua") {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "WHERE departemen.kd_departemen = '$kodeDepartemen'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.kd_departemen = '$kodeDepartemen'";
                        }
                    } else {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "WHERE departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status'";
                        }
                    }
                } else {
                    if ($status ==  "Semua") {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = "WHERE departemen.kd_departemen = '$kodeDepartemen' AND barang_inventaris.kd_barang = '$dataBarang'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                        }
                    } else {
                        if ($dataKataKunci ==  "") {
                            $filterSQL   = " WHERE departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                        } else {
                            $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";
                        }
                    }
                }
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('A1', 'LAPORAN DATA PEMINJAMAN BARANG');
        $sheet->getStyle('A3:J3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:J3')->getFont()->setBold('A3:I3');
        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Tanggal Peminjaman');
        $sheet->setCellValue('C3', 'Tanggal Pengembalian');
        $sheet->setCellValue('D3', 'No. Peminjaman');
        $sheet->setCellValue('E3', 'Kategori');
        $sheet->setCellValue('F3', 'Type barang');
        $sheet->setCellValue('G3', 'Nama Pegawai');
        $sheet->setCellValue('H3', 'Departemen');
        $sheet->setCellValue('I3', 'Status');
        $sheet->setCellValue('J3', 'Qty Barang');

        // Skrip untuk menampilkan data Transaksi Peminjaman, dilengkapi informasi Nama Pegawai
        // Filter data berdasarkan Nama Pegawai dan Tahun Transaksi
        $mySql = "SELECT peminjaman.*, departemen.nm_departemen, pegawai.nm_pegawai, barang.nm_barang, peminjaman_item.kd_inventaris, kategori.nm_kategori FROM peminjaman 
				LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
                LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
                LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
                LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
                LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
				$filterSQL
				GROUP BY peminjaman.no_peminjaman ASC";
        $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
        $i = 4;
        $no = 1;
        while ($d = mysql_fetch_array($myQry)) {

            // Membaca Kode peminjaman/ Nomor transaksi
            $noNota = $d['no_peminjaman'];

            // Menghitung Total barang yang dipinjam
            $my2Sql = "SELECT COUNT(*) AS total_barang FROM peminjaman_item WHERE no_peminjaman='$noNota'";
            $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
            $my2Data = mysql_fetch_array($my2Qry);

            $sheet->getStyle('A' . $i . ':' . 'D' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, IndonesiaTgl($d['tgl_peminjaman']));
            if ($d['status_kembali'] == 'Kembali') {
                $sheet->setCellValue('C' . $i, IndonesiaTgl($d['tgl_kembali']));
            } else {
                $sheet->setCellValue('C' . $i, ' - ');
            }
            $sheet->setCellValue('D' . $i, $d['no_peminjaman']);
            $sheet->setCellValue('E' . $i, $d['nm_kategori']);
            $sheet->setCellValue('F' . $i, $d['nm_barang']);
            $sheet->setCellValue('G' . $i, $d['nm_pegawai']);
            $sheet->setCellValue('H' . $i, $d['nm_departemen']);
            $sheet->setCellValue('I' . $i, $d['status_kembali']);
            $sheet->setCellValue('J' . $i, $my2Data['total_barang']);

            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('file/Peminjaman Excel.xlsx');
        echo "<script>window.location = 'file/Peminjaman Excel.xlsx'</script>";
    }
}
