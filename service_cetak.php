<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

if ($_GET) {
    # Baca variabel URL
    $Kode = $_GET['Kode'];

    # Perintah untuk mendapatkan data dari tabel pengadaan
    $mySql = "SELECT *, service_item.keterangan as deskripsi FROM services
	LEFT JOIN service_item ON services.no_service = service_item.no_service
	LEFT JOIN barang_inventaris ON service_item.kd_inventaris = barang_inventaris.kd_inventaris
	LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
	LEFT JOIN supplier ON services.kd_supplier = supplier.kd_supplier
	LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
	LEFT JOIN petugas ON services.kd_petugas = petugas.kd_petugas
	LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen
	WHERE services.no_service='$Kode'";
    $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
    $myData = mysql_fetch_array($myQry);
} else {
    echo "Nomor Transaksi Tidak Terbaca";
    exit;
}
?>
<html>

<head>
    <title>:: Cetak Servis - Inventory Kantor (Aset Kantor)</title>
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
        <h2>SERVIS BARANG</h2>
    </div>
    <table class="table-print">
        <tr>
            <td width="160"><b>No. Servis</b></td>
            <td width="10">:</td>
            <td><?php echo $myData['no_service']; ?></td>
        </tr>
        <tr>
            <td><b>Tanggal Kirim</b></td>
            <td>:</td>
            <td><?php echo IndonesiaTgl($myData['tgl_kirim']); ?></td>
        </tr>
        <tr>
            <td><b>Tanggal Sampai</b></td>
            <td>:</td>
            <td><?php echo IndonesiaTgl($myData['tgl_sampai']); ?></td>
        </tr>
        <tr>
            <td><b>Tanggal Servis</b></td>
            <td>:</td>
            <td><?php echo IndonesiaTgl($myData['tgl_service']); ?></td>
        </tr>
        <tr>
            <td><b>Tanggal Return</b></td>
            <td>:</td>
            <td><?php echo IndonesiaTgl($myData['tgl_return']); ?></td>
        </tr>
        <tr>
            <td><b>Customer</b></td>
            <td>:</td>
            <td><?php echo $myData['customer']; ?></td>
        </tr>
        <tr>
            <td><b>Vendor Servis</b></td>
            <td>:</td>
            <td><?php echo $myData['nm_supplier']; ?></td>
        </tr>
        <tr>
            <td><b>Petugas Input</b></td>
            <td>:</td>
            <td><?php echo $myData['nm_petugas']; ?></td>
        </tr>
        <tr>
            <td><b>Keterangan</b></td>
            <td>:</td>
            <td><?php echo $myData['deskripsi']; ?></td>
        </tr>
        <tr>
            <td><b>Lokasi</b></td>
            <td>:</td>
            <td><?php echo $myData['nm_departemen']; ?></td>
        </tr>
        <tr>
            <td><b>Status</b></td>
            <td>:</td>
            <td><?php echo $myData['status']; ?></td>
        </tr>
    </table>
    <table class="table-list">
        <tr>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>SN Awal</th>
            <th>SN Baru</th>
            <th>Kerusakan</th>
            <th>Keterangan</th>
            <th>Harga Servis</th>
        </tr>
        <?php
        $mySql = "SELECT *, service_item.serial_number as snAwal, services.keterangan as deskripsi FROM services
                LEFT JOIN service_item ON services.no_service = service_item.no_service
                LEFT JOIN barang_inventaris ON service_item.kd_inventaris = barang_inventaris.kd_inventaris
                LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
                WHERE services.no_service='$Kode'";
        $myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
        while ($myData = mysql_fetch_array($myQry)) {
        ?>
            <tr>
                <td><?php echo $myData['kd_inventaris']; ?></td>
                <td><?php echo $myData['nm_barang']; ?></td>
                <td><?php echo $myData['snAwal']; ?></td>
                <td><?php echo $myData['serial_number_baru']; ?></td>
                <td><?php echo $myData['kerusakan']; ?></td>
                <td><?php echo $myData['deskripsi']; ?></td>
                <td align="right">Rp. <?php echo format_angka($myData['harga_service']); ?></td>
            </tr>
        <?php } ?>
    </table>
    <div class="footer">
        Dicetak pada: <?php echo date('d-m-Y'); ?>
    </div>
</body>

</html>