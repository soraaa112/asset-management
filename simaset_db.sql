-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2023 at 03:14 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simaset_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kd_barang` varchar(5) NOT NULL,
  `nm_barang` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `merek` varchar(100) NOT NULL,
  `jumlah` int(6) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `kd_kategori` char(4) NOT NULL,
  `foto` text,
  `tgl_pembelian` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kd_barang`, `nm_barang`, `keterangan`, `merek`, `jumlah`, `satuan`, `kd_kategori`, `foto`, `tgl_pembelian`) VALUES
('B0001', 'TOSHIBA Satellite C800D-1003 - Black ', 'Notebook / Laptop 13 inch - 14 inch AMD Dual Core E1-1200, 2GB DDR3, 320GB HDD, DVD RW, WiFi, Bluetooth, VGA AMD Radeon HD 7000 Series, Camera, 14', 'TOSHIBA', 4, 'Unit', 'K002', '0Koala.jpg;1Penguins.jpg', '2023-08-21'),
('B0002', 'TOSHIBA Satellite C40-A106 - Black', 'Notebook / Laptop 13 inch - 14 inch Intel Core i3-2348M, 2GB DDR3, 500GB HDD, DVD±RW, WiFi, Bluetooth, VGA Intel HD Graphics, Camera, 14', 'TOSHIBA', 11, 'Unit', 'K002', '', '2023-08-21'),
('B0003', 'Printer Canon LBP 5100 Laser Jet', 'Canon LBP 5100 Laser Jet', 'Canon', 2, 'Unit', 'K003', '', '2023-08-21'),
('B0004', 'Printer Canon IP 2770', 'Canon IP 2770', 'Canon', 14, 'Unit', 'K003', '', '2023-08-21'),
('B0005', 'Printer Brother Colour Laser HL-2150N Mono', 'Brother Colour Laser HL-2150N Mono Laser Printer, Networking', 'Brother', 4, 'Unit', 'K003', '', '2023-08-21'),
('B0006', 'UPS Prolink Pro 700', 'Prolink Pro 700', 'Prolink', 4, 'Unit', 'K004', '', '2023-08-21'),
('B0007', 'UPS Prolink IPS 500i Inverter 500VA', 'Prolink IPS 500i Inverter 500VA', 'Prolink', 11, 'Unit', 'K004', '', '2023-08-21'),
('B0008', 'Meja Komputer Crystal Grace 101', 'Crystal Grace 101 (100x45x70)', 'Crystal Grace', 9, 'Unit', 'K005', '', '2023-08-21'),
('B0009', 'Komputer Kantor - Paket 1', 'Motherboard PCP+ 790Gx Baby Raptor\r\nProcessor AMD Athlon II 64 X2 250\r\nMemory 1 GB DDR2 PC6400 800 MHz\r\nHarddisk WDC 320 GB Sata\r\nDVD±RW/RAM 24x Sata\r\nKeyboard + Mouse SPC\r\nCasing Libera Series 500 Wa', 'Rakitan', 25, 'Unit', 'K001', '', '2023-08-21'),
('B0010', 'Komputer Kantor - Paket 2', 'Dual Core (2.6 Ghz) TRAY\r\nMainboard ASUS P5 KPL AM-SE ( Astrindo )\r\nMemory DDR2 V-gen 2 Gb PC 5300\r\nHarddisk 250 Gb Seagate/WDC/Maxtor SATA\r\nKeyboard + Mouse Logitech\r\nCasing SPC 350w + 1 FAN CPU\r\nLCD', 'Rakitan', 21, 'Unit', 'K001', '', '2023-08-21'),
('B0011', 'LCD LG 19 Inch', 'LG 19 Inch L1942S (Square)', 'LG', 10, 'Unit', 'K006', '0', '2023-08-21'),
('123', 'hp', 'test', 'samsung', 2023, 'Unit', '0', 'K002', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `barang_inventaris`
--

CREATE TABLE `barang_inventaris` (
  `kd_inventaris` char(12) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `no_pengadaan` char(7) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `status_barang` enum('Tersedia','Ditempatkan','Dipinjam') NOT NULL DEFAULT 'Tersedia'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_inventaris`
--

INSERT INTO `barang_inventaris` (`kd_inventaris`, `kd_barang`, `no_pengadaan`, `tgl_masuk`, `status_barang`) VALUES
('B0001.000001', 'B0001', 'BB00002', '2015-08-06', 'Ditempatkan'),
('B0001.000002', 'B0001', 'BB00002', '2015-08-06', 'Ditempatkan'),
('B0002.000003', 'B0002', 'BB00002', '2015-08-06', 'Ditempatkan'),
('B0002.000004', 'B0002', 'BB00002', '2015-08-06', 'Ditempatkan'),
('B0002.000005', 'B0002', 'BB00002', '2015-08-06', 'Dipinjam'),
('B0003.000006', 'B0003', 'BB00003', '2015-08-06', 'Ditempatkan'),
('B0003.000007', 'B0003', 'BB00003', '2015-08-06', 'Ditempatkan'),
('B0004.000008', 'B0004', 'BB00003', '2015-08-06', 'Dipinjam'),
('B0004.000009', 'B0004', 'BB00003', '2015-08-06', 'Ditempatkan'),
('B0004.000010', 'B0004', 'BB00003', '2015-08-06', 'Dipinjam'),
('B0004.000011', 'B0004', 'BB00003', '2015-08-06', 'Ditempatkan'),
('B0004.000012', 'B0004', 'BB00003', '2015-08-06', 'Tersedia'),
('B0004.000013', 'B0004', 'BB00003', '2015-08-06', 'Tersedia'),
('B0005.000014', 'B0005', 'BB00003', '2015-08-06', 'Ditempatkan'),
('B0005.000015', 'B0005', 'BB00003', '2015-08-06', 'Tersedia'),
('B0005.000016', 'B0005', 'BB00003', '2015-08-06', 'Tersedia'),
('B0005.000017', 'B0005', 'BB00003', '2015-08-06', 'Ditempatkan'),
('B0006.000018', 'B0006', 'BB00004', '2015-08-06', 'Tersedia'),
('B0006.000019', 'B0006', 'BB00004', '2015-08-06', 'Dipinjam'),
('B0007.000020', 'B0007', 'BB00004', '2015-08-06', 'Dipinjam'),
('B0007.000021', 'B0007', 'BB00004', '2015-08-06', 'Tersedia'),
('B0007.000022', 'B0007', 'BB00004', '2015-08-06', 'Tersedia'),
('B0007.000023', 'B0007', 'BB00004', '2015-08-06', 'Tersedia'),
('B0007.000024', 'B0007', 'BB00004', '2015-08-06', 'Tersedia'),
('B0007.000025', 'B0007', 'BB00004', '2015-08-06', 'Tersedia'),
('B0007.000026', 'B0007', 'BB00004', '2015-08-06', 'Tersedia'),
('B0008.000027', 'B0008', 'BB00005', '2015-08-06', 'Tersedia'),
('B0008.000028', 'B0008', 'BB00005', '2015-08-06', 'Ditempatkan'),
('B0008.000029', 'B0008', 'BB00005', '2015-08-06', 'Tersedia'),
('B0008.000030', 'B0008', 'BB00005', '2015-08-06', 'Tersedia'),
('B0008.000031', 'B0008', 'BB00005', '2015-08-06', 'Dipinjam'),
('B0008.000032', 'B0008', 'BB00005', '2015-08-06', 'Tersedia'),
('B0008.000033', 'B0008', 'BB00005', '2015-08-06', 'Tersedia'),
('B0009.000034', 'B0009', 'BB00001', '2015-08-06', 'Dipinjam'),
('B0009.000035', 'B0009', 'BB00001', '2015-08-06', 'Tersedia'),
('B0009.000036', 'B0009', 'BB00001', '2015-08-06', 'Tersedia'),
('B0009.000037', 'B0009', 'BB00001', '2015-08-06', 'Tersedia'),
('B0010.000038', 'B0010', 'BB00001', '2015-08-06', 'Ditempatkan'),
('B0010.000039', 'B0010', 'BB00001', '2015-08-06', 'Ditempatkan'),
('B0011.000040', 'B0011', 'BB00006', '2015-08-06', 'Tersedia'),
('B0011.000041', 'B0011', 'BB00006', '2015-08-06', 'Tersedia'),
('B0011.000042', 'B0011', 'BB00006', '2015-08-06', 'Tersedia'),
('B0011.000043', 'B0011', 'BB00006', '2015-08-06', 'Ditempatkan'),
('B0011.000044', 'B0011', 'BB00006', '2015-08-06', 'Tersedia'),
('B0011.000045', 'B0011', 'BB00006', '2015-08-06', 'Tersedia'),
('B0011.000046', 'B0011', 'BB00006', '2015-08-06', 'Dipinjam'),
('B0009.000049', 'B0009', 'BB00007', '2016-07-28', 'Tersedia'),
('B0009.000048', 'B0009', 'BB00007', '2016-07-28', 'Tersedia'),
('B0009.000047', 'B0009', 'BB00007', '2016-07-28', 'Tersedia'),
('B0009.000050', 'B0009', 'BB00007', '2016-07-28', 'Tersedia'),
('B0009.000051', 'B0009', 'BB00007', '2016-07-28', 'Tersedia'),
('B0010.000052', 'B0010', 'BB00008', '2016-07-28', 'Tersedia'),
('B0010.000053', 'B0010', 'BB00008', '2016-07-28', 'Tersedia'),
('B0010.000054', 'B0010', 'BB00008', '2016-07-28', 'Tersedia'),
('B0010.000061', 'B0010', 'BB00011', '2017-03-21', 'Tersedia'),
('B0006.000056', 'B0006', 'BB00010', '2016-10-24', 'Tersedia'),
('B0010.000057', 'B0010', 'BB00010', '2016-10-24', 'Tersedia'),
('B0010.000058', 'B0010', 'BB00010', '2016-10-24', 'Tersedia'),
('B0010.000059', 'B0010', 'BB00010', '2016-10-24', 'Tersedia'),
('B0010.000060', 'B0010', 'BB00010', '2016-10-24', 'Tersedia'),
('B0010.000062', 'B0010', 'BB00011', '2017-03-21', 'Tersedia'),
('B0009.000063', 'B0009', 'BB00011', '2017-03-21', 'Tersedia'),
('B0007.000064', 'B0007', 'BB00012', '2017-08-02', 'Tersedia'),
('B0007.000065', 'B0007', 'BB00012', '2017-08-02', 'Tersedia'),
('B0007.000066', 'B0007', 'BB00012', '2017-08-02', 'Tersedia'),
('B0010.000067', 'B0010', 'BB00012', '2017-08-02', 'Tersedia'),
('B0010.000068', 'B0010', 'BB00012', '2017-08-02', 'Tersedia'),
('B0010.000069', 'B0010', 'BB00012', '2017-08-02', 'Tersedia'),
('B0010.000070', 'B0010', 'BB00012', '2017-08-02', 'Dipinjam'),
('B0010.000071', 'B0010', 'BB00012', '2017-08-02', 'Tersedia'),
('B0010.000072', 'B0010', 'BB00012', '2017-08-02', 'Ditempatkan'),
('B0010.000073', 'B0010', 'BB00012', '2017-08-02', 'Tersedia'),
('B0010.000074', 'B0010', 'BB00012', '2017-08-02', 'Tersedia'),
('B0007.000075', 'B0007', 'BB00013', '2019-01-04', 'Tersedia'),
('B0006.000076', 'B0006', 'BB00013', '2019-01-04', 'Tersedia'),
('B0009.000077', 'B0009', 'BB00014', '2019-01-04', 'Tersedia'),
('B0001.000078', 'B0001', 'BB00015', '2019-01-04', 'Ditempatkan'),
('B0009.000079', 'B0009', 'BB00016', '2019-01-04', 'Tersedia'),
('B0009.000080', 'B0009', 'BB00017', '2019-01-04', 'Tersedia'),
('B0009.000081', 'B0009', 'BB00017', '2019-01-04', 'Tersedia'),
('B0009.000082', 'B0009', 'BB00018', '2019-01-04', 'Tersedia'),
('B0004.000083', 'B0004', 'BB00018', '2019-01-04', 'Tersedia'),
('B0002.000084', 'B0002', 'BB00019', '2019-01-04', 'Tersedia'),
('B0010.000085', 'B0010', 'BB00020', '2019-01-04', 'Tersedia'),
('B0008.000086', 'B0008', 'BB00021', '2019-01-04', 'Tersedia'),
('B0001.000087', 'B0001', 'BB00022', '2019-01-05', 'Tersedia'),
('B0009.000088', 'B0009', 'BB00023', '2019-02-18', 'Tersedia'),
('B0009.000089', 'B0009', 'BB00023', '2019-02-18', 'Tersedia'),
('B0009.000090', 'B0009', 'BB00023', '2019-02-18', 'Tersedia'),
('B0002.000091', 'B0002', 'BB00023', '2019-02-18', 'Tersedia'),
('B0002.000092', 'B0002', 'BB00023', '2019-02-18', 'Ditempatkan'),
('B0002.000093', 'B0002', 'BB00023', '2019-02-18', 'Tersedia'),
('B0002.000094', 'B0002', 'BB00023', '2019-02-18', 'Dipinjam'),
('B0002.000095', 'B0002', 'BB00023', '2019-02-18', 'Ditempatkan'),
('B0002.000096', 'B0002', 'BB00023', '2019-02-18', 'Tersedia'),
('B0002.000097', 'B0002', 'BB00023', '2019-02-18', 'Tersedia'),
('B0004.000098', 'B0004', 'BB00023', '2019-02-18', 'Tersedia'),
('B0004.000099', 'B0004', 'BB00023', '2019-02-18', 'Tersedia'),
('B0004.000100', 'B0004', 'BB00023', '2019-02-18', 'Tersedia'),
('B0004.000101', 'B0004', 'BB00023', '2019-02-18', 'Tersedia'),
('B0004.000102', 'B0004', 'BB00023', '2019-02-18', 'Tersedia'),
('B0004.000103', 'B0004', 'BB00023', '2019-02-18', 'Tersedia'),
('B0004.000104', 'B0004', 'BB00023', '2019-02-18', 'Tersedia'),
('B0009.000000', 'B0009', 'BB00000', '2023-08-21', 'Tersedia'),
('B0011.000107', 'B0011', 'BB00024', '2023-09-11', 'Tersedia'),
('B0011.000106', 'B0011', 'BB00024', '2023-09-11', 'Tersedia'),
('B0011.000105', 'B0011', 'BB00024', '2023-09-11', 'Dipinjam'),
('B0009.000108', 'B0009', 'BB00025', '2023-09-11', 'Tersedia'),
('B0008.000109', 'B0008', 'BB00026', '2023-09-11', 'Tersedia'),
('B0010.000110', 'B0010', 'BB00027', '2023-09-11', 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `kd_departemen` char(4) NOT NULL,
  `nm_departemen` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`kd_departemen`, `nm_departemen`, `keterangan`) VALUES
('D001', 'Prodi TI', 'Teknik Informatika'),
('D002', 'Prodi SI', 'Sistem Informasi'),
('D003', 'Prodi MI', 'Manajemen Informatika'),
('D004', 'Prodi KA', 'Komputer Akuntansi'),
('D005', 'Prodi TK', 'Teknik Komputer'),
('D006', 'Pengajaran', 'Pengajaran'),
('D007', 'Perpustakaan', 'Perpustakaan'),
('D008', 'Ruang Kelas - Gedung S', 'Ruang Kelas Gedung Selatan'),
('D009', 'Ruang Kelas - Gedung U', 'Ruang Kelas Gedung Utara');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kd_kategori` char(4) NOT NULL,
  `nm_kategori` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kd_kategori`, `nm_kategori`) VALUES
('K001', 'Komputer'),
('K002', 'Laptop'),
('K003', 'Printer'),
('K004', 'UPS Power Suply'),
('K005', 'Meja Komputer'),
('K006', 'Monitor'),
('K007', 'Kabel lan');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `kd_lokasi` char(5) NOT NULL,
  `nm_lokasi` varchar(100) NOT NULL,
  `kd_departemen` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`kd_lokasi`, `nm_lokasi`, `kd_departemen`) VALUES
('L0001', 'Kepala Prodi TI', 'D001'),
('L0002', 'Ruang Dosen TI', 'D001'),
('L0003', 'Kepala Prodi SI', 'D002'),
('L0004', 'Ruang Dosen SI', 'D002'),
('L0005', 'Kepala Prodi MI', 'D003'),
('L0006', 'Ruang Dosen MI', 'D003'),
('L0007', 'Kepala Prodi KA', 'D004'),
('L0008', 'Ruang Dosen KA', 'D004'),
('L0009', 'Kepala Prodi TK', 'D005'),
('L0010', 'Ruang Dosen TK', 'D005'),
('L0011', 'Kepala Pengajaran', 'D006'),
('L0012', 'Ruang Pengajaran', 'D006'),
('L0013', 'Kepala Perpustakaan', 'D007'),
('L0014', 'Ruang Perpustakaan', 'D007'),
('L0015', 'Kelas S.1.1', 'D008');

-- --------------------------------------------------------

--
-- Table structure for table `mutasi`
--

CREATE TABLE `mutasi` (
  `no_mutasi` char(7) NOT NULL,
  `tgl_mutasi` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mutasi`
--

INSERT INTO `mutasi` (`no_mutasi`, `tgl_mutasi`, `keterangan`, `kd_petugas`) VALUES
('MB00001', '2015-08-06', 'Mutasi karena Tidak terpakai', 'P001'),
('MB00002', '2017-03-21', 'aa', 'P001'),
('MB00003', '2017-08-02', 'Nobis aliter videtur, recte secusne, postea; Qualem igitur hominem natura inchoavit', 'P001'),
('MB00004', '2018-12-30', 'aaaaa', 'P001'),
('MB00005', '2019-02-18', 'Mutasi atau Pemindahan Barang,..', 'P001'),
('MB00006', '2019-02-18', 'Mutasi atau Pemindahan Barang,..', 'P001'),
('MB00007', '2019-02-18', 'sadasdasdasd', 'P001'),
('MB00000', '2023-08-22', 'test', 'P001');

-- --------------------------------------------------------

--
-- Table structure for table `mutasi_asal`
--

CREATE TABLE `mutasi_asal` (
  `id` int(4) NOT NULL,
  `no_mutasi` char(7) NOT NULL,
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mutasi_asal`
--

INSERT INTO `mutasi_asal` (`id`, `no_mutasi`, `no_penempatan`, `kd_inventaris`) VALUES
(4, 'MB00003', 'PB00012', 'B0002.000003'),
(3, 'MB00002', 'PB00013', 'B0010.000039'),
(5, 'MB00003', 'PB00015', 'B0004.000011'),
(6, 'MB00004', 'PB00010', 'B0003.000006'),
(7, 'MB00004', 'PB00011', 'B0001.000002'),
(8, 'MB00005', 'PB00018', 'B0001.000078'),
(9, 'MB00005', 'PB00019', 'B0010.000072'),
(10, 'MB00005', 'PB00018', 'B0005.000017'),
(11, 'MB00006', 'PB00017', 'B0001.000002'),
(12, 'MB00006', 'PB00013', 'B0010.000038'),
(13, 'MB00006', 'PB00020', 'B0001.000078'),
(14, 'MB00007', 'PB00021', 'B0010.000038'),
(15, 'MB00007', 'PB00021', 'B0001.000002'),
(16, 'MB00000', 'PB00022', 'B0001.000002');

-- --------------------------------------------------------

--
-- Table structure for table `mutasi_tujuan`
--

CREATE TABLE `mutasi_tujuan` (
  `no_mutasi` char(7) NOT NULL,
  `no_penempatan` char(7) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mutasi_tujuan`
--

INSERT INTO `mutasi_tujuan` (`no_mutasi`, `no_penempatan`, `keterangan`) VALUES
('MB00002', 'PB00014', 'asdasdasd'),
('MB00003', 'PB00016', 'Terram, mihi crede, ea lanx et maria deprimet. Neutrum vero, inquit ille.'),
('MB00004', 'PB00017', 'asdasdasd'),
('MB00005', 'PB00020', 'Penempatan baru disini...'),
('MB00006', 'PB00021', 'Penempatan baru disini...'),
('MB00007', 'PB00022', 'asdasdasd'),
('MB00000', 'PB00000', 'pemindahan barang');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `kd_pegawai` char(5) NOT NULL,
  `nm_pegawai` varchar(100) NOT NULL,
  `jns_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`kd_pegawai`, `nm_pegawai`, `jns_kelamin`, `alamat`, `no_telepon`) VALUES
('P0001', 'Juwanto', 'Laki-laki', 'Jl. Manggarawan, 130, Labuhan Ratu 7', '081911818188'),
('P0002', 'Riswantoro', 'Laki-laki', 'Jl. Suhada, Way Jepara, Lampung Timur', '021511881818'),
('P0003', 'Sardi Sudrajad', 'Laki-laki', 'Jl. Margahayu 120, Labuhan Ratu baru, Way Jepara', '081921341111'),
('P0004', 'Atika Lusiana', 'Perempuan', 'Jl. Margahayu 120, Labuhan Ratu baru, Way Jepara', '08192223333'),
('P0005', 'Septi Susanti', 'Perempuan', 'Jl. Maguwo, Yogyakarta', '0819223345'),
('P0006', 'Umi Rahayu', 'Perempuan', 'Jl. Way Jepara, Lampung Timur', '081911118181');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `no_peminjaman` char(7) NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `tgl_akan_kembali` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `kd_pegawai` char(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status_kembali` enum('Pinjam','Kembali') NOT NULL DEFAULT 'Pinjam',
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`no_peminjaman`, `tgl_peminjaman`, `tgl_akan_kembali`, `tgl_kembali`, `kd_pegawai`, `keterangan`, `status_kembali`, `kd_petugas`) VALUES
('PJ00001', '2016-07-28', '2016-07-28', '0000-00-00', 'P0001', '', 'Pinjam', 'P001'),
('PJ00002', '2017-03-21', '2017-03-21', '0000-00-00', 'P0001', 'sdfsdfsdf', 'Pinjam', 'P001'),
('PJ00003', '2017-05-14', '2017-05-14', '0000-00-00', 'P0001', 'adsadasd', 'Pinjam', 'P001'),
('PJ00004', '2017-05-14', '2017-05-14', '0000-00-00', 'P0001', 'adsadasd', 'Pinjam', 'P001'),
('PJ00005', '2017-08-02', '2017-08-02', '0000-00-00', 'P0003', 'Terram, mihi crede, ea lanx et maria deprimet. Neutrum vero, inquit ille.', 'Pinjam', 'P001'),
('PJ00006', '2019-02-18', '2019-02-18', '0000-00-00', 'P0004', 'Peminjaman oleh Pegawai,..', 'Pinjam', 'P001'),
('PJ00000', '2023-08-22', '2023-08-22', '0000-00-00', 'P0001', 'meminjam', 'Pinjam', 'P001'),
('PJ00007', '2023-09-11', '2023-09-11', '0000-00-00', 'P0001', 'Tambah barang', 'Pinjam', 'P001');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_item`
--

CREATE TABLE `peminjaman_item` (
  `no_peminjaman` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peminjaman_item`
--

INSERT INTO `peminjaman_item` (`no_peminjaman`, `kd_inventaris`) VALUES
('PJ00002', 'B0011.000046'),
('PJ00002', 'B0009.000034'),
('PJ00003', 'B0002.000005'),
('PJ00004', 'B0004.000008'),
('PJ00005', 'B0008.000031'),
('PJ00005', 'B0006.000019'),
('PJ00006', 'B0007.000020'),
('PJ00006', 'B0010.000070'),
('PJ00006', 'B0002.000094'),
('PJ00000', 'B0004.000010'),
('PJ00007', 'B0011.000105');

-- --------------------------------------------------------

--
-- Table structure for table `penempatan`
--

CREATE TABLE `penempatan` (
  `no_penempatan` char(7) NOT NULL,
  `tgl_penempatan` date NOT NULL,
  `kd_lokasi` char(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `jenis` enum('Baru','Mutasi') NOT NULL DEFAULT 'Baru',
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penempatan`
--

INSERT INTO `penempatan` (`no_penempatan`, `tgl_penempatan`, `kd_lokasi`, `keterangan`, `jenis`, `kd_petugas`) VALUES
('PB00001', '2015-07-24', 'L0001', 'Untuk operasional Kepala Propdi TI', 'Baru', 'P001'),
('PB00002', '2015-07-27', 'L0002', 'Untuk operasional Dosen Propdi TI', 'Baru', 'P001'),
('PB00003', '2015-07-29', 'L0003', 'Untuk operasional Propdi SI', 'Baru', 'P001'),
('PB00004', '2015-08-06', 'L0004', 'Untuk operasional Dosen Prodi SI', 'Baru', 'P001'),
('PB00005', '2015-08-06', 'L0005', 'Untuk operasional Kepala Prodi MI', 'Baru', 'P001'),
('PB00006', '2015-08-06', 'L0006', 'Untuk Operasional Dosen Prodi MI', 'Baru', 'P001'),
('PB00007', '2015-08-06', 'L0007', 'Untuk Operasional Kepala Prodi KA', 'Baru', 'P001'),
('PB00008', '2015-08-06', 'L0008', 'Untuk Operasional Dosen Prodi KA', 'Baru', 'P001'),
('PB00009', '2015-08-06', 'L0010', 'Pemindahan barang', 'Mutasi', 'P001'),
('PB00010', '2016-07-28', 'L0001', 'Penempatan', 'Baru', 'P001'),
('PB00011', '2016-07-28', 'L0001', 'Penempatan', 'Baru', 'P001'),
('PB00012', '2016-07-28', 'L0001', 'Penempatan', 'Baru', 'P001'),
('PB00014', '2017-03-21', 'L0002', 'asdasdasd', 'Mutasi', 'P001'),
('PB00013', '2017-03-21', 'L0014', 'adsadasd', 'Baru', 'P001'),
('PB00015', '2017-08-02', 'L0001', 'Nobis aliter videtur, recte secusne, postea; Qualem igitur hominem natura inchoavit', 'Baru', 'P001'),
('PB00016', '2017-08-02', 'L0007', 'Terram, mihi crede, ea lanx et maria deprimet. Neutrum vero, inquit ille.', 'Mutasi', 'P001'),
('PB00017', '2018-12-30', 'L0001', 'asdasdasd', 'Mutasi', 'P001'),
('PB00018', '2019-02-18', 'L0001', 'Penempatan Terbaru 2019', 'Baru', 'P001'),
('PB00019', '2019-02-18', 'L0001', 'Penempatan Terbaru 2019', 'Baru', 'P001'),
('PB00020', '2019-02-18', 'L0001', 'Penempatan baru disini...', 'Mutasi', 'P001'),
('PB00021', '2019-02-18', 'L0001', 'Penempatan baru disini...', 'Mutasi', 'P001'),
('PB00022', '2019-02-18', 'L0001', 'asdasdasd', 'Mutasi', 'P001'),
('PB00000', '2023-08-22', 'L0001', 'pemindahan barang', 'Mutasi', 'P001');

-- --------------------------------------------------------

--
-- Table structure for table `penempatan_item`
--

CREATE TABLE `penempatan_item` (
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `status_aktif` enum('Yes','No') NOT NULL DEFAULT 'Yes'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penempatan_item`
--

INSERT INTO `penempatan_item` (`no_penempatan`, `kd_inventaris`, `status_aktif`) VALUES
('PB00010', 'B0003.000006', 'No'),
('PB00010', 'B0003.000007', 'No'),
('PB00011', 'B0001.000002', 'No'),
('PB00011', 'B0001.000001', 'No'),
('PB00012', 'B0002.000004', 'Yes'),
('PB00012', 'B0002.000003', 'No'),
('PB00015', 'B0005.000014', 'Yes'),
('PB00014', 'B0010.000039', 'Yes'),
('PB00013', 'B0010.000038', 'No'),
('PB00013', 'B0010.000039', 'No'),
('PB00015', 'B0004.000011', 'No'),
('PB00016', 'B0002.000003', 'Yes'),
('PB00016', 'B0004.000011', 'Yes'),
('PB00017', 'B0003.000006', 'Yes'),
('PB00017', 'B0001.000002', 'No'),
('PB00018', 'B0001.000078', 'No'),
('PB00018', 'B0004.000009', 'Yes'),
('PB00018', 'B0002.000095', 'Yes'),
('PB00018', 'B0005.000017', 'No'),
('PB00019', 'B0011.000043', 'Yes'),
('PB00019', 'B0010.000072', 'No'),
('PB00019', 'B0008.000028', 'Yes'),
('PB00019', 'B0002.000092', 'Yes'),
('PB00020', 'B0001.000078', 'No'),
('PB00020', 'B0010.000072', 'Yes'),
('PB00020', 'B0005.000017', 'Yes'),
('PB00021', 'B0001.000002', 'No'),
('PB00021', 'B0010.000038', 'No'),
('PB00021', 'B0001.000078', 'Yes'),
('PB00022', 'B0010.000038', 'Yes'),
('PB00022', 'B0001.000002', 'No'),
('PB00000', 'B0001.000002', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `pengadaan`
--

CREATE TABLE `pengadaan` (
  `no_pengadaan` char(7) NOT NULL,
  `tgl_pengadaan` date NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `jenis_pengadaan` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengadaan`
--

INSERT INTO `pengadaan` (`no_pengadaan`, `tgl_pengadaan`, `kd_supplier`, `jenis_pengadaan`, `keterangan`, `kd_petugas`, `foto`) VALUES
('BB00001', '2015-06-04', 'S001', 'Pembelian', 'Pembelian dari Khas Kantor', 'P001', ''),
('BB00002', '2015-07-07', 'S002', 'Pembelian', 'Pengadaan dari uang Kas', 'P001', ''),
('BB00003', '2015-07-22', 'S002', 'Sumbangan', 'Sumbangan Uang dari Pemda', 'P001', ''),
('BB00004', '2015-08-06', 'S002', 'Pembelian', 'Pembelian dari Kas Kantor', 'P001', ''),
('BB00005', '2015-08-06', 'S004', 'Pembelian', 'Pembelian dari Kas Kantor', 'P001', ''),
('BB00006', '2015-08-06', 'S001', 'Pembelian', 'Pembelian dari Kas Kantor', 'P001', ''),
('BB00007', '2016-07-28', 'S001', 'Pembelian', 'pembelian', 'P001', ''),
('BB00008', '2016-07-28', 'S001', 'Pembelian', 'pembelian', 'P001', ''),
('BB00011', '2017-03-21', 'S002', 'Pembelian', 'qweqwe', 'P001', ''),
('BB00010', '2016-10-24', 'S003', 'Hibah', 'dssdfsdf', 'P001', ''),
('BB00012', '2017-08-02', 'S001', 'Pembelian', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'P001', ''),
('BB00013', '2019-01-04', 'S001', 'Sumbangan', 'Tidak ada catatan,...', 'P001', ''),
('BB00014', '2019-01-04', 'S002', 'Pembelian', 'aaaa', 'P001', ''),
('BB00015', '2019-01-04', 'S002', 'Sumbangan', 'aaa', 'P001', ''),
('BB00016', '2019-01-04', 'S001', 'Sumbangan', 'aaaaa', 'P001', ''),
('BB00017', '2019-01-04', 'S001', 'Pembelian', 'erterte', 'P001', ''),
('BB00018', '2019-01-04', 'S001', 'Pembelian', '', 'P001', ''),
('BB00019', '2019-01-04', 'S001', 'Sumbangan', 'catatan', 'P001', '0Jellyfish.jpg'),
('BB00020', '2019-01-04', 'S002', 'Wakaf', 'adasda', 'P001', ''),
('BB00021', '2019-01-04', 'S002', 'Sumbangan', 'dfsdfsdf', 'P001', 'file0Penguins.jpg'),
('BB00022', '2019-01-05', 'S003', 'Pembelian', 'vcxcvxcvxcv', 'P001', 'file0frame.png'),
('BB00023', '2019-02-18', 'S001', 'Pembelian', 'Pengadaan barang,..', 'P001', 'file0bukti_pilkada.jpg'),
('BB00000', '2023-08-21', 'S001', 'Pembelian', 'Pembelian 1 set komputer', 'P001', 'file01685341415-1685341414064.jpeg'),
('BB00024', '2023-09-11', 'S001', 'Pembelian', 'Tambah barang', 'P001', 'file0CAPTURE.JPG'),
('BB00025', '2023-09-11', 'S006', 'Pembelian', 'pembelian baru', 'P001', 'file0WhatsApp Image 2023-08-29 at 16.17.41.jpeg'),
('BB00026', '2023-09-11', 'S004', 'Pembelian', 'pembelian meja komputer', 'P001', 'file0WhatsApp Image 2023-08-29 at 16.17.41.jpeg'),
('BB00027', '2023-09-11', 'S001', 'Pembelian', 'Pembelian 1 set komputer', 'P001', 'file0WhatsApp Image 2023-08-29 at 16.17.41.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `pengadaan_item`
--

CREATE TABLE `pengadaan_item` (
  `no_pengadaan` char(7) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `jumlah` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengadaan_item`
--

INSERT INTO `pengadaan_item` (`no_pengadaan`, `kd_barang`, `deskripsi`, `harga_beli`, `jumlah`) VALUES
('BB00001', 'B0010', 'Komputer Rakitan Core 2 Duwo CPU Komplit', 3200000, 2),
('BB00001', 'B0009', 'Komputer Rakitan Dual Core CPU Komplit', 3000000, 4),
('BB00002', 'B0001', 'Toshiba Satellite C800D-1003 Black', 7300000, 2),
('BB00002', 'B0002', 'Toshiba Satelite C40-A106 Black baru', 5800000, 3),
('BB00003', 'B0004', 'Printer Canon IP 2770', 470000, 6),
('BB00003', 'B0005', 'Printer Brother Colour Laser HL-2150N Mono', 1200000, 4),
('BB00003', 'B0003', 'Printer Canon LBP 5100 Laser Jet', 1350000, 2),
('BB00004', 'B0006', 'UPS Prolink Pro 700', 450000, 2),
('BB00004', 'B0007', 'UPS Prolink IPS 500i Inverter 500VA', 680000, 7),
('BB00005', 'B0008', 'Meja Komputer Crystal Grace 101', 270000, 7),
('BB00006', 'B0011', 'LCD LG 19 Inch', 1250000, 7),
('BB00007', 'B0009', 'Beli komputer lagi', 3500000, 5),
('BB00008', 'B0010', 'Pembelian lagi', 2500000, 3),
('BB00011', 'B0010', 'sdfsdfsd', 5000000, 2),
('BB00010', 'B0006', 'sdfsdf', 750000, 1),
('BB00010', 'B0010', 'sdfsdf', 4500000, 4),
('BB00011', 'B0009', 'werwer', 5600000, 1),
('BB00012', 'B0007', 'Huius, Lyco, oratione locuples, rebus ipsis ielunior. At, si voluptas esset bonum, desideraret. Quam', 560000, 3),
('BB00012', 'B0010', 'Nobis aliter videtur, recte secusne, postea; Qualem igitur hominem natura inchoavit', 4500000, 8),
('BB00013', 'B0007', 'aaa', 25000, 1),
('BB00013', 'B0006', 'bbbb', 45000, 1),
('BB00014', 'B0009', 'bbbb', 47000, 1),
('BB00015', 'B0001', 'ggggg', 78000, 1),
('BB00016', 'B0009', 'sadasd', 25000, 1),
('BB00017', 'B0009', 'bbbb', 34000, 1),
('BB00017', 'B0009', 'bbbb', 34000, 1),
('BB00018', 'B0009', 'bbbb', 45000, 1),
('BB00018', 'B0004', 'ggggg', 670000, 1),
('BB00019', 'B0002', 'asdasd', 67000, 1),
('BB00020', 'B0010', 'asdasd', 45645, 1),
('BB00021', 'B0008', 'sdfsdf', 25000, 1),
('BB00022', 'B0001', 's ad a dasd as', 6900000, 1),
('BB00023', 'B0009', 'Komputer Core 2 Duo', 4500000, 3),
('BB00023', 'B0002', 'Toshiba Baru Keluar Kandang', 7200000, 7),
('BB00023', 'B0004', 'Printer Tercepat 2019', 1200000, 7),
('BB00000', 'B0009', 'PC 1 Set Lengkap', 1000000, 1),
('BB00024', 'B0011', 'Barang', 500000, 3),
('BB00025', 'B0009', '1 set komputer', 500000, 1),
('BB00026', 'B0008', 'meja komputer', 2000000, 1),
('BB00027', 'B0010', '1 set komputer', 100000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `no_pengembalian` char(7) NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `no_peminjaman` char(7) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `kd_petugas` char(4) NOT NULL,
  `nm_petugas` varchar(100) NOT NULL,
  `no_telepon` int(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'Kasir'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`kd_petugas`, `nm_petugas`, `no_telepon`, `username`, `password`, `foto`, `level`) VALUES
('P001', 'Administrator', 2147483647, 'admin', '21232f297a57a5a743894a0e4a801fc3', '20171019094245-avatar.png', 'Admin'),
('P002', 'Fitria Prasetya', 2147483647, 'kasir', 'c7911af3adbd12a035b289556d96470a', '', 'Petugas'),
('P003', 'Fitria Prasetiawatia', 2147483647, 'fitria', 'ef208a5dfcfc3ea9941d7a6c43841784', '', 'Petugas'),
('P004', 'Nama Petugas', 2147483647, 'petugas', '21232f297a57a5a743894a0e4a801fc3', '', 'Petugas'),
('P005', 'ridwan', 123, 'ridwan', '202cb962ac59075b964b07152d234b70', '', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `kd_supplier` char(4) NOT NULL,
  `nm_supplier` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`kd_supplier`, `nm_supplier`, `alamat`, `no_telepon`) VALUES
('S001', 'ELS Computer', 'Jl. Adisucipto, Yogyakarta', '02741111111'),
('S002', 'ALNECT Computer', 'Jl. Janti, Jembatan Layang, Yogyakarta', '08191010101'),
('S003', 'MAKRO Gudang Rabat', 'Jl. Maguwo Yogyakarta', '081912121212'),
('S004', 'Gondang Jaya Mebel', 'Jl. Adisucipto, Yogyakarta', '027412121212'),
('S005', 'PROGO Toserba', 'Jl. Malioboro, Yogyakarta', '0819111199911'),
('S006', 'Ridwan Chel', 'bekasi', '0898738333');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_mutasi`
--

CREATE TABLE `tmp_mutasi` (
  `id` int(4) NOT NULL,
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_peminjaman`
--

CREATE TABLE `tmp_peminjaman` (
  `id` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penempatan`
--

CREATE TABLE `tmp_penempatan` (
  `id` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_pengadaan`
--

CREATE TABLE `tmp_pengadaan` (
  `id` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `satuan` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kd_barang`),
  ADD UNIQUE KEY `kd_buku` (`kd_barang`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`kd_departemen`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kd_kategori`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`kd_lokasi`);

--
-- Indexes for table `mutasi`
--
ALTER TABLE `mutasi`
  ADD PRIMARY KEY (`no_mutasi`);

--
-- Indexes for table `mutasi_asal`
--
ALTER TABLE `mutasi_asal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`kd_pegawai`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`no_peminjaman`);

--
-- Indexes for table `penempatan`
--
ALTER TABLE `penempatan`
  ADD PRIMARY KEY (`no_penempatan`);

--
-- Indexes for table `pengadaan`
--
ALTER TABLE `pengadaan`
  ADD PRIMARY KEY (`no_pengadaan`);

--
-- Indexes for table `pengadaan_item`
--
ALTER TABLE `pengadaan_item`
  ADD KEY `nomor_penjualan_tamu` (`no_pengadaan`,`kd_barang`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`no_pengembalian`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`kd_petugas`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`kd_supplier`);

--
-- Indexes for table `tmp_mutasi`
--
ALTER TABLE `tmp_mutasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_peminjaman`
--
ALTER TABLE `tmp_peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_penempatan`
--
ALTER TABLE `tmp_penempatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_pengadaan`
--
ALTER TABLE `tmp_pengadaan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mutasi_asal`
--
ALTER TABLE `mutasi_asal`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tmp_mutasi`
--
ALTER TABLE `tmp_mutasi`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tmp_peminjaman`
--
ALTER TABLE `tmp_peminjaman`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tmp_penempatan`
--
ALTER TABLE `tmp_penempatan`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tmp_pengadaan`
--
ALTER TABLE `tmp_pengadaan`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
