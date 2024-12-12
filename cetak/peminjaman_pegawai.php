<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Baca variabel filter dari URL
if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
  $kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : $_SESSION['SES_UNIT'];
} else {
  $kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua';
}
$status = isset($_GET['statusKembali']) ? $_GET['statusKembali'] : 'Semua';
$dataBarang = isset($_GET['kodeBarang']) ? $_GET['kodeBarang'] : 'Semua';
$dataKataKunci = isset($_GET['txtKataKunci']) ? $_GET['txtKataKunci'] : '';

if ($kodeDepartemen == "Semua") {
  if ($dataBarang == "Semua") {
    if ($status ==  "Semua") {
      if ($dataKataKunci ==  "") {
        $filterSQL   = "";
        $infoPegawai = "";
      } else {
        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%'";

        $infoSql   = "SELECT peminjaman.*, pegawai.*, departemen.nm_departemen FROM peminjaman
        LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen $filterSQL";
        $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData   = mysql_fetch_array($infoQry);
        $infoPegawai    = $kolomData['nm_pegawai'];
        $namaDepartemen = $kolomData['nm_departemen'];
        $hp             = $kolomData['no_telepon'];
        $alamat         = $kolomData['alamat'];
      }
    } else {
      if ($dataKataKunci ==  "") {
        $filterSQL   = "WHERE peminjaman.status_kembali = '$status'";
      } else {
        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND peminjaman.status_kembali = '$status'";

        $infoSql   = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen FROM peminjaman
        LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen $filterSQL";
        $infoQry        = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData      = mysql_fetch_array($infoQry);
        $infoPegawai    = $kolomData['nm_pegawai'];
        $namaDepartemen = $kolomData['nm_departemen'];
        $hp             = $kolomData['no_telepon'];
        $alamat         = $kolomData['alamat'];
      }
    }
  } else {
    if ($status ==  "Semua") {
      if ($dataKataKunci ==  "") {
        $filterSQL   = "WHERE barang_inventaris.kd_barang = '$dataBarang'";

        $infoSql   = "SELECT peminjaman.*, barang.nm_barang FROM peminjaman
      LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
      LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      $filterSQL";
        $infoQry        = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData      = mysql_fetch_array($infoQry);
        $infoBarang     = $kolomData['nm_barang'];
      } else {
        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND barang_inventaris.kd_barang = '$dataBarang'";

        $infoSql   = "SELECT peminjaman.*, pegawai.*, departemen.nm_departemen, barang.nm_barang FROM peminjaman
      LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
      LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
      LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
      $filterSQL";
        $infoQry        = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData      = mysql_fetch_array($infoQry);
        $infoBarang     = $kolomData['nm_barang'];
        $infoPegawai    = $kolomData['nm_pegawai'];
        $namaDepartemen = $kolomData['nm_departemen'];
        $hp             = $kolomData['no_telepon'];
        $alamat         = $kolomData['alamat'];
      }
    } else {
      if ($dataKataKunci ==  "") {
        $filterSQL   = "WHERE peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";

        $infoSql   = "SELECT peminjaman.*, barang.nm_barang FROM peminjaman
      LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
      LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang $filterSQL";
        $infoQry        = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData      = mysql_fetch_array($infoQry);
        $infoBarang     = $kolomData['nm_barang'];
        $infoStatus     = $kolomData['status_kembali'];
      } else {
        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";

        $infoSql   = "SELECT peminjaman.*, pegawai.nm_pegawai, departemen.nm_departemen, barang.nm_barang FROM peminjaman
      LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
      LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
      LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
      LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
      LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen $filterSQL";
        $infoQry   = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData   = mysql_fetch_array($infoQry);
        $infoBarang     = $kolomData['nm_barang'];
        $infoPegawai    = $kolomData['nm_pegawai'];
        $namaDepartemen = $kolomData['nm_departemen'];
        $hp             = $kolomData['no_telepon'];
        $alamat         = $kolomData['alamat'];
      }
    }
  }
} else {
  if ($dataBarang == "Semua") {
    if ($status ==  "Semua") {
      if ($dataKataKunci ==  "") {
        $filterSQL   = "WHERE departemen.kd_departemen = '$kodeDepartemen'";

        $infoSql   = "SELECT peminjaman.*, pegawai.*, departemen.nm_departemen, barang.nm_barang FROM peminjaman
        LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
        LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
        LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
        $filterSQL";
        $infoQry        = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData      = mysql_fetch_array($infoQry);
        $infoBarang     = $kolomData['nm_barang'];
        $infoPegawai    = $kolomData['nm_pegawai'];
        $namaDepartemen = $kolomData['nm_departemen'];
        $hp             = $kolomData['no_telepon'];
        $alamat         = $kolomData['alamat'];
      } else {
        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.kd_departemen = '$kodeDepartemen'";

        $infoSql   = "SELECT peminjaman.*, pegawai.*, departemen.nm_departemen, barang.nm_barang FROM peminjaman
        LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
        LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
        LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
        $filterSQL";
        $infoQry        = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData      = mysql_fetch_array($infoQry);
        $infoBarang     = $kolomData['nm_barang'];
        $infoPegawai    = $kolomData['nm_pegawai'];
        $namaDepartemen = $kolomData['nm_departemen'];
        $hp             = $kolomData['no_telepon'];
        $alamat         = $kolomData['alamat'];
      }
    } else {
      if ($dataKataKunci ==  "") {
        $filterSQL   = "WHERE departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status'";

        $infoSql   = "SELECT peminjaman.*, pegawai.*, departemen.nm_departemen, barang.nm_barang FROM peminjaman
        LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
        LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
        LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
        $filterSQL";
        $infoQry        = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData      = mysql_fetch_array($infoQry);
        $infoBarang     = $kolomData['nm_barang'];
        $infoPegawai    = $kolomData['nm_pegawai'];
        $namaDepartemen = $kolomData['nm_departemen'];
        $hp             = $kolomData['no_telepon'];
        $alamat         = $kolomData['alamat'];
      } else {
        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status'";

        $infoSql   = "SELECT peminjaman.*, pegawai.*, departemen.nm_departemen, barang.nm_barang FROM peminjaman
        LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
        LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
        LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
        $filterSQL";
        $infoQry        = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData      = mysql_fetch_array($infoQry);
        $infoBarang     = $kolomData['nm_barang'];
        $infoPegawai    = $kolomData['nm_pegawai'];
        $namaDepartemen = $kolomData['nm_departemen'];
        $hp             = $kolomData['no_telepon'];
        $alamat         = $kolomData['alamat'];
      }
    }
  } else {
    if ($status ==  "Semua") {
      if ($dataKataKunci ==  "") {
        $filterSQL   = "WHERE departemen.kd_departemen = '$kodeDepartemen' AND barang_inventaris.kd_barang = '$dataBarang'";

        $infoSql   = "SELECT peminjaman.*, pegawai.*, departemen.nm_departemen, barang.nm_barang FROM peminjaman
        LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
        LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
        LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
        $filterSQL";
        $infoQry        = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData      = mysql_fetch_array($infoQry);
        $infoBarang     = $kolomData['nm_barang'];
        $infoPegawai    = $kolomData['nm_pegawai'];
        $namaDepartemen = $kolomData['nm_departemen'];
        $hp             = $kolomData['no_telepon'];
        $alamat         = $kolomData['alamat'];
      } else {
        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";

        $infoSql   = "SELECT peminjaman.*, pegawai.*, departemen.nm_departemen, barang.nm_barang FROM peminjaman
        LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
        LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
        LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
        $filterSQL";
        $infoQry        = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData      = mysql_fetch_array($infoQry);
        $infoBarang     = $kolomData['nm_barang'];
        $infoPegawai    = $kolomData['nm_pegawai'];
        $namaDepartemen = $kolomData['nm_departemen'];
        $hp             = $kolomData['no_telepon'];
        $alamat         = $kolomData['alamat'];
      }
    } else {
      if ($dataKataKunci ==  "") {
        $filterSQL   = " WHERE departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";

        $infoSql   = "SELECT peminjaman.*, pegawai.*, departemen.nm_departemen, barang.nm_barang FROM peminjaman
        LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
        LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
        LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
        $filterSQL";
        $infoQry        = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData      = mysql_fetch_array($infoQry);
        $infoBarang     = $kolomData['nm_barang'];
        $infoPegawai    = $kolomData['nm_pegawai'];
        $namaDepartemen = $kolomData['nm_departemen'];
        $hp             = $kolomData['no_telepon'];
        $alamat         = $kolomData['alamat'];
      } else {
        $filterSQL   = " WHERE peminjaman.kd_pegawai ='$dataKataKunci' OR pegawai.nm_pegawai LIKE '%$dataKataKunci%' AND departemen.kd_departemen = '$kodeDepartemen' AND peminjaman.status_kembali = '$status' AND barang_inventaris.kd_barang = '$dataBarang'";

        $infoSql   = "SELECT peminjaman.*, pegawai.*, departemen.nm_departemen, barang.nm_barang FROM peminjaman
        LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman = peminjaman_item.no_peminjaman
        LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris = barang_inventaris.kd_inventaris
        LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
        LEFT JOIN pegawai ON peminjaman.kd_pegawai = pegawai.kd_pegawai
        LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen
        $filterSQL";
        $infoQry        = mysql_query($infoSql, $koneksidb)  or die("Query salah : " . mysql_error());
        $kolomData      = mysql_fetch_array($infoQry);
        $infoBarang     = $kolomData['nm_barang'];
        $infoPegawai    = $kolomData['nm_pegawai'];
        $namaDepartemen = $kolomData['nm_departemen'];
        $hp             = $kolomData['no_telepon'];
        $alamat         = $kolomData['alamat'];
      }
    }
  }
}
?>
<html>

