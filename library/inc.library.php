<?php
# Pengaturan tanggal komputer
date_default_timezone_set("Asia/Jakarta");

# Fungsi untuk membuat kode automatis
function buatKode4($koneksi, $tabel, $inisial){
    // Melakukan query untuk mengambil nama kolom pertama
    $struktur = mysqli_query($koneksi, "SELECT * FROM $tabel");
    $field = mysqli_fetch_field_direct($struktur, 0)->name;

    // Membaca panjang kolom kunci
    // $panjang = mysqli_fetch_field_direct($struktur, 0)->length;
    $panjang = 4;

    // Melakukan query untuk mendapatkan nilai MAX dari kolom kunci
    $qry = mysqli_query($koneksi, "SELECT MAX($field) AS maxKode FROM $tabel");
    $row = mysqli_fetch_array($qry);

    // Jika tidak ada data (tabel kosong), set angka menjadi 0, jika ada, ambil bagian angka dari kode
    if ($row['maxKode'] == "") {
        $angka = 0;
    } else {
        $angka = substr($row['maxKode'], strlen($inisial));
    }

    // Menambah angka dan mengubahnya ke string
    $angka++;
    $angka = strval($angka);

    // Membuat padding nol di depan angka, jika diperlukan
    $tmp = "";
    for ($i = 1; $i <= ($panjang - strlen($inisial) - strlen($angka)); $i++) {
        $tmp .= "0";
    }

    // Mengembalikan kode baru dengan format yang diinginkan
    return $inisial . $tmp . $angka;
}

function buatKode5($koneksi, $tabel, $inisial){
    // Melakukan query untuk mengambil nama kolom pertama
    $struktur = mysqli_query($koneksi, "SELECT * FROM $tabel");
    $field = mysqli_fetch_field_direct($struktur, 0)->name;

    // Membaca panjang kolom kunci
    // $panjang = mysqli_fetch_field_direct($struktur, 0)->length;
    $panjang = 5;

    // Melakukan query untuk mendapatkan nilai MAX dari kolom kunci
    $qry = mysqli_query($koneksi, "SELECT MAX($field) AS maxKode FROM $tabel");
    $row = mysqli_fetch_array($qry);

    // Jika tidak ada data (tabel kosong), set angka menjadi 0, jika ada, ambil bagian angka dari kode
    if ($row['maxKode'] == "") {
        $angka = 0;
    } else {
        $angka = substr($row['maxKode'], strlen($inisial));
    }

    // Menambah angka dan mengubahnya ke string
    $angka++;
    $angka = strval($angka);

    // Membuat padding nol di depan angka, jika diperlukan
    $tmp = "";
    for ($i = 1; $i <= ($panjang - strlen($inisial) - strlen($angka)); $i++) {
        $tmp .= "0";
    }

    // Mengembalikan kode baru dengan format yang diinginkan
    return $inisial . $tmp . $angka;
}

function buatKode7($koneksi, $tabel, $inisial){
    // Melakukan query untuk mengambil nama kolom pertama
    $struktur = mysqli_query($koneksi, "SELECT * FROM $tabel");
    $field = mysqli_fetch_field_direct($struktur, 0)->name;

    // Membaca panjang kolom kunci
    // $panjang = mysqli_fetch_field_direct($struktur, 0)->length;
    $panjang = 7;

    // Melakukan query untuk mendapatkan nilai MAX dari kolom kunci
    $qry = mysqli_query($koneksi, "SELECT MAX($field) AS maxKode FROM $tabel");
    $row = mysqli_fetch_array($qry);

    // Jika tidak ada data (tabel kosong), set angka menjadi 0, jika ada, ambil bagian angka dari kode
    if ($row['maxKode'] == "") {
        $angka = 0;
    } else {
        $angka = substr($row['maxKode'], strlen($inisial));
    }

    // Menambah angka dan mengubahnya ke string
    $angka++;
    $angka = strval($angka);

    // Membuat padding nol di depan angka, jika diperlukan
    $tmp = "";
    for ($i = 1; $i <= ($panjang - strlen($inisial) - strlen($angka)); $i++) {
        $tmp .= "0";
    }

    // Mengembalikan kode baru dengan format yang diinginkan
    return $inisial . $tmp . $angka;
}

