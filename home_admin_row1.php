<body>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
  <?php if (isset($_SESSION["SES_PETUGAS"])) { ?>
    <a style='color:#000' href='#'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
          <div class="info-box-content">
            <?php $nm_petugas = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM petugas", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Pengguna</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_petugas['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='#'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
          <div class="info-box-content">
            <?php $nm_pegawai = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM pegawai", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Pegawai</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_pegawai['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='#'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
          <div class="info-box-content">
            <?php $nm_kategori = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM kategori", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Kategori</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_kategori['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='#'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
          <div class="info-box-content">
            <?php $nm_barang = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM barang", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Barang</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_barang['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='#'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-orange"><i class="fa fa-th"></i></span>
          <div class="info-box-content">
            <?php $nm_barang = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM pengadaan", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Total</span>
            <span class="info-box-text" style="font-size: 13px;">Pengadaan</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_barang['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='#'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-teal"><i class="fa fa-filter"></i></span>
          <div class="info-box-content">
            <?php $nm_barang = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM pengadaan WHERE MONTH(tgl_pengadaan) = MONTH(CURDATE()) 
          AND YEAR(tgl_pengadaan) = YEAR(CURDATE())", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Pengadaan</span>
            <span class="info-box-text" style="font-size: 13px;">Bulan Ini</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_barang['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='#'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-purple"><i class="fa fa-asterisk"></i></span>
          <div class="info-box-content">
            <?php $tgl_pengadaan = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM pengadaan WHERE status_approval = 'Belum Approve'", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Pengadaan</span>
            <span class="info-box-text" style="font-size: 13px;">Belum Approve</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $tgl_pengadaan['total']; ?></span>
          </div>
        </div>
      </div>
    </a>
  <?php } elseif (isset($_SESSION["SES_OPERATOR"])) { ?>
    <a style='color:#000' href='#'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
          <div class="info-box-content">
            <?php $nm_petugas = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM petugas", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Pengguna</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_petugas['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='index.php?open=Pegawai-Data'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
          <div class="info-box-content">
            <?php $nm_pegawai = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM pegawai", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Pegawai</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_pegawai['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='index.php?open=Kategori-Data'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
          <div class="info-box-content">
            <?php $nm_kategori = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM kategori", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Kategori</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_kategori['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='index.php?open=Barang-Data'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
          <div class="info-box-content">
            <?php $nm_barang = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM barang", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Barang</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_barang['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='index.php?open=Pengadaan-Tampil'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-orange"><i class="fa fa-th"></i></span>
          <div class="info-box-content">
            <?php $nm_barang = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM pengadaan", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Total</span>
            <span class="info-box-text" style="font-size: 13px;">Pengadaan</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_barang['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='index.php?open=Pengadaan-Tampil'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-teal"><i class="fa fa-filter"></i></span>
          <div class="info-box-content">
            <?php $nm_barang = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM pengadaan WHERE MONTH(tgl_pengadaan) = MONTH(CURDATE()) 
          AND YEAR(tgl_pengadaan) = YEAR(CURDATE())", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Pengadaan</span>
            <span class="info-box-text" style="font-size: 13px;">Bulan Ini</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_barang['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='index.php?open=Pengadaan-Tampil'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-purple"><i class="fa fa-asterisk"></i></span>
          <div class="info-box-content">
            <?php $tgl_pengadaan = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM pengadaan WHERE status_approval = 'Belum Approve'", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Pengadaan</span>
            <span class="info-box-text" style="font-size: 13px;">Belum Approve</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $tgl_pengadaan['total']; ?></span>
          </div>
        </div>
      </div>
    </a>
  <?php } else { ?>
    <a style='color:#000' href='index.php?open=Petugas-Data'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
          <div class="info-box-content">
            <?php $nm_petugas = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM petugas", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Pengguna</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_petugas['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='index.php?open=Pegawai-Data'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
          <div class="info-box-content">
            <?php $nm_pegawai = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM pegawai", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Pegawai</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_pegawai['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='index.php?open=Kategori-Data'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
          <div class="info-box-content">
            <?php $nm_kategori = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM kategori", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Kategori</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_kategori['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='index.php?open=Barang-Data'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
          <div class="info-box-content">
            <?php $nm_barang = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM barang", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Barang</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_barang['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='index.php?open=Pengadaan-Tampil'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-orange"><i class="fa fa-th"></i></span>
          <div class="info-box-content">
            <?php $nm_barang = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM pengadaan", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Total</span>
            <span class="info-box-text" style="font-size: 13px;">Pengadaan</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $nm_barang['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='index.php?open=Pengadaan-Tampil'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-teal"><i class="fa fa-filter"></i></span>
          <div class="info-box-content">
            <?php $tgl_pengadaan = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM pengadaan WHERE MONTH(tgl_pengadaan) = MONTH(CURDATE()) 
          AND YEAR(tgl_pengadaan) = YEAR(CURDATE())", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Pengadaan</span>
            <span class="info-box-text" style="font-size: 13px;">Bulan Ini</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $tgl_pengadaan['total']; ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
    </a>

    <a style='color:#000' href='index.php?open=Pengadaan-Tampil'>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-purple"><i class="fa fa-asterisk"></i></span>
          <div class="info-box-content">
            <?php $tgl_pengadaan = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM pengadaan WHERE status_approval = 'Belum Approve'", $koneksidb)); ?>
            <span class="info-box-text" style="font-size: 13px;">Pengadaan</span>
            <span class="info-box-text" style="font-size: 13px;">Belum Approve</span>
            <span class="info-box-number" style="font-size: 15px;"><?php echo $tgl_pengadaan['total']; ?></span>
          </div>
        </div>
      </div>
    </a>
  <?php } ?>