<head>
  <title>:: Laporan Peminjaman per Pegawai - Inventory Kantor (Aset Kantor)</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="window.print()">
  <h2>DATA LAPORAN PEMINJAMAN BARANG</h2>
  <table width="500" border="0" class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
    </tr>
    <?php if ($dataKataKunci != "") : ?>
      <tr>
        <td width="90"><strong>Nama Pegawai</strong></td>
        <td width="5"><strong>:</strong></td>
        <td width="333"><?php echo  $infoPegawai; ?></td>
      </tr>
      <tr>
        <td width="90"><strong>Unit</strong></td>
        <td width="5"><strong>:</strong></td>
        <td width="333"><?php echo  $namaDepartemen; ?></td>
      </tr>
      <tr>
        <td width="90"><strong>No. Hp</strong></td>
        <td width="5"><strong>:</strong></td>
        <td width="333"><?php echo  $hp; ?></td>
      </tr>
      <tr>
        <td width="90"><strong>Alamat</strong></td>
        <td width="5"><strong>:</strong></td>
        <td width="333"><?php echo  $alamat; ?></td>
      </tr>
    <?php endif; ?>
    <?php if ($dataBarang != "Semua") : ?>
      <tr>
        <td width="90"><strong>Nama Barang</strong></td>
        <td width="5"><strong>:</strong></td>
        <td width="333"><?php echo  $infoBarang; ?></td>
      </tr>
    <?php endif; ?>
    <?php if ($kodeDepartemen != "Semua") : ?>
      <tr>
        <td width="90"><strong>Nama Departemen</strong></td>
        <td width="5"><strong>:</strong></td>
        <td width="333"><?php echo  $namaDepartemen; ?></td>
      </tr>
    <?php endif; ?>
  </table>
  <br />
  <table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="25" align="center" bgcolor="#CCCCCC"><strong>Tanggal Peminjaman</strong></td>
      <td width="25" align="center" bgcolor="#CCCCCC"><strong>Tanggal Pengembalian</strong></td>
      <td width="50" align="center" bgcolor="#CCCCCC"><strong>No. Peminjaman</strong></td>
      <td width="80" bgcolor="#CCCCCC"><strong>Kode Label</strong></td>
      <td width="229" bgcolor="#CCCCCC"><strong>Nama Pegawai</strong></td>
      <td width="150" bgcolor="#CCCCCC"><strong>Departemen</strong></td>
      <td width="229" bgcolor="#CCCCCC"><strong>Type barang</strong></td>
      <td width="100" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
      <td width="80" align="center" bgcolor="#CCCCCC"><strong>Status</strong></td>
    </tr>
    <?php
    // Skrip untuk menampilkan data Transaksi Peminjaman, dilengkapi informasi Nama Pegawai
    // Filter data berdasarkan Nama Pegawai dan Tahun Transaksi
    $mySql = "SELECT peminjaman.*, departemen.nm_departemen, pegawai.nm_pegawai, barang.nm_barang, peminjaman_item.kd_inventaris, barang.nm_barang FROM peminjaman 
				LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
		    LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
		    LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
		    LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
		    LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
				$filterSQL
				ORDER BY peminjaman.no_peminjaman ASC";
    $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
    $nomor  = 0;
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;

      // Membaca Kode peminjaman/ Nomor transaksi
      $noNota = $myData['no_peminjaman'];

      // Menghitung Total barang yang dipinjam
      $my2Sql = "SELECT COUNT(*) AS total_barang FROM peminjaman_item WHERE no_peminjaman='$noNota'";
      $my2Qry = mysql_query($my2Sql, $koneksidb)  or die("Query 2 salah : " . mysql_error());
      $my2Data = mysql_fetch_array($my2Qry);
    ?>
      <tr>
        <td align="center"><?php echo $nomor; ?></td>
        <td align="center"><?php echo IndonesiaTgl($myData['tgl_peminjaman']); ?></td>
        <?php if ($myData['status_kembali'] == 'Kembali') : ?>
          <td align="center"><?php echo IndonesiaTgl($myData['tgl_kembali']); ?></td>
        <?php else : ?>
          <td align="center"> - </td>
        <?php endif; ?>
        <td align="center"><?php echo $myData['no_peminjaman']; ?></td>
        <td><?php echo $myData['kd_inventaris']; ?></td>
        <td><?php echo $myData['nm_pegawai']; ?></td>
        <td><?php echo $myData['nm_departemen']; ?></td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['keterangan']; ?></td>
        <td align="center"><?php echo $myData['status_kembali']; ?></td>
      </tr>
    <?php } ?>
  </table>
