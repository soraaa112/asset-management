<?php
include "parser-php-version.php";
# Konek ke Web Server Lokal
$myHost  = "localhost";
$myUser  = "root";
$myPass  = "";
$myDbs  = "asset";

# Konek ke Web Server Lokal
$koneksidb  = mysql_connect($myHost, $myUser, $myPass);
if (!$koneksidb) {
  echo "Failed Connection !";
}

# Memilih database pd MySQL Server
mysql_select_db($myDbs) or die("Database not Found !");
