<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NHT Asset | Log in</title>
  <link rel="icon" href="images/favicon-nht.png" sizes="16x16">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <!-- <a href="../../index2.html"><b>JAYA</b> ASSET</a> -->
      <img src=images/favicon-nht.png alt="" style="width:50%;">
    </div><!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Silahkan Login Pada Form dibawah ini</p>

      <form action="" method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name='txtUser' placeholder="Username" required>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name='txtPassword' placeholder="Password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <!-- <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div> -->
          </div><!-- /.col -->
          <div class="col-xs-4">
            <button name='btnLogin' type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div><!-- /.col -->
        </div>
      </form>

    </div><!-- /.login-box-body -->
  </div><!-- /.login-box -->

  <!-- jQuery 2.1.4 -->
  <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="plugins/iCheck/icheck.min.js"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
    });
  </script>
</body>

</html>

<?php
# LOGIN dari file login.php
if (isset($_POST['btnLogin'])) {
  # Baca variabel form
  $txtUser    = $_POST['txtUser'];
  $txtUser    = str_replace("'", "&acute;", $txtUser);
  $txtPassword  = $_POST['txtPassword'];
  $txtPassword  = str_replace("'", "&acute;", $txtPassword);

  # Validasi form
  $pesanError = array();
  if (trim($txtUser) == "") {
    $pesanError[] = "Data <b> Username </b>  tidak boleh kosong !";
  }
  if (trim($txtPassword) == "") {
    $pesanError[] = "Data <b> Password </b> tidak boleh kosong !";
  }


  # JIKA ADA PESAN ERROR DARI VALIDASI
  if (count($pesanError) >= 1) {
    echo "<div class='mssgBox'>";
    echo "<img src='images/attention.png'> <br><hr>";
    $noPesan = 0;
    foreach ($pesanError as $indeks => $pesan_tampil) {
      $noPesan++;
      echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
    }
    echo "</div> <br>";

    // Tampilkan lagi form login
    include "login.php";
  } else {
    # LOGIN CEK KE TABEL USER LOGIN
    $mySql = "SELECT petugas.*, departemen.nm_departemen FROM petugas
    LEFT JOIN departemen ON petugas.kd_departemen = departemen.kd_departemen
    WHERE username='$txtUser' AND password='" . md5($txtPassword) . "'";
    $myQry = mysql_query($mySql, $koneksidb) or die("Query Salah : " . mysql_error());
    $myData = mysql_fetch_array($myQry);

    # JIKA LOGIN SUKSES
    if (mysql_num_rows($myQry) >= 1) {
      $_SESSION['SES_LOGIN'] = $myData['kd_petugas'];
      $_SESSION['SES_USER'] = $myData['username'];
      $_SESSION['SES_NAMA'] = $myData['nm_petugas'];
      $_SESSION['SES_UNIT'] = $myData['nm_departemen'];
      $_SESSION['level'] = $myData['level'];
      // Jika yang login Administrator
      if ($_SESSION['level'] == "Admin") {
        $_SESSION['SES_ADMIN'] = "Admin";
      }

      // Jika yang login Petugas
      if ($_SESSION['level'] == "Petugas") {
        $_SESSION['SES_PETUGAS'] = "Petugas";
      }

      // Jika yang login Operator
      if ($_SESSION['level'] == "Operator") {
        $_SESSION['SES_OPERATOR'] = "Operator";
      }

      // Refresh
      echo "<meta http-equiv='refresh' content='0; url=?open=Halaman-Utama'>";
    } else {
      echo "<script>
      alert('Username atau Password anda salah')
      </script>";
    }
  }
} // End POST
?>