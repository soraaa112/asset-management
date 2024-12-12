<?php
include_once "library/inc.seslogin.php";

// Membaca User yang Login
$userLogin    = $_SESSION['SES_LOGIN'];

# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if (isset($_POST['btnSimpan'])) {
    // Baca variabel from
    $txtTanggal     = InggrisTgl($_POST['txtTanggal']);
    $cmbDepartemen  = $_POST['cmbDepartemen'];
    $cmbLokasi      = $_POST['cmbLokasi'];

    // Validasi
    $pesanError = array();
    if (trim($txtTanggal) == "--") {
        $pesanError[] = "Data <b>Tanggal Kembali</b> belum diisi, pilih pada combo !";
    }
    if (trim($cmbDepartemen) == "") {
        $pesanError[] = "Data <b>Departemen</b> belum diisi, silahkan diperbaiki !";
    }
    if (trim($cmbLokasi) == "") {
        $pesanError[] = "Data <b>Lokasi</b> belum diisi, silahkan diperbaiki !";
    }

    // JIKA ADA PESAN ERROR DARI VALIDASI
    if (count($pesanError) >= 1) {
        echo "<div class='mssgBox'>";
        echo "<img src='images/attention.png'> <br><hr>";
        $noPesan = 0;
        foreach ($pesanError as $indeks => $pesan_tampil) {
            $noPesan++;
            echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
        }
        echo "</div> <br>";
    } else {
        $errors = array();
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            $file_name = 'file' . $key . $_FILES['files']['name'][$key];
            $file_size = $_FILES['files']['size'][$key];
            $file_tmp = $_FILES['files']['tmp_name'][$key];
            $file_type = $_FILES['files']['type'][$key];
            if ($file_size > 9097152) {
                $errors[] = 'File size must be less than 2 MB';
            }
            $images[] = $file_name;
            $desired_dir = "user_data";
            if (empty($errors) == true) {
                if (is_dir($desired_dir) == false) {
                    mkdir("$desired_dir", 0700);    // Create directory if it does not exist
                }
                if (is_dir("$desired_dir/" . $file_name) == false) {
                    move_uploaded_file($file_tmp, "$desired_dir/" . $file_name);
                } else {
                    $new_dir = "$desired_dir/" . $file_name . time();
                    rename($file_tmp, $new_dir);
                }
            } else {
                print_r($errors);
            }
        }

        if (implode('', $images) != '' or implode('', $images) != '0') {
            $fileName = implode(';', $images);
        } else {
            $cek = mysql_fetch_array(mysql_query("SELECT * FROM penempatan where no_penempatan='$_POST[txtKode]'"));
            $fileName = $cek['form_bast'];
        }
        # SIMPAN DATA KE DATABASE
        # Jika jumlah error pesanError tidak ada

        // Skrip Update status barang (used=keluar/dipakai)
        $txtKode    = $_POST['txtKode'];
        $mySql = "UPDATE penempatan SET tgl_penempatan='$txtTanggal', kd_departemen = '$cmbDepartemen', kd_lokasi = '$cmbLokasi', form_bast = '$fileName' WHERE no_pengadaan='$txtKode'";
        mysql_query($mySql, $koneksidb) or die("Gagal Query Edit Status : " . mysql_error());

        $myQry    = mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
        if ($myQry) {
            echo "<meta http-equiv='refresh' content='0; url=?open=Penempatan-Tampil'>";
        }
        exit;
    }
}

# TAMPILKAN DATA UNTUK DIEDIT
$Kode   = $_GET['Kode'];
$mySql  = "SELECT penempatan.*, departemen.nm_departemen, lokasi.nm_lokasi FROM penempatan
LEFT JOIN departemen ON penempatan.kd_departemen = departemen.kd_departemen
LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
WHERE no_penempatan='$Kode'";
$myQry  = mysql_query($mySql, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
$myData = mysql_fetch_array($myQry);

// Variabel data form
$dataKode           = $myData['no_penempatan'];
$dataDepartemen     = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $myData['nm_departemen'];
$dataLokasi         = isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : $myData['nm_lokasi'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd">
    <table width="900" cellpadding="3" cellspacing="1" class="table-list">
        <tr>
            <td colspan="3">
                <h1>DETAIL DATA PENEMPATAN</h1>
            </td>
        </tr>
        <tr>
            <td bgcolor="#F5F5F5"><strong>DATA PENEMPATAN</strong></td>
            <td>&nbsp;</td>
            <td><input name="txtKode" type="hidden" value="<?php echo $Kode; ?>" /></td>
        </tr>
        <tr>
            <td width="15%"><strong>No. Penempatan </strong></td>
            <td width="1%"><strong>:</strong></td>
            <td width="78%"><strong><?php echo $dataKode; ?></strong></td>
        </tr>
        <tr>
            <td><strong>Tgl. Penempatan </strong></td>
            <td><strong>:</strong></td>
            <td width="78%"><strong><?php echo IndonesiaTgl($myData['tgl_penempatan']); ?></strong></td>
        </tr>
        <tr>
            <td><strong>Departemen </strong></td>
            <td><strong>:</strong></td>
            <td width="78%"><strong><?php echo $dataDepartemen; ?></strong></td>
        </tr>
        <tr>
            <td><strong>Lokasi </strong></td>
            <td><strong>:</strong></td>
            <td width="78%"><strong><?php echo $dataLokasi; ?></strong></td>
        </tr>
        <tr>
            <td><b>BAST (Multiple Upload)</b></td>
            <td><b>:</b></td>
            <td>
                <?php
                $ex = explode(';', $myData['form_bast']);
                $no = 1;
                for ($i = 0; $i < count($ex); $i++) {
                    if ($ex[$i] != '') {
                        echo "<a target='_BLANK' href='user_data/" . $ex[$i] . "'><img style='margin-right:5px' width='100px' src='user_data/" . $ex[$i] . "'></a>";
                    }
                    $no++;
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>

    <table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
        <tr>
            <td colspan="4"><strong>DAFTAR BARANG </strong></td>
        </tr>
        <tr>
            <td width="21" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
            <td width="96" bgcolor="#CCCCCC"><strong>Kode</strong></td>
            <td width="559" bgcolor="#CCCCCC"><strong>Type Barang </strong></td>
            <td width="203" bgcolor="#CCCCCC"><strong>Kategori</strong></td>
        </tr>
        <?php
        // Qury menampilkan data dalam Grid TMP_peminjaman 
        $tmpSql = "SELECT barang.nm_barang, kategori.nm_kategori, penempatan_item.* 
		FROM penempatan_item
		LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris = barang_inventaris.kd_inventaris
		LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
		LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori
		WHERE penempatan_item.no_penempatan='$Kode'
		ORDER BY barang_inventaris.kd_inventaris ";
        $tmpQry = mysql_query($tmpSql, $koneksidb) or die("Gagal Query Tmp" . mysql_error());
        $nomor = 0;
        while ($tmpData = mysql_fetch_array($tmpQry)) {
            $nomor++;
        ?>
            <tr>
                <td align="center"><?php echo $nomor; ?></td>
                <td><b><?php echo $tmpData['kd_inventaris']; ?></b></td>
                <td><?php echo $tmpData['nm_barang']; ?></td>
                <td><?php echo $tmpData['nm_kategori']; ?></td>
            </tr>
        <?php } ?>
    </table>
</form>