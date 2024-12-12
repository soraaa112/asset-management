<body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
    <?php
    include_once "library/inc.seslogin.php";

    $filterSQL = "";

    if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
        # Pegawai terpilih
        $kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : $_SESSION['SES_UNIT'];
        $kodeDepartemen = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen;
    } else {
        $kodeDepartemen = isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua';
        $kodeDepartemen = isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen;
    }

    if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
        $filterSQL = "WHERE departemen.nm_departemen = '$_SESSION[SES_UNIT]'";
    } else {
        if (isset($_POST['btnCari'])) {
            if (trim($_POST['cmbDepartemen']) == "Semua") {
                //Query #1 (all)
                $filterSQL   = "";
            } else {
                //Query #2 (filter)
                $filterSQL   = " WHERE pegawai.kd_departemen ='$kodeDepartemen'";
            }
        } else {
            //Query #1 (all)
            $filterSQL   = "";
        }
    }


    $dataKataKunci = isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';
    # UNTUK PAGING (PEMBAGIAN HALAMAN)
    $row = 10;
    $hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
    if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
        $pageSql = "SELECT * FROM pegawai LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen $filterSQL";
    } else {
        $pageSql = "SELECT * FROM pegawai $filterSQL";
    }
    $pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
    $jml   = mysql_num_rows($pageQry);
    $max   = ceil($jml / $row);
    ?>
    <div class="table-border">
        <div style="overflow-x:auto;">
            <h2>DATA PEGAWAI <a href="?open=Pegawai-Add" target="_self"><img style='padding-right:0px !important' src="images/btn_add_data.png" border="0" /></a></h2>
            <form style='padding-top:0px !important' action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
                <table width="900" border="0" class="table-list">
                    <tr>
                        <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
                    </tr>
                    <tr>
                        <td width="137"><b>Departemen </b></td>
                        <td width="5"><b>:</b></td>
                        <td width="744">
                            <?php if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) { ?>
                                <select name="cmbDepartemen" data-live-search="true" class="selectpicker">
                                    <?php
                                    $mySql = "SELECT * FROM departemen WHERE nm_departemen='$_SESSION[SES_UNIT]' ORDER BY kd_departemen";
                                    $myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
                                    while ($myData = mysql_fetch_array($myQry)) {
                                        if ($kodeDepartemen == $myData['kd_departemen']) {
                                            $cek = " selected";
                                        } else {
                                            $cek = "";
                                        }
                                        echo "<option value='$myData[kd_departemen]' $cek>$myData[nm_departemen]</option>";
                                    }
                                    $mySql = "";
                                    ?>
                                </select>
                            <?php } else { ?>
                                <select name="cmbDepartemen" data-live-search="true" class="selectpicker">
                                    <option value="Semua">Semua</option>
                                    <?php
                                    $mySql = "SELECT * FROM departemen ORDER BY kd_departemen";
                                    $myQry = mysql_query($mySql, $koneksidb) or die("Gagal Query" . mysql_error());
                                    while ($myData = mysql_fetch_array($myQry)) {
                                        if ($kodeDepartemen == $myData['kd_departemen']) {
                                            $cek = " selected";
                                        } else {
                                            $cek = "";
                                        }
                                        echo "<option value='$myData[kd_departemen]' $cek>$myData[nm_departemen]</option>";
                                    }
                                    $mySql = "";
                                    ?>
                                </select>
                            <?php } ?>
                            <input name="btnCari" type="submit" value=" Tampilkan " />
                        </td>
                    </tr>
                </table>
            </form>
            <table id="example1" class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
                <thead>
                    <tr>
                        <th width="30" align="center">No</th>
                        <th width="80">Kode</th>
                        <th width="255">Nama Pegawai </th>
                        <th width="200"><b>Departemen </b> </th>
                        <th width="100">Kelamin</th>
                        <th width="200">Alamat</th>
                        <th width="140" bgcolor="#CCCCCC">
                            <center><strong>Aksi</strong></center>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Skrip menampilkan data Pegawai
                    if (isset($_SESSION["SES_PETUGAS"]) && ($_SESSION["SES_UNIT"])) {
                        $mySql = "SELECT pegawai.*, departemen.nm_departemen FROM pegawai 
                        LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
                        $filterSQL AND departemen.nm_departemen = '$_SESSION[SES_UNIT]'
                        ORDER BY kd_pegawai ASC";
                    } else {
                        $mySql = "SELECT pegawai.*, departemen.nm_departemen FROM pegawai 
                        LEFT JOIN departemen ON pegawai.kd_departemen=departemen.kd_departemen
                        $filterSQL 
                        ORDER BY kd_pegawai ASC";
                    }
                    $myQry = mysql_query($mySql, $koneksidb)  or die("Query salah : " . mysql_error());
                    $nomor = $hal;
                    while ($myData = mysql_fetch_array($myQry)) {
                        $nomor++;
                        $Kode = $myData['kd_pegawai'];

                        // gradasi warna
                        if ($nomor % 2 == 1) {
                            $warna = "";
                        } else {
                            $warna = "#F5F5F5";
                        }
                    ?>
                        <tr bgcolor="<?php echo $warna; ?>">
                            <td><?php echo $nomor; ?></td>
                            <td><?php echo $myData['kd_pegawai']; ?></td>
                            <td><?php echo $myData['nm_pegawai']; ?></td>
                            <td><?php echo $myData['nm_departemen']; ?></td>
                            <td><?php echo $myData['jns_kelamin']; ?></td>
                            <td><?php echo $myData['alamat']; ?></td>
                            <td width="40" align="center">
                                <a href="?open=Pegawai-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('YAKIN AKAN MENGHAPUS DATA PEGAWAI INI ... ?')">
                                    <button class="btn btn-danger" title="Hapus Data"><i class="fa fa-trash"></i>
                                    </button>
                                </a>
                                &nbsp;
                                <a href="?open=Pegawai-Edit&Kode=<?php echo $Kode; ?>" target="_self">
                                    <button class="btn btn-warning" title="Edit Data"><i class="fa fa-pencil"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>