<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if ($_GET) {
    # Baca variabel URL
    $Kode = $_GET['Kode'];

    # Perintah untuk mendapatkan data dari tabel pengadaan
    $mySql = "SELECT barang_mati.*, petugas.nm_petugas, barang_mati.pelanggan, approval_barang_mati.tgl_approval
			FROM barang_mati 
            LEFT JOIN petugas ON barang_mati.kd_petugas=petugas.kd_petugas
			LEFT JOIN barang_inventaris on barang_mati.kd_inventaris=barang_inventaris.kd_inventaris
			LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
            LEFT JOIN approval_barang_mati ON barang_mati.no_barang_mati=approval_barang_mati.no_barang_mati
			LEFT JOIN lokasi on barang_mati.pelanggan=lokasi.kd_lokasi
	        WHERE barang_mati.no_barang_mati='$Kode'";
    $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
    $myData = mysql_fetch_array($myQry);
} else {
    echo "Nomor Transaksi Tidak Terbaca";
    exit;
}
?>
<html>

<head>
    <title>:: Cetak Barang Mati - Inventory Kantor (Aset Kantor)</title>
    <link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-height: 80px;
            margin-bottom: 10px;
        }

        .table-print,
        .table-list {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table-print td {
            padding: 8px;
        }

        .table-list th,
        .table-list td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table-list th {
            background-color: #f5f5f5;
            text-align: left;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>

<body onLoad="javascript:window.print()">
    <div class="header">
        <img src="images/logo-nht.png" alt="Logo Perusahaan">
        <h2>BARANG MATI</h2>
    </div>
    <table class="table-print">
        <tr>
            <td width="160"><b>No. Barang Mati</b></td>
            <td width="10">:</td>
            <td><?php echo $myData['no_barang_mati']; ?></td>
        </tr>
        <tr>
            <td><b>Tanggal</b></td>
            <td>:</td>
            <td><?php echo IndonesiaTgl($myData['tanggal']); ?></td>
        </tr>
        <tr>
            <td><b>Pelanggan</b></td>
            <td>:</td>
            <td><?php echo $myData['pelanggan']; ?></td>
        </tr>
        <tr>
            <td><b>Petugas Input</b></td>
            <td>:</td>
            <td><?php echo $myData['nm_petugas']; ?></td>
        </tr>
        <tr>
            <td><b>Tanggal Approve</b></td>
            <td><b>:</b></td>
            <td valign="top"><?php echo IndonesiaTgl($myData['tgl_approval']); ?></td>
        </tr>
    </table>
    <table class="table-list">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Serial Number</th>
            <th>Kerusakan</th>
            <th>Keterangan</th>
        </tr>
        <?php
        $mySql = "SELECT barang_mati.*, barang_mati.serial_number as sn, barang_inventaris.*, barang.nm_barang FROM barang_mati
                LEFT JOIN barang_inventaris on barang_mati.kd_inventaris=barang_inventaris.kd_inventaris
				LEFT JOIN barang on barang_inventaris.kd_barang=barang.kd_barang
				LEFT JOIN lokasi on barang_mati.pelanggan=lokasi.kd_lokasi
                LEFT JOIN petugas ON barang_mati.kd_petugas=petugas.kd_petugas
                WHERE barang_mati.no_barang_mati='$Kode' ORDER BY barang_mati.no_barang_mati";
        $myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
        $myData = mysql_fetch_array($myQry);
            $nomor = 0;
            $nomor++;
        ?>
            <tr>
                <td width="28" align="center"bgcolor="#F5F5F5"><?php echo $nomor; ?></td>
                <td><?php echo $myData['kd_inventaris']; ?></td>
                <td><?php echo $myData['nm_barang']; ?></td>
                <td><?php echo $myData['sn']; ?></td>
                <td><?php echo $myData['kerusakan']; ?></td>
                <td><?php echo $myData['keterangan']; ?></td>
        
    </table>
    <div class="footer">
        Dicetak pada: <?php echo date('d-m-Y'); ?>
    </div>
</body>

</html>