</body>

</html>

<?php
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

if ($dataBarang != "Semua") {
  $sheet->mergeCells('A4:J4');
  $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
  $sheet->setCellValue('A4', 'LAPORAN DATA PEMINJAMAN PER BARANG');
  $sheet->mergeCells('A6:B6');
  $sheet->setCellValue('A6', 'Nama Barang');
  $sheet->mergeCells('C6:J6');
  $sheet->setCellValue('C6', ': ' . $infoBarang);
  $sheet->mergeCells('A7:J7');
  $sheet->getStyle('A8:J8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle('A8:J8')->getFont()->setBold('A8:I8');
} else {
  $sheet->mergeCells('A1:I1');
  $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
  $sheet->setCellValue('A1', 'LAPORAN DATA PEMINJAMAN PER PEGAWAI');
}
if ($dataKataKunci != "") {
  $sheet->mergeCells('A2:I2');
  $sheet->setCellValue('A2', 'KETERANGAN');
  $sheet->mergeCells('A3:B3');
  $sheet->setCellValue('A3', 'Nama Pegawai');
  $sheet->mergeCells('C3:I3');
  $sheet->setCellValue('C3', ': ' . $infoPegawai);
  $sheet->mergeCells('A4:B4');
  $sheet->setCellValue('A4', 'Unit');
  $sheet->mergeCells('C4:I4');
  $sheet->setCellValue('C4', ': ' . $namaDepartemen);
  $sheet->mergeCells('A5:B5');
  $sheet->setCellValue('A5', 'No. Hp');
  $sheet->mergeCells('C5:I5');
  $sheet->setCellValue('C5', ': ' . $hp);
  $sheet->mergeCells('A6:B6');
  $sheet->setCellValue('A6', 'Alamat');
  $sheet->mergeCells('C6:I6');
  $sheet->setCellValue('C6', ': ' . $alamat);
  $sheet->mergeCells('A7:I7');
  $sheet->getStyle('A8:I8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle('A8:I8')->getFont()->setBold('A8:I8');
}
$sheet->setCellValue('A8', 'No');
$sheet->setCellValue('B8', 'Tanggal Peminjaman');
$sheet->setCellValue('C8', 'Tanggal Pengembalian');
$sheet->setCellValue('D8', 'No. Peminjaman');
$sheet->setCellValue('E8', 'Kode Label');
$sheet->setCellValue('F8', 'Nama Pegawai');
$sheet->setCellValue('G8', 'Departemen');
$sheet->setCellValue('H8', 'Type barang');
$sheet->setCellValue('I8', 'Keterangan');
$sheet->setCellValue('J8', 'Status');

// Skrip untuk menampilkan data Transaksi Peminjaman, dilengkapi informasi Nama Pegawai
// Filter data berdasarkan Nama Pegawai dan Tahun Transaksi
$mySql = "SELECT peminjaman.*, departemen.nm_departemen, pegawai.nm_pegawai, barang.nm_barang, peminjaman_item.kd_inventaris FROM peminjaman 
				LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
		    LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
		    LEFT JOIN peminjaman_item ON peminjaman.no_peminjaman=peminjaman_item.no_peminjaman
		    LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris
		    LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
				$filterSQL
				ORDER BY peminjaman.no_peminjaman ASC";
$myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
$i = 9;
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
  $sheet->setCellValue('E' . $i, $d['kd_inventaris']);
  $sheet->setCellValue('F' . $i, $d['nm_pegawai']);
  $sheet->setCellValue('G' . $i, $d['nm_departemen']);
  $sheet->setCellValue('H' . $i, $d['nm_barang']);
  $sheet->setCellValue('I' . $i, $d['keterangan']);
  $sheet->setCellValue('J' . $i, $d['status_kembali']);

  $i++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('file/Data barang per Pegawai.xlsx');
echo "<script>window.location = 'file/Data barang per Pegawai.xlsx'</script>";
?>