# Fungsi untuk membuat kode Koleksi Inventaris buku (B0001.001, B0001.002, B0001.003, B0001.004)
function buatKodeKoleksi($tabel, $inisial, $filter){
	$struktur	= mysql_query("SELECT * FROM $tabel");
	$field		= mysql_field_name($struktur,0);
	$panjang	= mysql_field_len($struktur,0);

 	$qry	= mysql_query("SELECT MAX(".$field.") FROM ".$tabel." WHERE kd_barang='$filter'");
 	$row	= mysql_fetch_array($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $inisial.$tmp.$angka;
}

# Fungsi untuk membuat kode Koleksi Inventaris buku (B0001.001, B0001.002, B0001.003, B0001.004, B0002.004, B0003.005,...)
function buatKodeKoleksi2($koneksi, $tabel, $kodeDepan) {
    // Memastikan panjang kodeDepan tidak melebihi 5 karakter
    if (strlen($kodeDepan) > 5) {
      $kodeDepan = substr($kodeDepan, 0, 5);
    }

    $struktur = mysqli_query($koneksi, "SELECT * FROM $tabel LIMIT 1");
    
    // Mengambil nama dan panjang kolom pertama
    $field = mysqli_fetch_field_direct($struktur, 0)->name;

    // Query untuk mendapatkan angka terbesar dari bagian kanan kolom kode (6 digit terakhir)
    $qry = mysqli_query($koneksi, "SELECT MAX(RIGHT($field, 6)) AS angka FROM $tabel");
    $row = mysqli_fetch_array($qry);

    // Jika tidak ada data, set angka menjadi 0
    if ($row['angka'] == "") {
        $angka = 0;
    } else {
        // Jika ada data, ambil bagian angka dari kolom
        $angka = $row['angka'];
    }

    // Tambahkan 1 ke angka yang ada dan ubah menjadi string
    $angka++;
    $angka = strval($angka);

    // Menambahkan padding nol di depan angka untuk memastikan memiliki 6 digit
    $angkaBaru = str_pad($angka, 6, "0", STR_PAD_LEFT);

    // Bagian depan kode, misalnya 'B0001' harus tetap konstan
    // Kita menganggap bahwa $kodeDepan sudah dalam bentuk yang diinginkan ('B0001')

    // Mengembalikan kode baru dengan format B0001.000001
    return $kodeDepan . '.' . $angkaBaru;
}

# Fungsi untuk membalik tanggal dari format Indo (d-m-Y) -> English (Y-m-d)
function InggrisTgl($tanggal){
	$tgl=substr($tanggal,0,2);
	$bln=substr($tanggal,3,2);
	$thn=substr($tanggal,6,4);
	$tanggal="$thn-$bln-$tgl";
	return $tanggal;
}

# Fungsi untuk membalik tanggal dari format Indo (d-m-Y) -> English (Y-m-d)
function InggrisTgl1($tanggal){
	$tgl=substr($tanggal,0,2);
	$bln=substr($tanggal,3,2);
	$thn=substr($tanggal,6,4);
	$jam = substr($tanggal, 11, 2);
	$mnt = substr($tanggal, 14, 2);
	$dtk = substr($tanggal, 17, 2);
	$tanggal="$thn-$bln-$tgl $jam:$mnt:$dtk";
	return $tanggal;
}

function Inggris($tanggal){
	$thn=substr($tanggal,0,4);
	$tanggal="$thn";
	return $tanggal;
}
# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
function IndonesiaTgl($tanggal){
	$tgl=substr(strval($tanggal),8,2);
	$bln=substr(strval($tanggal),5,2);
	$thn=substr(strval($tanggal),0,4);
	$tanggal="$tgl-$bln-$thn";
	return $tanggal;
}

# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
function IndonesiaTgl2($tanggal){
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$jam = substr($tanggal, 11, 2);
	$mnt = substr($tanggal, 14, 2);
	$dtk = substr($tanggal, 17, 2);
	$tanggal="$tgl-$bln-$thn $jam:$mnt:$dtk";
	return $tanggal;
}

# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
function Indonesia2Tgl($tanggal){
	$namaBln = array("01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", 
					 "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");
					 
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$tanggal ="$tgl ".$namaBln[$bln]." $thn";
	return $tanggal;
}

function hitungHari($myDate1, $myDate2){
        $myDate1 = strtotime($myDate1);
        $myDate2 = strtotime($myDate2);
 
        return ($myDate2 - $myDate1)/ (24 *3600);
}

# Fungsi untuk membuat format rupiah pada angka (uang)
function format_angka($angka) {
	$hasil =  number_format($angka,0, ",",".");
	return $hasil;
}

# Fungsi untuk format tanggal, dipakai plugins Callendar
function form_tanggal($nama,$value=''){
	echo" <input type='text' name='$nama' id='$nama' size='11' maxlength='20' value='$value'/>&nbsp;
	<img src='images/calendar-add-icon.png' align='top' style='cursor:pointer; margin-top:7px;' alt='kalender'onclick=\"displayCalendar(document.getElementById('$nama'),'dd-mm-yyyy',this)\"/>			
	";
}

function angkaTerbilang($x){
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return angkaTerbilang($x - 10) . " belas";
  elseif ($x < 100)
    return angkaTerbilang($x / 10) . " puluh" . angkaTerbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . angkaTerbilang($x - 100);
  elseif ($x < 1000)
    return angkaTerbilang($x / 100) . " ratus" . angkaTerbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . angkaTerbilang($x - 1000);
  elseif ($x < 1000000)
    return angkaTerbilang($x / 1000) . " ribu" . angkaTerbilang($x % 1000);
  elseif ($x < 1000000000)
    return angkaTerbilang($x / 1000000) . " juta" . angkaTerbilang($x % 1000000);
}
