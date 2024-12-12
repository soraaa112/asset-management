<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>

<head>
    <title>:: Laporan Data Vendor Service - Inventory Kantor ( Aset Kantor )</title>
    <link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="javascript:window.print()">
    <h2> LAPORAN DATA VENDOR SERVICE </h2>
    <table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
        <tr>
            <td width="26" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
            <td width="56" bgcolor="#F5F5F5"><strong>Kode</strong></td>
            <td width="246" bgcolor="#F5F5F5"><strong>Nama Vendor Service </strong></td>
            <td width="420" bgcolor="#F5F5F5"><strong>Alamat Lengkap </strong></td>
            <td width="126" bgcolor="#F5F5F5"><strong>No. Telepon </strong></td>
        </tr>
        <?php
        // Menampilkan data Supplier
        $mySql = "SELECT * FROM vendor_service ORDER BY kd_vendor_service ASC";
        $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
        $nomor = 0;
        while ($myData = mysql_fetch_array($myQry)) {
            $nomor++;
        ?>
            <tr>
                <td align="center"><?php echo $nomor; ?></td>
                <td><?php echo $myData['kd_vendor_service']; ?></td>
                <td><?php echo $myData['nm_vendor_service']; ?></td>
                <td><?php echo $myData['alamat']; ?></td>
                <td><?php echo $myData['no_telepon']; ?></td>
            </tr>
        <?php } ?>
    </table>

</body>

</html>