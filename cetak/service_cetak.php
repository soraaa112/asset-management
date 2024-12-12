<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if ($_GET) {
    # Baca variabel URL
    $Kode = $_GET['Kode'];

    # Perintah untuk mendapatkan data dari tabel pengadaan
    $mySql = "SELECT services.*, service_item.kd_inventaris, vendor_service.nm_vendor_service, petugas.nm_petugas FROM services 
				LEFT JOIN service_item ON services.no_service=service_item.no_service 
				LEFT JOIN vendor_service ON services.kd_vendor_service=vendor_service.kd_vendor_service 
				LEFT JOIN petugas ON services.kd_petugas=petugas.kd_petugas 
				WHERE service_item.kd_inventaris='$Kode'";
    $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
    $myData = mysql_fetch_array($myQry);
} else {
    echo "Nomor Transaksi Tidak Terbaca";
    exit;
}
?>
<html>

<head>
    <title>:: Cetak Service - Inventory Kantor ( Aset Kantor )</title>
    <link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="javascript:window.print()">
    <h2> SERVICE BARANG </h2>
    <table width="500" border="0" cellspacing="1" cellpadding="4" class="table-print">
        <tr>
            <td width="160"><b>No. Service </b></td>
            <td width="10"><b>:</b></td>
            <td width="302" valign="top"><strong><?php echo $myData['no_service']; ?></strong></td>
        </tr>
        <tr>
            <td><b>Tgl. Service </b></td>
            <td><b>:</b></td>
            <td valign="top"><?php echo IndonesiaTgl($myData['tgl_service']); ?></td>
        </tr>
        <tr>
            <td><b>Vendor Service</b></td>
            <td><b>:</b></td>
            <td valign="top"><?php echo $myData['nm_vendor_service']; ?></td>
        </tr>
        <tr>
            <td><strong>Keterangan</strong></td>
            <td><b>:</b></td>
            <td valign="top"><?php echo $myData['keterangan']; ?></td>
        </tr>
        <tr>
            <td><strong>Petugas Input </strong></td>
            <td><b>:</b></td>
            <td valign="top"><?php echo $myData['nm_petugas']; ?></td>
        </tr>
        <tr>
            <td align="center">&nbsp;</td>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
        </tr>
    </table>
    <table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
        <tr>
            <td colspan="5"><strong>DATA BARANG</strong></td>
        </tr>

        <tr>
            <td width="28" align="center" bgcolor="#F5F5F5"><b>No</b></td>
            <td width="50" bgcolor="#F5F5F5"><strong>Kode </strong></td>
            <td width="200" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
            <td width="150" bgcolor="#F5F5F5"><b>Kerusakan</b></td>
            <td width="114" align="center" bgcolor="#F5F5F5"><strong>Hrg. Service(Rp)</strong></td>
        </tr>
        <?php
        $subTotalBeli = 0;
        $grandTotalBeli = 0;
        $totalBarang = 0;

        $mySql = "SELECT service_item.*, barang.nm_barang, kategori.nm_kategori FROM service_item
         LEFT JOIN barang_inventaris ON barang_inventaris.kd_inventaris=service_item.kd_inventaris 
		 LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
		 LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
		 WHERE service_item.kd_inventaris='$Kode' ORDER BY service_item.kd_inventaris";
        $myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
        $nomor = 0;
        while ($myData = mysql_fetch_array($myQry)) {
            $totalBarang    = $totalBarang + $myData['jumlah'];
            $subTotalBeli    = $myData['harga_service'] * $myData['jumlah']; // harga beli dari tabel pengadaan_item (harga terbaru dari supplier)
            $grandTotalBeli    = $grandTotalBeli + $subTotalBeli;
            $nomor++;
        ?>
            <tr>
                <td align="center"><?php echo $nomor; ?></td>
                <td><?php echo $myData['kd_inventaris']; ?></td>
                <td><?php echo $myData['nm_barang']; ?></td>
                <td><?php echo $myData['keterangan']; ?></td>
                <td align="center">Rp. <?php echo format_angka($myData['harga_service']); ?></td>
            </tr>
        <?php
        } ?>
        <tr>
        </tr>
    </table>
    <br />

</body>

</html>