-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: asset
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `approval`
--

DROP TABLE IF EXISTS `approval`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `approval` (
  `no_approval` char(7) NOT NULL,
  `tgl_approval` date NOT NULL,
  `no_pengadaan` char(7) NOT NULL,
  PRIMARY KEY (`no_approval`),
  KEY `foreign` (`no_pengadaan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approval`
--

LOCK TABLES `approval` WRITE;
/*!40000 ALTER TABLE `approval` DISABLE KEYS */;
INSERT INTO `approval` VALUES ('AP00001','2024-05-28','BB00103'),('AP00002','2024-05-28','BB00106'),('AP00003','2024-05-28','BB00105'),('AP00004','2024-05-28','BB00104'),('AP00005','2024-05-28','BB00102'),('AP00006','2024-05-28','BB00107'),('AP00007','2024-06-03','BB00113'),('AP00008','2024-06-03','BB00112'),('AP00009','2024-06-03','BB00111'),('AP00010','2024-06-03','BB00110'),('AP00011','2024-06-03','BB00109'),('AP00012','2024-06-03','BB00108'),('AP00013','2024-06-11','BB00121'),('AP00014','2024-06-11','BB00120'),('AP00015','2024-06-11','BB00119'),('AP00016','2024-06-11','BB00118'),('AP00017','2024-06-11','BB00117'),('AP00018','2024-06-11','BB00116'),('AP00019','2024-06-11','BB00115'),('AP00020','2024-06-11','BB00114'),('AP00021','2024-06-17','BB00122'),('AP00022','2024-06-23','BB00128'),('AP00023','2024-06-23','BB00127'),('AP00024','2024-06-23','BB00126'),('AP00025','2024-06-23','BB00125'),('AP00026','2024-06-23','BB00124'),('AP00027','2024-06-23','BB00123'),('AP00028','2024-06-26','BB00133'),('AP00029','2024-06-26','BB00130'),('AP00030','2024-06-26','BB00131'),('AP00031','2024-06-26','BB00129'),('AP00032','2024-06-26','BB00132'),('AP00033','2024-07-16','BB00136'),('AP00034','2024-07-16','BB00135'),('AP00035','2024-07-16','BB00134'),('AP00036','2024-07-23','BB00137'),('AP00037','2024-07-25','BB00138'),('AP00038','2024-07-30','BB00139'),('AP00039','2024-08-05','BB00140'),('AP00040','2024-08-05','BB00142'),('AP00041','2024-08-05','BB00141'),('AP00042','2024-08-12','BB00144'),('AP00043','2024-08-12','BB00143'),('AP00044','2024-08-18','BB00145'),('AP00045','2024-08-19','BB00148'),('AP00046','2024-08-19','BB00147'),('AP00047','2024-08-19','BB00146'),('AP00048','2024-08-22','BB00151'),('AP00049','2024-08-22','BB00150'),('AP00050','2024-08-22','BB00149'),('AP00051','2024-08-25','BB00156'),('AP00052','2024-08-25','BB00155'),('AP00053','2024-08-25','BB00154'),('AP00054','2024-08-25','BB00153'),('AP00055','2024-08-25','BB00152'),('AP00056','2024-09-09','BB00158'),('AP00057','2024-09-16','BB00161'),('AP00058','2024-09-16','BB00160'),('AP00059','2024-09-16','BB00159'),('AP00060','2024-09-19','BB00162'),('AP00061','2024-09-30','BB00163'),('AP00062','2024-10-01','BB00164'),('AP00063','2024-10-01','BB00165'),('AP00064','2024-10-02','BB00166'),('AP00065','2024-10-06','BB00167'),('AP00066','2024-10-17','BB00169'),('AP00067','2024-10-17','BB00168'),('AP00068','2024-10-21','BB00170'),('AP00069','2024-10-28','BB00171'),('AP00070','2024-10-28','BB00172'),('AP00071','2024-10-28','BB00173'),('AP00072','2024-10-29','BB00178'),('AP00073','2024-10-29','BB00177'),('AP00074','2024-10-29','BB00176'),('AP00075','2024-10-29','BB00175'),('AP00076','2024-10-29','BB00174'),('AP00077','2024-11-10','BB00183'),('AP00078','2024-11-10','BB00182'),('AP00079','2024-11-10','BB00181'),('AP00080','2024-11-10','BB00180'),('AP00081','2024-11-10','BB00179'),('AP00082','2024-11-18','BB00185'),('AP00083','2024-11-19','BB00186'),('AP00084','2024-11-19','BB00188'),('AP00085','2024-11-24','BB00187'),('AP00086','2024-12-03','BB00190'),('AP00087','2024-12-09','BB00192'),('AP00088','2024-12-09','BB00191'),('AP00089','2024-12-09','BB00189'),('AP00090','2024-12-11','BB00194'),('AP00091','2024-12-24','BB00195');
/*!40000 ALTER TABLE `approval` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `approval_barang_mati`
--

DROP TABLE IF EXISTS `approval_barang_mati`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `approval_barang_mati` (
  `no_approval` char(7) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tgl_approval` date NOT NULL,
  `no_barang_mati` char(7) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`no_approval`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approval_barang_mati`
--

LOCK TABLES `approval_barang_mati` WRITE;
/*!40000 ALTER TABLE `approval_barang_mati` DISABLE KEYS */;
INSERT INTO `approval_barang_mati` VALUES ('ABM0091','2024-12-23','BM00016'),('ABM0092','2024-12-24','BM00017'),('ABM0093','2024-12-24','BM00018'),('ABM0094','2024-12-24','BM00019');
/*!40000 ALTER TABLE `approval_barang_mati` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `approval_service`
--

DROP TABLE IF EXISTS `approval_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `approval_service` (
  `no_approval` char(7) NOT NULL,
  `tgl_approval` date NOT NULL,
  `no_service` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approval_service`
--

LOCK TABLES `approval_service` WRITE;
/*!40000 ALTER TABLE `approval_service` DISABLE KEYS */;
INSERT INTO `approval_service` VALUES ('AP00088','2024-12-09','SS00031'),('AP00089','2024-12-09','SS00032'),('AP00090','2024-12-09','SS00034'),('AP00090','2024-12-09','SS00033'),('AP00090','2024-12-10','SS00037'),('AP00090','2024-12-10','SS00040'),('AP00090','2024-12-10','SS00039'),('AP00090','2024-12-11','SS00041'),('AP00090','2024-12-11','SS00038'),('AP00091','2024-12-11','SS00042'),('AP00091','2024-12-11','SS00043');
/*!40000 ALTER TABLE `approval_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang` (
  `kd_barang` varchar(5) NOT NULL,
  `nm_barang` varchar(100) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `merek` varchar(100) DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `satuan` varchar(10) DEFAULT NULL,
  `kd_kategori` char(4) NOT NULL,
  `foto` text,
  PRIMARY KEY (`kd_barang`),
  KEY `foreign` (`kd_kategori`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES ('B0001','Radio Tenda B6','','',10,'Unit','K001','0'),('B0002','Acces Point Toto Link N300RT','','',0,'Unit','K003','0'),('B0003','Access point Hikvision 2 Antena ( DS-3WR3N )','','',0,'Unit','K003','0'),('B0004','Accespoint Hikvision 4 Antena ( DS-WR12C )','','',15,'Unit','K003','0'),('B0005','Access Point BOLT XL Kecil ','','',0,'Unit','K003','0'),('B0006','Access Point Cina Telecom','','',0,'Unit','K003','0'),('B0007','Access Point D-link Antena 2 ( DWR-116 )','','',0,'Unit','K003','0'),('B0008','Access Point HSAirpo ( WR200N Indoor ) ','','',0,'Unit','K003','0'),('B0009','Access Point HSAirpro 4G ( Outdoor ) ','','',0,'Unit','K003','0'),('B0010','Access Point Huawei','','',0,'Unit','K003','0'),('B0011','Access Point Huawei EchoLife lubang kecil antena 2 (HG8245A)','','',0,'Unit','K003','0'),('B0012','Access Point Huawei EchoLife(HG8245A) lubang kecil','','',0,'Unit','K003','0'),('B0013','Access Point Kuwifi ( Outdoor ) ','','',0,'Unit','K003','0'),('B0014','Access Point Mercusys Antena 2 ( MW302R Putih )','','',0,'Unit','K003','0'),('B0015','Access Point Mercusys Antena 4 ( AC10 PUTIH )','','',0,'Unit','K003','0'),('B0016','Access point ONU BDCOM','','',0,'Unit','K003','0'),('B0017','Access Point Pix-link ','','',0,'Unit','K003','0'),('B0018','Access Point Rujie AC1300 POE Celling (RG-RAP2200(E))','','',12,'Unit','K003','0'),('B0019','Access Point Rujie AC1300 POE Celling (RG-RAP2200(F))','','',12,'Unit','K003','0'),('B0020','Access Point Rujie Antena 4 ( RG-EW 1200 Pro Hitam )  ','','',26,'Unit','K003','0'),('B0021','Access Point Rujie Antena 4 ( RG-EW 1200 Putih )','','',36,'Unit','K003','0'),('B0022','Access Point Tenda ( i24 AC 1200 ) ','','',0,'Unit','K003','0'),('B0023','Access Point Tenda Antena 2 ( AP 4 ) ','','',0,'Unit','K003','0'),('B0024','Access Point Tenda Antena 2 ( N301 Putih )','','',0,'Unit','K003','0'),('B0025','Access Point Tenda Antena 3 ( F3 )','','',0,'Unit','K003','0'),('B0026','Access Point Tenda Antena 3 (N318)','','',0,'Unit','K003','0'),('B0027','Access Point Totolink A720R','','',0,'Unit','K003','0'),('B0028','Tplink Antena 2 ( TLWA801N ) ','','',0,'Unit','K003','0'),('B0029','Tplink Antena 2 ( WR844N ) ','','',0,'Unit','K003','0'),('B0030',' TP-Link Giga antena 4(EC230-G1)','','',0,'Unit','K003','0'),('B0031','Xiomi Antena 4 ( Mi4A )','','',0,'Unit','K003','0'),('B0032','XL','','',0,'Unit','K003','0'),('B0033','ZNET','','',0,'Unit','K003','0'),('B0034','ZTE','','',0,'Unit','K003','0'),('B0199','Sarung Tangan Fiber Optic','','',13,'Buah','K047','0Sarung Tangan Fiber Optic.png'),('B0036','Poe 24 V - 4 A / AC DC Adaptor  ','','',0,'Unit','K005','0'),('B0037','Sukorejo ','','',0,'Unit','K006','0'),('B0038','Eth-sp','','',0,'Unit','K002','0'),('B0039','RJ ','','',0,'Unit','K007','0'),('B0040','BOLT','','',0,'Unit','K008','0'),('B0041','BOX ODP ','','',0,'Unit','K009','0'),('B0042','Camera IPCAM Hikvision Indoor 4mp Sound  (Ds-2cd1143g2-Liu)','','',2,'Unit','K010','0'),('B0043','Hikvision Kecil','','',0,'Unit','K010','0'),('B0044','Resident ','','',0,'Unit','K010','0'),('B0045','China Mobile','','',0,'Unit','K011','0'),('B0046','Cloud Switch Series (326 24G-2S RM)','','',0,'Unit','K012','0'),('B0047','Corong Radio','','',2,'Unit','K013','0'),('B0048','ONU Huawei','','',0,'Unit','K014','0'),('B0049','ONU YOTC ','','',0,'Unit','K014','0'),('B0050','Yotc Access Point M8-401OPX','','',0,'Unit','K014','0'),('B0051',' Optical Switch 16 Port JYD-2G1-6E','','',0,'Unit','K015','0'),('B0052','Finger Print Solution','','',0,'Unit','K016','0'),('B0053','Finger print Hikvision ','','',0,'Unit','K016','0'),('B0054','Finger print Sport','','',0,'Unit','K016','0'),('B0055','Giga Ethernet ','','',11,'Unit','K017','0'),('B0056','Kabel Hikvision CAT6 CCA','','',32,'Meter','K018','0'),('B0057','Kipas Server','','',0,'Unit','K019','0'),('B0058','MC 100 6 PORT ( AB AB AB AB AB AB ) ','','',0,'Unit','K020','0'),('B0059','MC 100 A+B ','','',0,'Unit','K020','0'),('B0060','MC 1000 8 PORT ( 1X 2X 3X 4X 5X 6X 7X 8X ) ','','',0,'Unit','K020','0'),('B0061','MC 1000 A (TARMOC)','','',0,'Unit','K020','0'),('B0062','MC 1000 A+B ','','',0,'Unit','K020','0'),('B0063','MC 1000 B (TARMOC)','','',0,'Unit','K020','0'),('B0064','MC A 100 ( NETLINK )','','',0,'Unit','K020','0'),('B0065','MC A 100 ( TARMOC )','','',0,'Unit','K020','0'),('B0066','MC B 100 ( NETLINK )','','',0,'Unit','K020','0'),('B0067','MC FO 1000 ( OPTONE ) ','','',0,'Unit','K020','0'),('B0068','MC Netlink 1000 A','','',0,'Unit','K020','0'),('B0069','MC Netlink 1000 B ','','',0,'Unit','K020','0'),('B0070','MC SFP 1000','','',0,'Unit','K020','0'),('B0071','MC Switch Giga Fiber 8 RJ45 A','','',0,'Unit','K020','0'),('B0072','Mikrotik CAPlite ','','',0,'Unit','K021','0'),('B0073','Mikrotik Netmetal 5 Series','','',0,'Unit','K021','0'),('B0074','Mikrotik Ominitik 5 POE AC','','',0,'Unit','K021','0'),('B0075','Mikrotik RB 450 GX4','','',1,'Unit','K021','0'),('B0076','Mikrotik RB2011UiAS-RM','','',0,'Unit','K021','0'),('B0077','Mikrotik RB3011 UiAS-RM','','',0,'Unit','K021','0'),('B0078','Mikrotik RB2011 UiAS-RM','','',0,'Unit','K021','0'),('B0079','Mikrotik RB750GR2','','',0,'Unit','K021','0'),('B0080','Mikrotik RB750GR3','','',17,'Unit','K021','0'),('B0081','Mikrotik RB760IGS','','',0,'Unit','K021','0'),('B0082','Mikrotik RB941ui-2nd ','','',0,'Unit','K021','0'),('B0083','Mikrotik RB941ui-2nd-TC','','',0,'Unit','K021','0'),('B0084','Mikrotik RB951ui-2nd ','','',26,'Unit','K021','0'),('B0085','Mikrotik TPLink Broadband TL-R470T+ ','','',0,'Unit','K021','0'),('B0086','Modem Linksys ','','',0,'Unit','K004','0'),('B0087','Modem Router Orbit ( Star A1 Putih )','','',0,'Unit','K004','0'),('B0088','NanoStation AC Loco','','',0,'Unit','K022','0'),('B0089','OLT','','',0,'Unit','K023','0'),('B0197','Mobil Ferozza BG 1857 ZO','','',1,'Unit','K053','0'),('B0198','Sarung Tangan Safety ','','',13,'Buah','K047','0Sarung tangan safety.png'),('B0095','Poe Adaptor ( LG ) ','','',2,'Unit','K026','0'),('B0096','Poe Adaptor 15 v, 0,8 A','','',0,'Unit','K026','0'),('B0097','Poe Adaptor 24V 0,3A Kecil ( Hitam Tanpa Kotak )','','',0,'Unit','K026','0'),('B0098','Poe Adaptor 24V 0,3A Kecil ( Putih Tanpa Kotak )','','',0,'Unit','K026','0'),('B0099','Poe Adaptor 24V 0,5A Sedang ( Hitam Tanpa Kotak ) ','','',5,'Unit','K026','0'),('B0100','Poe Adaptor 24V 0,5A Sedang ( Putih Tanpa Kotak ) ','','',0,'Unit','K026','0'),('B0101','Poe Adaptor 24V 1A Besar (  Kotak )','','',19,'Unit','K026','0'),('B0102','Poe Adaptor 24V 1A Besar ( Hitam Tanpa Kotak ) ','','',0,'Unit','K026','0'),('B0103','Poe Adaptor 24V 1A Besar ( Putih Tanpa Kotak )','','',0,'Unit','K026','0'),('B0104','Poe Adaptor 24V 3A ( Biru ) ','','',0,'Unit','K026','0'),('B0105','Poe Adaptor 48V 0,5A Hitam ','','',0,'Unit','K026','0'),('B0106','Poe Adaptor Injektor 24V 0,5A Besar ( Hitam Tanpa Kotak ) ','','',0,'Unit','K026','0'),('B0107','Poe Adaptor Tenda 24V 0,5A Besar ( Hitam Tanpa Kotak ) ','','',0,'Unit','K026','0'),('B0108','Poe Switch 8 Port Tarmoc (TSW-108-2G-1S-120W)','','',0,'Unit','K026','0'),('B0109','Poe Tenda Petak ','','',0,'Unit','K026','0'),('B0110','Power Inverter Mitsuyama ','','',0,'Unit','K027','0'),('B0111','Power Suply Car ','','',0,'Unit','K027','0'),('B0112','Power Supply 12V 1A Jaring','','',0,'Unit','K027','0'),('B0113','Power Supply 5 A','','',0,'Unit','K027','0'),('B0114','Prolink','','',0,'Unit','K028','0'),('B0115','Protect FO Shrinkable sleeve 1.0 mm','','',0,'Unit','K029','0'),('B0116','Protect FO Shrinkable sleeve 60 mm','','',0,'Unit','K029','0'),('B0117','Radio Rocket Ac Lite','','',12,'Unit','K001','0'),('B0118','Radio Litebeam 5 AC Gen 2','','',22,'Unit','K001','0'),('B0119','Radio Powerbeam M5 ACGen2','','',8,'Unit','K001','0'),('B0120','Radio Rocket M5','','',2,'Unit','K001','0'),('B0121','Radio Rocket Prism','','',12,'Unit','K001','0'),('B0122','Radio Litebeam 5 AC LR ','','',12,'Unit','K001','0'),('B0123','Radio Tenda 09','','',3,'Unit','K001','0'),('B0124','Radio Air Fiber 5X HD','','',6,'Unit','K001','0'),('B0127','Arrester Eth-sp','','',13,'Unit','K002','0'),('B0159','Baterai UPS','','',1,'Unit','K043','0'),('B0131','Radio Powerbeam M5 (warna U nya putih )','','',1,'Unit','K001','0'),('B0132','Switch Hub Dlink 8 Port Plastik','','',0,'Unit','K035','0'),('B0133','Switch Hub Tplink 5 Port  Plastik','','',12,'Unit','K035','0'),('B0134','Radio Tenda 03','','',0,'Unit','K001','0'),('B0135','Switch Hub Dlink 5 port Plastik ','','',0,'Unit','K035','0'),('B0136','Switch D-Link 24 Port Giga (D951024C)','','',0,'Unit','K035','0'),('B0137','Radio Tenda 06','','',1,'Unit','K001','0'),('B0140','Switch Hub Tplink 8 Port Gigabit ( Plastik Hitam )','','',5,'Unit','K035','0'),('B0141','Radio Nano Station Switch','','',0,'Unit','K001','0'),('B0142','SFP FO (SFP SM - SC 1.25G)','','',0,'Unit','K031','0'),('B0145','Switch Hub Tplink 5 Port Gigabit ( Plastik Hitam )','','',5,'Unit','K035','0'),('B0146','Ups Ica','','',1,'Unit','K038','0'),('B0147','Switch Hub Tenda 8 Port Plastik','','',0,'Unit','K035','0'),('B0148','Switch Hub Tplink 5 Port Gigabit ( Besi )','','',0,'Unit','K035','0'),('B0154','Switch Hub Tplink 8 Port Plastik Putih ','','',12,'Unit','K035','0'),('B0155','Mijia Walkie Talkie XMDJJL01','','',4,'Unit','K041','0'),('B0156','Fusion Splicer AI6 ','','',2,'Unit','K042','0'),('B0157','Switch Aruba Instan On Seri 1930 8G 2SFP - JL680A','','',1,'Unit','K035','0'),('B0158','Disc Fusion 30dbi','','',3,'Unit','K001','0'),('B0160','Brother Printer Label PT M95','','',2,'Unit','K044','0'),('B0161','Mikrotik RBSXT Lte Kit (RBSXT&R11e-LTE)','','',1,'Unit','K021','0'),('B0162','Kabel Fiber Optik 1000 M','','',1,'Meter','K018','0'),('B0163','Lap Gps Litebeam AC','','',1,'Unit','K021','0'),('B0164','Media Converter FO HTBGS-03 1000Mbps A+B','','',6,'Unit','K045','0'),('B0165','Tali Tambang 12mm','','',1,'Meter','K046','0'),('B0166','Body Harnes Kotak Biru','','',1,'Unit','K047','0'),('B0167','Kabel FO 1000 M 4 Core','','',1,'Meter','K018','0'),('B0168','Fast Connector SC UPS Bukan Buaya','','',160,'Unit','K048','0'),('B0169','Tang Potong ','','',1,'Unit','K049','0'),('B0170','Connector Barel Sambungan FO Fiber Optic SC UPC Fast','','',30,'Unit','K048','0'),('B0171','Kabel FO 75 Meter Dropcore 1 Core 3 Seling','','',1,'Meter','K018','0'),('B0172','ODP Mini 4 Core Splitter 1:4 SC UPC','','',2,'Unit','K033','0'),('B0173','ODP Mini 8 Core Splitter 1:8 SC UPC','','',7,'Unit','K033','0'),('B0174','Tool Kit FO Set Lengkap','','',1,'Unit','K052','0'),('B0175','Totolink S808 Switch 8 Port (Versi 3.0)','','',10,'Unit','K035','0'),('B0176','Adaptor 12V 1A','','',10,'Unit','K005','0'),('B0177','Adaptor 12V 2A','','',5,'Unit','K005','0'),('B0178','Kabel FO 2 Core 3 Seling 1000 Meter','','',1,'Meter','K018','0'),('B0179','Kabel LAN FTP Outdoor CAT 6 Hitam','','',1,'Meter','K018','0'),('B0180','Modem ONU EPON GPON XPON HG-8310M','','',13,'Unit','K004','0'),('B0181','Splitter FO 1:4 SC/UPC','','',4,'Meter','K018','0'),('B0182','ODP Mini 16 Core Splitter Box ','','',3,'Unit','K033','0'),('B0183','Double Tape Bening ','','',11,'Unit','K051','0'),('B0184','Patch Cord SC-SC UPC Single Mode Simplex 1 Meter','','',8,'Meter','K018','0'),('B0185','Modem ONT XPON H1S-3 + Adaptor','','',32,'Unit','K004','0'),('B0186','Splitter FO 1:2 SC/UPC','','',2,'Meter','K018','0'),('B0187','Router Totolink N200re V4','','',15,'Unit','K050','0'),('B0188','Splitter FO 1:8 SC/UPC','','',4,'Meter','K018','0'),('B0189','Kabel FO 1 Core 3 Seling 1000 Meter','','',4,'Meter','K018','0'),('B0190','Kabel Ties Label','','',1,'Unit','K018','0'),('B0191','Rocket AC Lite ( R5AC-LITE )','','',0,'Unit','K001','0Rocket AC LITE.png'),('B0192','Rocket ac lite','','',2,'Unit','K001','0'),('B0195','Optical Power Meter (OPM) ','','',0,'Unit','K052','0'),('B0193','TP Link','','',0,'Unit','K004','0'),('B0194','Mobil Taruna BG 1723 IF','','',4,'Unit','K053','0'),('B0200','OTDR Optical Time Domain Reflectometer','','',1,'Unit','K052','0OTDR.png'),('B0201','Tas Laptop','','',1,'Unit','K054','0'),('B0202','Aki Kering Xtra 60','','',2,'Unit','K054','0Aki kering xtra 60.png'),('B0203','Aki Genset ','','',1,'Buah','K054','0'),('B0204','Oli Mesin Genset','','',1,'Botol','K054','0'),('B0205','Busi BP5ES','','',1,'Unit','K054','0'),('B0206','Kunci Busi','','',1,'Unit','K054','0'),('B0207','Cairan vitamin aki repair','','',1,'Botol','K054','0'),('B0208','BNC','','',16,'Buah','K010','0'),('B0209','DC','','',10,'Buah','K010','0'),('B0210','Kabel RG59 ','','',100,'Meter','K010','0'),('B0211','Mobil Terios B 2585 KRE','','',0,'Unit','K053','0'),('B0212','Karpet Lantai Mobil','','',1,'Unit','K053','0'),('B0213','Dompet STNK','','',2,'Buah','K053','0'),('B0214','Pompa Sprayer Farmjet','','',1,'Botol','K053','0'),('B0215','Talang Air Mobil','','',1,'Unit','K053','0'),('B0216','Sarung Jok Mobil','','',1,'Lembar','K053','0'),('B0217','Towing Bumper','','',1,'Unit','K053','0'),('B0218','Ban Achilles','','',2,'Unit','K053','0WhatsApp Image 2024-07-16 at 10.22.55.jpeg'),('B0219','Tangga teleskopik 44 Meter','','',1,'Unit','K054','0Tangga.png'),('B0220','Optical Power Meter OPM 4 in 1 MC70 Rechargeable Battery','','',1,'Unit','K052','0opm baterai.png'),('B0221','Sarung Stir Mobil','','',1,'Unit','K053','0'),('B0222','Paking Karburator','','',0,'Unit','K053','0'),('B0223','Per Gas','','',0,'Unit','K053','0'),('B0224','Adaptor 5 V 2 A atau MC','','',10,'Unit','K005','0'),('B0225','Adaptor 12 V 3 A','','',1,'Unit','K005','0'),('B0226','Cleaver Pemotong Core FO ','','',6,'Unit','K052','0'),('B0227','Tali Kopling','','',1,'Unit','K053','0'),('B0228','Kampas Kopling','','',1,'Unit','K053','0'),('B0229','Jasa Service Bongkar Pasang ','','',1,'Unit','K053','0'),('B0230','Media Converter HTB 100 AB ','','',16,'Unit','K045','0'),('B0231','Tang Stripper Optic Alat Kupas Core','','',2,'Unit','K052','0'),('B0233','Media Converter HTB 100 AB ( Sepasang )','','',3,'Unit','K020','0'),('B0232','Huawei HG8120C/HG8321R ONT','','',0,'Botol','K004','push-bike.jpg;logo.png'),('B0234','Media Converter HTB 100 AB ( Gandeng )','','',0,'Unit','K020','0'),('B0235','Media Converter HTB 1000 AB ( Gandeng )','','',2,'Unit','K020','0'),('B0236','Adapter FO','','',25,'Unit','K052','0'),('B0237','Barrel LAN','','',27,'Unit','K007','0'),('B0238','Adaptor LG','','',1,'Unit','K005','HOMEPAGE.jpg'),('B0239','ZTE F460 V9',NULL,NULL,0,'Unit','K004','0'),('B0240','tes',NULL,NULL,0,'Unit','K005','0'),('B0241','coba',NULL,NULL,0,'Botol','K005','0'),('B0242','radio',NULL,NULL,0,'Unit','K001','0');
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_inventaris`
--

DROP TABLE IF EXISTS `barang_inventaris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang_inventaris` (
  `kd_inventaris` char(12) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `no_pengadaan` char(7) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `status_barang` enum('Tersedia','Ditempatkan','Dipinjam') NOT NULL,
  `serial_number` varchar(50) DEFAULT NULL,
  `status_aktif` varchar(5) DEFAULT 'Yes',
  PRIMARY KEY (`kd_inventaris`),
  KEY `foreign` (`kd_barang`,`no_pengadaan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_inventaris`
--

LOCK TABLES `barang_inventaris` WRITE;
/*!40000 ALTER TABLE `barang_inventaris` DISABLE KEYS */;
INSERT INTO `barang_inventaris` VALUES ('B0001.000001','B0001','BB00001','2024-04-05','Tersedia',NULL,'Yes'),('B0001.000002','B0001','BB00001','2024-04-05','Tersedia',NULL,'Yes'),('B0001.000003','B0001','BB00001','2024-04-05','Tersedia',NULL,'Yes'),('B0001.000004','B0001','BB00001','2024-04-05','Tersedia',NULL,'Yes'),('B0001.000005','B0001','BB00001','2024-04-05','Tersedia',NULL,'Yes'),('B0001.000006','B0001','BB00001','2024-04-05','Ditempatkan',NULL,'Yes'),('B0001.000007','B0001','BB00001','2024-04-05','Tersedia',NULL,'Yes'),('B0001.000008','B0001','BB00001','2024-04-05','Tersedia',NULL,'Yes'),('B0001.000009','B0001','BB00001','2024-04-05','Tersedia',NULL,'Yes'),('B0001.000010','B0001','BB00001','2024-04-05','Tersedia',NULL,'Yes'),('B0004.000203','B0004','BB00033','2024-04-19','Tersedia',NULL,'No'),('B0004.000204','B0004','BB00033','2024-04-19','Tersedia',NULL,'Yes'),('B0004.000205','B0004','BB00033','2024-04-19','Tersedia',NULL,'Yes'),('B0004.000245','B0004','BB00052','2024-04-20','Tersedia',NULL,'Yes'),('B0004.000246','B0004','BB00052','2024-04-20','Tersedia',NULL,'Yes'),('B0004.000247','B0004','BB00052','2024-04-20','Tersedia',NULL,'Yes'),('B0004.000811','B0004','BB00140','2024-08-06','Tersedia',NULL,'Yes'),('B0004.000862','B0004','BB00153','2024-08-26','Tersedia',NULL,'Yes'),('B0004.000863','B0004','BB00153','2024-08-26','Tersedia',NULL,'No'),('B0004.000864','B0004','BB00153','2024-08-26','Tersedia',NULL,'Yes'),('B0004.000865','B0004','BB00153','2024-08-26','Tersedia',NULL,'Yes'),('B0004.000866','B0004','BB00153','2024-08-26','Tersedia',NULL,'Yes'),('B0004.000867','B0004','BB00153','2024-08-26','Tersedia',NULL,'Yes'),('B0004.000868','B0004','BB00153','2024-08-26','Tersedia',NULL,'Yes'),('B0004.000869','B0004','BB00153','2024-08-26','Tersedia',NULL,'Yes'),('B0018.000112','B0018','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0018.000113','B0018','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0018.000114','B0018','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0018.000115','B0018','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0018.000116','B0018','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0018.000117','B0018','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0019.000118','B0019','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0019.000119','B0019','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0019.000120','B0019','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0019.000121','B0019','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0019.000122','B0019','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0019.000123','B0019','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0020.000792','B0020','BB00125','2024-06-24','Tersedia',NULL,'Yes'),('B0020.000990','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.000991','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.000992','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.000993','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.000994','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.000995','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.000996','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.000997','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.000998','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.000999','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001000','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001001','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001010','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001011','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001012','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001013','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001014','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001015','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001016','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001017','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001018','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001019','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001020','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001021','B0020','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0020.001046','B0020','BB00176','2024-10-30','Tersedia',NULL,'Yes'),('B0021.000094','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000095','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000096','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000097','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000098','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000099','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000100','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000101','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000102','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000103','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000104','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000105','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000106','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000107','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000108','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000109','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000110','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000111','B0021','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000216','B0021','BB00039','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000217','B0021','BB00039','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000218','B0021','BB00039','2024-04-19','Tersedia',NULL,'Yes'),('B0021.000304','B0021','BB00081','2024-04-22','Tersedia',NULL,'Yes'),('B0021.000305','B0021','BB00081','2024-04-22','Tersedia',NULL,'Yes'),('B0021.000306','B0021','BB00081','2024-04-22','Tersedia',NULL,'Yes'),('B0021.000307','B0021','BB00082','2024-04-22','Tersedia',NULL,'Yes'),('B0021.000308','B0021','BB00082','2024-04-22','Tersedia',NULL,'Yes'),('B0021.000805','B0021','BB00137','2024-07-24','Tersedia',NULL,'Yes'),('B0021.000806','B0021','BB00137','2024-07-24','Tersedia',NULL,'Yes'),('B0021.000807','B0021','BB00137','2024-07-24','Tersedia',NULL,'Yes'),('B0021.000808','B0021','BB00137','2024-07-24','Tersedia',NULL,'Yes'),('B0021.000843','B0021','BB00147','2024-08-20','Tersedia',NULL,'Yes'),('B0021.000844','B0021','BB00147','2024-08-20','Tersedia',NULL,'Yes'),('B0021.000857','B0021','BB00155','2024-08-26','Tersedia',NULL,'Yes'),('B0021.000858','B0021','BB00155','2024-08-26','Tersedia',NULL,'Yes'),('B0021.000859','B0021','BB00155','2024-08-26','Tersedia',NULL,'Yes'),('B0021.000860','B0021','BB00155','2024-08-26','Tersedia',NULL,'Yes'),('B0042.000653','B0042','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0042.000654','B0042','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0047.000631','B0047','BB00104','2024-05-29','Tersedia',NULL,'Yes'),('B0047.000632','B0047','BB00104','2024-05-29','Tersedia',NULL,'Yes'),('B0055.000066','B0055','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0055.000067','B0055','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0055.000068','B0055','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0055.000069','B0055','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0055.000137','B0055','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0055.000138','B0055','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0055.000139','B0055','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0055.000140','B0055','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0055.000891','B0055','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0055.000892','B0055','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0056.000193','B0056','BB00026','2024-04-19','Tersedia',NULL,'Yes'),('B0056.000194','B0056','BB00026','2024-04-19','Tersedia',NULL,'Yes'),('B0056.000195','B0056','BB00027','2024-04-19','Tersedia',NULL,'Yes'),('B0056.000198','B0056','BB00029','2024-04-19','Tersedia',NULL,'Yes'),('B0056.000201','B0056','BB00031','2024-04-19','Tersedia',NULL,'Yes'),('B0056.000209','B0056','BB00035','2024-04-19','Tersedia',NULL,'Yes'),('B0056.000235','B0056','BB00045','2024-04-19','Tersedia',NULL,'Yes'),('B0056.000236','B0056','BB00045','2024-04-19','Tersedia',NULL,'Yes'),('B0056.000241','B0056','BB00049','2024-04-20','Tersedia',NULL,'Yes'),('B0056.000243','B0056','BB00051','2024-04-20','Tersedia',NULL,'Yes'),('B0056.000257','B0056','BB00057','2024-04-20','Tersedia',NULL,'Yes'),('B0056.000289','B0056','BB00070','2024-04-21','Tersedia',NULL,'Yes'),('B0056.000294','B0056','BB00074','2024-04-21','Tersedia',NULL,'Yes'),('B0056.000629','B0056','BB00106','2024-05-29','Tersedia',NULL,'Yes'),('B0056.000791','B0056','BB00126','2024-06-24','Tersedia',NULL,'Yes'),('B0056.000798','B0056','BB00131','2024-06-27','Tersedia',NULL,'Yes'),('B0056.000810','B0056','BB00139','2024-07-31','Tersedia',NULL,'Yes'),('B0056.000813','B0056','BB00142','2024-08-06','Tersedia',NULL,'Yes'),('B0056.000856','B0056','BB00156','2024-08-26','Tersedia',NULL,'Yes'),('B0056.000879','B0056','BB00161','2024-09-17','Tersedia',NULL,'Yes'),('B0056.000959','B0056','BB00166','2024-10-03','Tersedia',NULL,'Yes'),('B0056.001002','B0056','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0056.001003','B0056','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0056.001004','B0056','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0056.001022','B0056','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0056.001023','B0056','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0056.001024','B0056','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0056.001030','B0056','BB00171','2024-10-29','Tersedia',NULL,'Yes'),('B0075.000385','B0075','BB00090','2024-04-22','Tersedia',NULL,'Yes'),('B0080.000170','B0080','BB00020','2024-04-19','Tersedia',NULL,'Yes'),('B0080.000239','B0080','BB00047','2024-04-20','Tersedia',NULL,'Yes'),('B0080.000244','B0080','BB00052','2024-04-20','Tersedia',NULL,'Yes'),('B0080.000255','B0080','BB00056','2024-04-20','Tersedia',NULL,'Yes'),('B0080.000256','B0080','BB00056','2024-04-20','Tersedia',NULL,'Yes'),('B0080.000283','B0080','BB00065','2024-04-20','Tersedia',NULL,'Yes'),('B0080.000287','B0080','BB00068','2024-04-21','Tersedia',NULL,'Yes'),('B0080.000292','B0080','BB00072','2024-04-21','Tersedia',NULL,'Yes'),('B0080.000384','B0080','BB00089','2024-04-22','Tersedia',NULL,'Yes'),('B0080.000799','B0080','BB00129','2024-06-27','Tersedia',NULL,'Yes'),('B0080.000845','B0080','BB00146','2024-08-20','Tersedia',NULL,'Yes'),('B0080.000870','B0080','BB00153','2024-08-26','Tersedia',NULL,'Yes'),('B0080.001031','B0080','BB00171','2024-10-29','Tersedia',NULL,'Yes'),('B0080.001041','B0080','BB00177','2024-10-30','Tersedia',NULL,'Yes'),('B0080.001047','B0080','BB00176','2024-10-30','Tersedia',NULL,'Yes'),('B0080.001067','B0080','BB00183','2024-11-10','Tersedia',NULL,'Yes'),('B0080.001089','B0080','BB00179','2024-11-10','Tersedia',NULL,'Yes'),('B0084.000044','B0084','BB00005','2024-04-18','Tersedia',NULL,'Yes'),('B0084.000057','B0084','BB00008','2024-04-18','Tersedia',NULL,'Yes'),('B0084.000061','B0084','BB00012','2024-04-18','Tersedia',NULL,'Yes'),('B0084.000062','B0084','BB00013','2024-04-18','Tersedia',NULL,'Yes'),('B0084.000077','B0084','BB00016','2024-04-18','Tersedia',NULL,'Yes'),('B0084.000079','B0084','BB00001','2024-04-19','Tersedia',NULL,'Yes'),('B0084.000126','B0084','BB00005','2024-04-19','Tersedia',NULL,'Yes'),('B0084.000130','B0084','BB00009','2024-04-19','Tersedia',NULL,'Yes'),('B0084.000131','B0084','BB00010','2024-04-19','Tersedia',NULL,'Yes'),('B0084.000145','B0084','BB00012','2024-04-19','Tersedia',NULL,'Yes'),('B0084.000146','B0084','BB00013','2024-04-19','Tersedia',NULL,'Yes'),('B0084.000206','B0084','BB00033','2024-04-19','Tersedia',NULL,'Yes'),('B0084.000237','B0084','BB00046','2024-04-19','Tersedia',NULL,'Yes'),('B0084.000238','B0084','BB00046','2024-04-19','Tersedia',NULL,'Yes'),('B0084.000812','B0084','BB00140','2024-08-06','Tersedia',NULL,'Yes'),('B0084.000871','B0084','BB00153','2024-08-26','Tersedia',NULL,'Yes'),('B0084.000872','B0084','BB00153','2024-08-26','Tersedia',NULL,'Yes'),('B0084.000873','B0084','BB00153','2024-08-26','Tersedia',NULL,'Yes'),('B0084.000874','B0084','BB00153','2024-08-26','Tersedia',NULL,'Yes'),('B0084.000875','B0084','BB00152','2024-08-26','Tersedia',NULL,'Yes'),('B0084.000884','B0084','BB00159','2024-09-17','Tersedia',NULL,'Yes'),('B0084.000885','B0084','BB00159','2024-09-17','Tersedia',NULL,'Yes'),('B0084.000886','B0084','BB00162','2024-09-20','Tersedia',NULL,'Yes'),('B0084.000889','B0084','BB00163','2024-10-01','Tersedia',NULL,'Yes'),('B0084.000890','B0084','BB00164','2024-10-02','Tersedia',NULL,'Yes'),('B0095.000815','B0095','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0095.000816','B0095','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0099.001052','B0099','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0099.001053','B0099','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0099.001054','B0099','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0099.001055','B0099','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0099.001082','B0099','BB00180','2024-11-10','Tersedia',NULL,'Yes'),('B0101.000064','B0101','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0101.000065','B0101','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0101.000135','B0101','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0101.000136','B0101','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0101.000270','B0101','BB00061','2024-04-20','Tersedia',NULL,'Yes'),('B0101.000271','B0101','BB00061','2024-04-20','Tersedia',NULL,'Yes'),('B0101.000272','B0101','BB00061','2024-04-20','Tersedia',NULL,'Yes'),('B0101.000273','B0101','BB00061','2024-04-20','Tersedia',NULL,'Yes'),('B0101.000274','B0101','BB00061','2024-04-20','Tersedia',NULL,'Yes'),('B0101.000817','B0101','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0101.000818','B0101','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0101.000819','B0101','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0101.000820','B0101','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0101.001056','B0101','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0101.001057','B0101','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0101.001058','B0101','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0101.001059','B0101','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0101.001068','B0101','BB00183','2024-11-10','Tersedia',NULL,'Yes'),('B0101.001083','B0101','BB00180','2024-11-10','Tersedia',NULL,'Yes'),('B0117.000063','B0117','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0117.000082','B0117','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0117.000083','B0117','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0117.000134','B0117','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0117.000230','B0117','BB00043','2024-04-19','Tersedia',NULL,'Yes'),('B0117.000231','B0117','BB00043','2024-04-19','Tersedia',NULL,'Yes'),('B0117.000232','B0117','BB00043','2024-04-19','Tersedia',NULL,'Yes'),('B0117.000269','B0117','BB00060','2024-04-20','Tersedia',NULL,'Yes'),('B0117.000278','B0117','BB00061','2024-04-20','Tersedia',NULL,'Yes'),('B0117.001074','B0117','BB00182','2024-11-10','Tersedia',NULL,'Yes'),('B0118.000045','B0118','BB00006','2024-04-18','Tersedia',NULL,'Yes'),('B0118.000046','B0118','BB00006','2024-04-18','Tersedia',NULL,'Yes'),('B0118.000084','B0118','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0118.000085','B0118','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0118.000188','B0118','BB00025','2024-04-19','Tersedia',NULL,'Yes'),('B0118.000189','B0118','BB00025','2024-04-19','Tersedia',NULL,'Yes'),('B0118.000190','B0118','BB00025','2024-04-19','Tersedia',NULL,'Yes'),('B0118.000191','B0118','BB00025','2024-04-19','Tersedia',NULL,'Yes'),('B0118.000192','B0118','BB00025','2024-04-19','Tersedia',NULL,'Yes'),('B0118.000220','B0118','BB00041','2024-04-19','Tersedia',NULL,'Yes'),('B0118.000254','B0118','BB00055','2024-04-20','Tersedia',NULL,'Yes'),('B0118.000267','B0118','BB00060','2024-04-20','Tersedia',NULL,'Yes'),('B0118.000276','B0118','BB00061','2024-04-20','Tersedia',NULL,'Yes'),('B0118.001060','B0118','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0118.001066','B0118','BB00174','2024-10-30','Tersedia',NULL,'Yes'),('B0119.000074','B0119','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0119.000133','B0119','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0119.000214','B0119','BB00037','2024-04-19','Tersedia',NULL,'Yes'),('B0119.000282','B0119','BB00064','2024-04-20','Tersedia',NULL,'Yes'),('B0119.000286','B0119','BB00067','2024-04-21','Tersedia',NULL,'Yes'),('B0119.000291','B0119','BB00071','2024-04-21','Tersedia',NULL,'Yes'),('B0119.000647','B0119','BB00119','2024-06-12','Tersedia',NULL,'Yes'),('B0119.000821','B0119','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0120.000309','B0120','BB00083','2024-04-22','Tersedia',NULL,'Yes'),('B0120.000310','B0120','BB00083','2024-04-22','Tersedia',NULL,'Yes'),('B0121.000221','B0121','BB00042','2024-04-19','Tersedia',NULL,'Yes'),('B0121.000268','B0121','BB00060','2024-04-20','Tersedia',NULL,'Yes'),('B0121.000277','B0121','BB00061','2024-04-20','Tersedia',NULL,'Yes'),('B0121.001036','B0121','BB00173','2024-10-29','Tersedia',NULL,'Yes'),('B0121.001037','B0121','BB00178','2024-10-30','Tersedia',NULL,'Yes'),('B0121.001038','B0121','BB00178','2024-10-30','Tersedia',NULL,'Yes'),('B0121.001069','B0121','BB00183','2024-11-10','Tersedia',NULL,'Yes'),('B0121.001075','B0121','BB00182','2024-11-10','Tersedia',NULL,'Yes'),('B0121.001080','B0121','BB00181','2024-11-10','Tersedia',NULL,'Yes'),('B0121.001081','B0121','BB00181','2024-11-10','Tersedia',NULL,'Yes'),('B0122.000047','B0122','BB00006','2024-04-18','Tersedia',NULL,'Yes'),('B0122.000048','B0122','BB00006','2024-04-18','Tersedia',NULL,'Yes'),('B0122.000075','B0122','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0122.000086','B0122','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0122.000087','B0122','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0122.000132','B0122','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0122.000251','B0122','BB00054','2024-04-20','Tersedia',NULL,'Yes'),('B0122.000275','B0122','BB00061','2024-04-20','Tersedia',NULL,'Yes'),('B0122.001048','B0122','BB00176','2024-10-30','Tersedia',NULL,'Yes'),('B0122.001049','B0122','BB00176','2024-10-30','Tersedia',NULL,'Yes'),('B0123.000303','B0123','BB00080','2024-04-22','Tersedia',NULL,'Yes'),('B0123.000787','B0123','BB00128','2024-06-24','Tersedia',NULL,'Yes'),('B0123.000788','B0123','BB00128','2024-06-24','Tersedia',NULL,'Yes'),('B0124.000795','B0124','BB00123','2024-06-24','Tersedia',NULL,'Yes'),('B0124.000984','B0124','BB00169','2024-10-18','Tersedia',NULL,'Yes'),('B0124.000985','B0124','BB00169','2024-10-18','Tersedia',NULL,'Yes'),('B0124.000987','B0124','BB00168','2024-10-18','Tersedia',NULL,'Yes'),('B0124.000988','B0124','BB00168','2024-10-18','Tersedia',NULL,'Yes'),('B0124.001084','B0124','BB00180','2024-11-10','Tersedia',NULL,'Yes'),('B0127.000049','B0127','BB00006','2024-04-18','Tersedia',NULL,'Yes'),('B0127.000050','B0127','BB00006','2024-04-18','Tersedia',NULL,'Yes'),('B0127.000051','B0127','BB00006','2024-04-18','Tersedia',NULL,'Yes'),('B0127.000052','B0127','BB00006','2024-04-18','Tersedia',NULL,'Yes'),('B0127.000053','B0127','BB00006','2024-04-18','Tersedia',NULL,'Yes'),('B0127.000054','B0127','BB00006','2024-04-18','Tersedia',NULL,'Yes'),('B0127.000070','B0127','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0127.000071','B0127','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0127.000072','B0127','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0127.000073','B0127','BB00014','2024-04-18','Tersedia',NULL,'Yes'),('B0127.000088','B0127','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000089','B0127','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000090','B0127','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000091','B0127','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000092','B0127','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000093','B0127','BB00003','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000141','B0127','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000142','B0127','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000143','B0127','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000144','B0127','BB00011','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000181','B0127','BB00025','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000182','B0127','BB00025','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000183','B0127','BB00025','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000184','B0127','BB00025','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000185','B0127','BB00025','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000186','B0127','BB00025','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000196','B0127','BB00028','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000197','B0127','BB00028','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000199','B0127','BB00030','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000200','B0127','BB00030','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000212','B0127','BB00037','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000213','B0127','BB00037','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000219','B0127','BB00040','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000226','B0127','BB00043','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000227','B0127','BB00043','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000228','B0127','BB00043','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000229','B0127','BB00043','2024-04-19','Tersedia',NULL,'Yes'),('B0127.000249','B0127','BB00054','2024-04-20','Tersedia',NULL,'Yes'),('B0127.000250','B0127','BB00054','2024-04-20','Tersedia',NULL,'Yes'),('B0127.000253','B0127','BB00055','2024-04-20','Tersedia',NULL,'Yes'),('B0127.000263','B0127','BB00060','2024-04-20','Tersedia',NULL,'Yes'),('B0127.000264','B0127','BB00060','2024-04-20','Tersedia',NULL,'Yes'),('B0127.000265','B0127','BB00060','2024-04-20','Tersedia',NULL,'Yes'),('B0127.000266','B0127','BB00060','2024-04-20','Tersedia',NULL,'Yes'),('B0127.000281','B0127','BB00064','2024-04-20','Tersedia',NULL,'Yes'),('B0127.000285','B0127','BB00067','2024-04-21','Tersedia',NULL,'Yes'),('B0127.000290','B0127','BB00071','2024-04-21','Tersedia',NULL,'Yes'),('B0127.000648','B0127','BB00119','2024-06-12','Tersedia',NULL,'Yes'),('B0127.000649','B0127','BB00119','2024-06-12','Tersedia',NULL,'Yes'),('B0127.000793','B0127','BB00124','2024-06-24','Tersedia',NULL,'Yes'),('B0127.000794','B0127','BB00124','2024-06-24','Tersedia',NULL,'Yes'),('B0127.000822','B0127','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0127.000823','B0127','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0127.000824','B0127','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0127.000825','B0127','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0127.000893','B0127','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0127.000894','B0127','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0127.000895','B0127','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0127.000896','B0127','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0127.000986','B0127','BB00169','2024-10-18','Tersedia',NULL,'Yes'),('B0127.000989','B0127','BB00168','2024-10-18','Tersedia',NULL,'Yes'),('B0127.001061','B0127','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0127.001062','B0127','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0127.001063','B0127','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0127.001064','B0127','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0127.001070','B0127','BB00183','2024-11-10','Tersedia',NULL,'Yes'),('B0127.001076','B0127','BB00182','2024-11-10','Tersedia',NULL,'Yes'),('B0127.001077','B0127','BB00182','2024-11-10','Tersedia',NULL,'Yes'),('B0127.001085','B0127','BB00180','2024-11-10','Tersedia',NULL,'Yes'),('B0127.001086','B0127','BB00180','2024-11-10','Tersedia',NULL,'Yes'),('B0131.001065','B0131','BB00175','2024-10-30','Tersedia',NULL,'Yes'),('B0133.000058','B0133','BB00009','2024-04-18','Tersedia',NULL,'Yes'),('B0133.000078','B0133','BB00017','2024-04-18','Tersedia',NULL,'Yes'),('B0133.000128','B0133','BB00007','2024-04-19','Tersedia',NULL,'Yes'),('B0133.000147','B0133','BB00014','2024-04-19','Tersedia',NULL,'Yes'),('B0133.000177','B0133','BB00023','2024-04-19','Tersedia',NULL,'Yes'),('B0133.000178','B0133','BB00023','2024-04-19','Tersedia',NULL,'Yes'),('B0133.000224','B0133','BB00043','2024-04-19','Tersedia',NULL,'Yes'),('B0133.000225','B0133','BB00043','2024-04-19','Tersedia',NULL,'Yes'),('B0133.000258','B0133','BB00058','2024-04-20','Tersedia',NULL,'Yes'),('B0133.000259','B0133','BB00058','2024-04-20','Tersedia',NULL,'Yes'),('B0133.000280','B0133','BB00063','2024-04-20','Tersedia',NULL,'Yes'),('B0133.000650','B0133','BB00119','2024-06-12','Tersedia',NULL,'Yes'),('B0133.000651','B0133','BB00119','2024-06-12','Tersedia',NULL,'Yes'),('B0133.000789','B0133','BB00127','2024-06-24','Tersedia',NULL,'Yes'),('B0133.000790','B0133','BB00127','2024-06-24','Tersedia',NULL,'Yes'),('B0133.000814','B0133','BB00141','2024-08-06','Tersedia',NULL,'Yes'),('B0133.000842','B0133','BB00148','2024-08-20','Tersedia',NULL,'Yes'),('B0133.000887','B0133','BB00162','2024-09-20','Tersedia',NULL,'Yes'),('B0133.000888','B0133','BB00162','2024-09-20','Tersedia',NULL,'Yes'),('B0133.001032','B0133','BB00171','2024-10-29','Tersedia',NULL,'Yes'),('B0133.001035','B0133','BB00172','2024-10-29','Tersedia',NULL,'Yes'),('B0133.001071','B0133','BB00183','2024-11-10','Tersedia',NULL,'Yes'),('B0133.001078','B0133','BB00182','2024-11-10','Tersedia',NULL,'Yes'),('B0137.000630','B0137','BB00105','2024-05-29','Tersedia',NULL,'Yes'),('B0140.001005','B0140','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0140.001006','B0140','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0140.001025','B0140','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0140.001026','B0140','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0140.001072','B0140','BB00183','2024-11-10','Tersedia',NULL,'Yes'),('B0145.000222','B0145','BB00043','2024-04-19','Tersedia',NULL,'Yes'),('B0145.000223','B0145','BB00043','2024-04-19','Tersedia',NULL,'Yes'),('B0145.001007','B0145','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0145.001027','B0145','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0145.001050','B0145','BB00176','2024-10-30','Tersedia',NULL,'Yes'),('B0146.000163','B0146','BB00016','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000012','B0154','BB00003','2024-04-18','Tersedia',NULL,'Yes'),('B0154.000013','B0154','BB00003','2024-04-18','Tersedia',NULL,'Yes'),('B0154.000059','B0154','BB00010','2024-04-18','Tersedia',NULL,'Yes'),('B0154.000080','B0154','BB00002','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000081','B0154','BB00002','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000127','B0154','BB00006','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000166','B0154','BB00019','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000167','B0154','BB00019','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000168','B0154','BB00019','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000169','B0154','BB00019','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000179','B0154','BB00024','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000180','B0154','BB00024','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000202','B0154','BB00032','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000207','B0154','BB00034','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000208','B0154','BB00034','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000210','B0154','BB00036','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000211','B0154','BB00036','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000215','B0154','BB00038','2024-04-19','Tersedia',NULL,'Yes'),('B0154.000240','B0154','BB00048','2024-04-20','Tersedia',NULL,'Yes'),('B0154.000242','B0154','BB00050','2024-04-20','Tersedia',NULL,'Yes'),('B0154.000248','B0154','BB00053','2024-04-20','Tersedia',NULL,'Yes'),('B0154.000260','B0154','BB00059','2024-04-20','Tersedia',NULL,'Yes'),('B0154.000261','B0154','BB00059','2024-04-20','Tersedia',NULL,'Yes'),('B0154.000262','B0154','BB00059','2024-04-20','Tersedia',NULL,'Yes'),('B0154.000279','B0154','BB00062','2024-04-20','Tersedia',NULL,'Yes'),('B0154.000284','B0154','BB00066','2024-04-20','Tersedia',NULL,'Yes'),('B0154.000288','B0154','BB00069','2024-04-21','Tersedia',NULL,'Yes'),('B0154.000293','B0154','BB00073','2024-04-21','Tersedia',NULL,'Yes'),('B0154.000797','B0154','BB00130','2024-06-27','Tersedia',NULL,'Yes'),('B0154.000861','B0154','BB00154','2024-08-26','Tersedia',NULL,'Yes'),('B0154.001033','B0154','BB00171','2024-10-29','Tersedia',NULL,'Yes'),('B0154.001034','B0154','BB00171','2024-10-29','Tersedia',NULL,'Yes'),('B0154.001039','B0154','BB00178','2024-10-30','Tersedia',NULL,'Yes'),('B0154.001073','B0154','BB00183','2024-11-10','Tersedia',NULL,'Yes'),('B0154.001079','B0154','BB00182','2024-11-10','Tersedia',NULL,'Yes'),('B0155.000055','B0155','BB00007','2024-04-18','Tersedia',NULL,'Yes'),('B0155.000056','B0155','BB00007','2024-04-18','Tersedia',NULL,'Yes'),('B0155.000124','B0155','BB00004','2024-04-19','Tersedia',NULL,'Yes'),('B0155.000125','B0155','BB00004','2024-04-19','Tersedia',NULL,'Yes'),('B0156.000060','B0156','BB00011','2024-04-18','Tersedia',NULL,'Yes'),('B0156.000129','B0156','BB00008','2024-04-19','Tersedia',NULL,'Yes'),('B0157.000187','B0157','BB00025','2024-04-19','Tersedia',NULL,'Yes'),('B0158.000300','B0158','BB00078','2024-04-22','Tersedia',NULL,'Yes'),('B0158.000301','B0158','BB00078','2024-04-22','Tersedia',NULL,'Yes'),('B0158.000652','B0158','BB00119','2024-06-12','Tersedia',NULL,'Yes'),('B0159.000162','B0159','BB00016','2024-04-19','Tersedia',NULL,'Yes'),('B0160.000164','B0160','BB00017','2024-04-19','Tersedia',NULL,'Yes'),('B0160.000165','B0160','BB00018','2024-04-19','Tersedia',NULL,'Yes'),('B0161.000252','B0161','BB00054','2024-04-20','Tersedia',NULL,'Yes'),('B0162.000295','B0162','BB00075','2024-04-22','Tersedia',NULL,'Yes'),('B0163.000296','B0163','BB00076','2024-04-22','Tersedia',NULL,'Yes'),('B0164.000297','B0164','BB00077','2024-04-22','Tersedia',NULL,'Yes'),('B0164.000298','B0164','BB00077','2024-04-22','Tersedia',NULL,'Yes'),('B0164.000299','B0164','BB00077','2024-04-22','Tersedia',NULL,'Yes'),('B0164.000897','B0164','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0164.000898','B0164','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0164.000899','B0164','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0165.000302','B0165','BB00079','2024-04-22','Tersedia',NULL,'Yes'),('B0166.000312','B0166','BB00085','2024-04-22','Tersedia',NULL,'Yes'),('B0167.000311','B0167','BB00084','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000327','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000328','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000329','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000330','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000331','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000332','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000333','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000334','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000335','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000336','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000337','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000338','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000339','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000340','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000341','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000342','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000343','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000344','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000345','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000346','B0168','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000389','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000390','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000391','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000392','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000393','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000394','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000395','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000396','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000397','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000398','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000399','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000400','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000401','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000402','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000403','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000404','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000405','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000406','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000407','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000408','B0168','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000442','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000443','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000444','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000445','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000446','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000447','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000448','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000449','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000450','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000451','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000452','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000453','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000454','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000455','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000456','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000457','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000458','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000459','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000460','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000461','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000462','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000463','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000464','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000465','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000466','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000467','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000468','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000469','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000470','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000471','B0168','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000500','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000501','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000502','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000503','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000504','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000505','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000506','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000507','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000508','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000509','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000510','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000511','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000512','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000513','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000514','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000515','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000516','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000517','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000518','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000519','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000520','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000521','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000522','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000523','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000524','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000525','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000526','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000527','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000528','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000529','B0168','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000546','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000547','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000548','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000549','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000550','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000551','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000552','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000553','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000554','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000555','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000556','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000557','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000558','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000559','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000560','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000561','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000562','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000563','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000564','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000565','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000566','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000567','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000568','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000569','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000570','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000571','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000572','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000573','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000574','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000575','B0168','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000586','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000587','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000588','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000589','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000590','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000591','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000592','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000593','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000594','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000595','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000596','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000597','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000598','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000599','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000600','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000601','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000602','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000603','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000604','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000605','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000606','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000607','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000608','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000609','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000610','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000611','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000612','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000613','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000614','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0168.000615','B0168','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0169.000326','B0169','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000316','B0170','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000317','B0170','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000318','B0170','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000319','B0170','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000320','B0170','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000321','B0170','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000322','B0170','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000323','B0170','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000324','B0170','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000325','B0170','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000422','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000423','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000424','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000425','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000426','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000427','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000428','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000429','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000430','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000431','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000432','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000433','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000434','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000435','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000436','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000437','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000438','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000439','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000440','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0170.000441','B0170','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0171.000315','B0171','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0172.000314','B0172','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0172.000388','B0172','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0173.000313','B0173','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0173.000387','B0173','BB00092','2024-04-22','Tersedia',NULL,'Yes'),('B0173.000478','B0173','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0173.000479','B0173','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0173.000480','B0173','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0173.000481','B0173','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0173.000482','B0173','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0174.000347','B0174','BB00086','2024-04-22','Tersedia',NULL,'Yes'),('B0175.000348','B0175','BB00087','2024-04-22','Tersedia',NULL,'Yes'),('B0175.000349','B0175','BB00087','2024-04-22','Tersedia',NULL,'Yes'),('B0175.000350','B0175','BB00087','2024-04-22','Tersedia',NULL,'Yes'),('B0175.000351','B0175','BB00087','2024-04-22','Tersedia',NULL,'Yes'),('B0175.000352','B0175','BB00087','2024-04-22','Tersedia',NULL,'Yes'),('B0175.000353','B0175','BB00087','2024-04-22','Tersedia',NULL,'Yes'),('B0175.000354','B0175','BB00087','2024-04-22','Tersedia',NULL,'Yes'),('B0175.000355','B0175','BB00087','2024-04-22','Tersedia',NULL,'Yes'),('B0175.000356','B0175','BB00087','2024-04-22','Tersedia',NULL,'Yes'),('B0175.000357','B0175','BB00087','2024-04-22','Tersedia',NULL,'Yes'),('B0176.000379','B0176','BB00089','2024-04-22','Tersedia',NULL,'Yes'),('B0176.000380','B0176','BB00089','2024-04-22','Tersedia',NULL,'Yes'),('B0176.000381','B0176','BB00089','2024-04-22','Tersedia',NULL,'Yes'),('B0176.000382','B0176','BB00089','2024-04-22','Tersedia',NULL,'Yes'),('B0176.000383','B0176','BB00089','2024-04-22','Tersedia',NULL,'Yes'),('B0176.000826','B0176','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0176.000827','B0176','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0176.000828','B0176','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0176.000829','B0176','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0176.000830','B0176','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0177.000374','B0177','BB00089','2024-04-22','Tersedia',NULL,'Yes'),('B0177.000375','B0177','BB00089','2024-04-22','Tersedia',NULL,'Yes'),('B0177.000376','B0177','BB00089','2024-04-22','Tersedia',NULL,'Yes'),('B0177.000377','B0177','BB00089','2024-04-22','Tersedia',NULL,'Yes'),('B0177.000378','B0177','BB00089','2024-04-22','Tersedia',NULL,'Yes'),('B0178.000373','B0178','BB00089','2024-04-22','Tersedia',NULL,'Yes'),('B0179.000386','B0179','BB00091','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000409','B0180','BB00093','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000410','B0180','BB00093','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000411','B0180','BB00093','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000412','B0180','BB00093','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000413','B0180','BB00093','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000414','B0180','BB00093','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000415','B0180','BB00093','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000416','B0180','BB00093','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000417','B0180','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000418','B0180','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000419','B0180','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000420','B0180','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0180.000421','B0180','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0181.000476','B0181','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0181.000477','B0181','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0181.000625','B0181','BB00101','2024-04-22','Tersedia',NULL,'Yes'),('B0181.000626','B0181','BB00101','2024-04-22','Tersedia',NULL,'Yes'),('B0182.000472','B0182','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0182.000473','B0182','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0182.000622','B0182','BB00101','2024-04-22','Tersedia',NULL,'Yes'),('B0183.000483','B0183','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0183.000484','B0183','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0183.000544','B0183','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0183.000545','B0183','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0183.000617','B0183','BB00101','2024-04-22','Tersedia',NULL,'Yes'),('B0183.000618','B0183','BB00101','2024-04-22','Tersedia',NULL,'Yes'),('B0183.001090','B0183','BB00186','2024-11-19','Tersedia','70A74146E4D9','Yes'),('B0183.001091','B0183','BB00186','2024-11-19','Tersedia','','Yes'),('B0183.001092','B0183','BB00186','2024-11-19','Tersedia','','Yes'),('B0183.001093','B0183','BB00186','2024-11-19','Tersedia','','Yes'),('B0183.001094','B0183','BB00186','2024-11-19','Tersedia','','Yes'),('B0184.000485','B0184','BB00095','2024-04-22','Tersedia',NULL,'Yes'),('B0184.000486','B0184','BB00095','2024-04-22','Tersedia',NULL,'Yes'),('B0184.000487','B0184','BB00095','2024-04-22','Tersedia',NULL,'Yes'),('B0184.000488','B0184','BB00095','2024-04-22','Tersedia',NULL,'Yes'),('B0184.000489','B0184','BB00095','2024-04-22','Tersedia',NULL,'Yes'),('B0184.000619','B0184','BB00101','2024-04-22','Tersedia',NULL,'Yes'),('B0184.000620','B0184','BB00101','2024-04-22','Tersedia',NULL,'Yes'),('B0184.000621','B0184','BB00101','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000490','B0185','BB00096','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000491','B0185','BB00096','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000492','B0185','BB00096','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000493','B0185','BB00096','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000494','B0185','BB00096','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000495','B0185','BB00096','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000496','B0185','BB00096','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000497','B0185','BB00096','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000498','B0185','BB00096','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000499','B0185','BB00096','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000531','B0185','BB00098','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000532','B0185','BB00098','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000533','B0185','BB00098','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000534','B0185','BB00098','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000535','B0185','BB00098','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000536','B0185','BB00098','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000537','B0185','BB00098','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000538','B0185','BB00098','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000539','B0185','BB00098','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000540','B0185','BB00098','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000541','B0185','BB00098','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000542','B0185','BB00098','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000576','B0185','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000577','B0185','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000578','B0185','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000579','B0185','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000580','B0185','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000581','B0185','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000582','B0185','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000583','B0185','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000584','B0185','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0185.000585','B0185','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0186.000627','B0186','BB00101','2024-04-22','Tersedia',NULL,'Yes'),('B0186.000628','B0186','BB00101','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000358','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000359','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000360','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000361','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000362','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000363','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000364','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000365','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000366','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000367','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000368','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000369','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000370','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000371','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0187.000372','B0187','BB00088','2024-04-22','Tersedia',NULL,'Yes'),('B0188.000474','B0188','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0188.000475','B0188','BB00094','2024-04-22','Tersedia',NULL,'Yes'),('B0188.000623','B0188','BB00101','2024-04-22','Tersedia',NULL,'Yes'),('B0188.000624','B0188','BB00101','2024-04-22','Tersedia',NULL,'Yes'),('B0189.000530','B0189','BB00097','2024-04-22','Tersedia',NULL,'Yes'),('B0189.000616','B0189','BB00100','2024-04-22','Tersedia',NULL,'Yes'),('B0189.001008','B0189','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0189.001028','B0189','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0190.000543','B0190','BB00099','2024-04-22','Tersedia',NULL,'Yes'),('B0192.000831','B0192','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0192.000832','B0192','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0194.000633','B0194','BB00103','2024-05-29','Tersedia',NULL,'Yes'),('B0194.000634','B0194','BB00102','2024-05-29','Tersedia',NULL,'Yes'),('B0194.000635','B0194','BB00107','2024-05-29','Tersedia',NULL,'Yes'),('B0194.000642','B0194','BB00108','2024-06-04','Tersedia',NULL,'Yes'),('B0197.000839','B0197','BB00143','2024-08-13','Tersedia',NULL,'Yes'),('B0198.000639','B0198','BB00111','2024-06-04','Tersedia',NULL,'Yes'),('B0198.000960','B0198','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0198.000961','B0198','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0198.000962','B0198','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0198.000963','B0198','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0198.000964','B0198','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0198.000965','B0198','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0198.000966','B0198','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0198.000967','B0198','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0198.000968','B0198','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0198.000969','B0198','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0198.000970','B0198','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0198.000971','B0198','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0199.000640','B0199','BB00110','2024-06-04','Tersedia',NULL,'Yes'),('B0199.000972','B0199','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0199.000973','B0199','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0199.000974','B0199','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0199.000975','B0199','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0199.000976','B0199','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0199.000977','B0199','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0199.000978','B0199','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0199.000979','B0199','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0199.000980','B0199','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0199.000981','B0199','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0199.000982','B0199','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0199.000983','B0199','BB00167','2024-10-07','Tersedia',NULL,'Yes'),('B0200.000638','B0200','BB00112','2024-06-04','Tersedia',NULL,'Yes'),('B0201.000641','B0201','BB00109','2024-06-04','Tersedia',NULL,'Yes'),('B0202.000636','B0202','BB00113','2024-06-04','Tersedia',NULL,'Yes'),('B0202.000637','B0202','BB00113','2024-06-04','Tersedia',NULL,'Yes'),('B0203.000785','B0203','BB00114','2024-06-12','Tersedia',NULL,'Yes'),('B0204.000783','B0204','BB00115','2024-06-12','Tersedia',NULL,'Yes'),('B0205.000784','B0205','BB00115','2024-06-12','Tersedia',NULL,'Yes'),('B0206.000782','B0206','BB00116','2024-06-12','Tersedia',NULL,'Yes'),('B0207.000781','B0207','BB00117','2024-06-12','Tersedia',NULL,'No'),('B0208.000655','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000656','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000657','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000658','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000659','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000660','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000661','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000662','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000663','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000664','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000665','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000666','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000667','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000668','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000669','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0208.000670','B0208','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0209.000671','B0209','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0209.000672','B0209','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0209.000673','B0209','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0209.000674','B0209','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0209.000675','B0209','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0209.000676','B0209','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0209.000677','B0209','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0209.000678','B0209','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0209.000679','B0209','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0209.000680','B0209','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000681','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000682','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000683','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000684','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000685','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000686','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000687','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000688','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000689','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000690','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000691','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000692','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000693','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000694','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000695','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000696','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000697','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000698','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000699','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000700','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000701','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000702','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000703','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000704','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000705','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000706','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000707','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000708','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000709','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000710','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000711','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000712','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000713','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000714','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000715','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000716','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000717','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000718','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000719','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000720','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000721','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000722','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000723','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000724','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000725','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000726','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000727','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000728','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000729','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000730','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000731','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000732','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000733','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000734','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000735','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000736','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000737','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000738','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000739','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000740','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000741','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000742','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000743','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000744','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000745','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000746','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000747','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000748','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000749','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000750','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000751','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000752','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000753','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000754','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000755','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000756','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000757','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000758','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000759','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000760','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000761','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000762','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000763','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000764','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000765','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000766','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000767','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000768','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000769','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000770','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000771','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000772','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000773','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000774','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000775','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000776','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000777','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000778','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000779','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0210.000780','B0210','BB00118','2024-06-12','Tersedia',NULL,'Yes'),('B0212.000644','B0212','BB00120','2024-06-12','Tersedia',NULL,'Yes'),('B0213.000645','B0213','BB00120','2024-06-12','Tersedia',NULL,'Yes'),('B0213.000646','B0213','BB00120','2024-06-12','Tersedia',NULL,'Yes'),('B0214.000643','B0214','BB00121','2024-06-12','Tersedia',NULL,'Yes'),('B0215.000786','B0215','BB00122','2024-06-18','Tersedia',NULL,'Yes'),('B0216.000800','B0216','BB00132','2024-06-27','Tersedia',NULL,'Yes'),('B0217.000796','B0217','BB00133','2024-06-27','Tersedia',NULL,'Yes'),('B0218.000803','B0218','BB00134','2024-07-17','Tersedia',NULL,'Yes'),('B0218.000804','B0218','BB00134','2024-07-17','Tersedia',NULL,'Yes'),('B0219.000801','B0219','BB00136','2024-07-17','Tersedia',NULL,'Yes'),('B0220.000802','B0220','BB00135','2024-07-17','Tersedia',NULL,'Yes'),('B0221.000809','B0221','BB00138','2024-07-26','Tersedia',NULL,'Yes'),('B0224.000833','B0224','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0224.000834','B0224','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0224.000835','B0224','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0224.000836','B0224','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0224.000837','B0224','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0224.000900','B0224','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0224.000901','B0224','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0224.000902','B0224','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0224.000903','B0224','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0224.000904','B0224','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0225.000838','B0225','BB00144','2024-08-13','Tersedia',NULL,'Yes'),('B0226.000840','B0226','BB00145','2024-08-19','Tersedia',NULL,'Yes'),('B0226.000841','B0226','BB00145','2024-08-19','Tersedia',NULL,'Yes'),('B0226.000846','B0226','BB00151','2024-08-23','Tersedia',NULL,'Yes'),('B0226.000847','B0226','BB00151','2024-08-23','Tersedia',NULL,'Yes'),('B0226.000848','B0226','BB00151','2024-08-23','Tersedia',NULL,'Yes'),('B0226.000849','B0226','BB00151','2024-08-23','Tersedia',NULL,'Yes'),('B0227.000853','B0227','BB00149','2024-08-23','Tersedia',NULL,'Yes'),('B0228.000854','B0228','BB00149','2024-08-23','Tersedia',NULL,'Yes'),('B0229.000855','B0229','BB00149','2024-08-23','Tersedia',NULL,'Yes'),('B0230.000852','B0230','BB00150','2024-08-23','Tersedia',NULL,'Yes'),('B0230.000905','B0230','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0230.000906','B0230','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0230.000907','B0230','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0230.001009','B0230','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0230.001029','B0230','BB00170','2024-10-22','Tersedia',NULL,'Yes'),('B0230.001040','B0230','BB00178','2024-10-30','Tersedia',NULL,'Yes'),('B0230.001042','B0230','BB00177','2024-10-30','Tersedia',NULL,'Yes'),('B0230.001043','B0230','BB00177','2024-10-30','Tersedia',NULL,'Yes'),('B0230.001044','B0230','BB00177','2024-10-30','Tersedia',NULL,'Yes'),('B0230.001045','B0230','BB00177','2024-10-30','Tersedia',NULL,'Yes'),('B0230.001051','B0230','BB00176','2024-10-30','Tersedia',NULL,'Yes'),('B0230.001087','B0230','BB00180','2024-11-10','Tersedia',NULL,'Yes'),('B0230.001088','B0230','BB00180','2024-11-10','Tersedia',NULL,'Yes'),('B0230.001095','B0230','BB00188','2024-11-19','Tersedia',NULL,'Yes'),('B0230.001096','B0230','BB00188','2024-11-19','Tersedia',NULL,'Yes'),('B0231.000850','B0231','BB00151','2024-08-23','Tersedia',NULL,'Yes'),('B0231.000851','B0231','BB00151','2024-08-23','Tersedia',NULL,'Yes'),('B0233.000876','B0233','BB00158','2024-09-10','Tersedia',NULL,'Yes'),('B0233.000877','B0233','BB00158','2024-09-10','Tersedia',NULL,'Yes'),('B0233.000878','B0233','BB00158','2024-09-10','Tersedia',NULL,'Yes'),('B0236.000908','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000909','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000910','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000911','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000912','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000913','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000914','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000915','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000916','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000917','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000918','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000919','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000920','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000921','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000922','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000923','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000924','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000925','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000926','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000927','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000928','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000929','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000930','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000931','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0236.000932','B0236','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000933','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000934','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000935','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000936','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000937','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000938','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000939','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000940','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000941','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000942','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000943','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000944','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000945','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000946','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000947','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000948','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000949','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000950','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000951','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000952','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000953','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000954','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000955','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000956','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.000957','B0237','BB00165','2024-10-02','Tersedia',NULL,'Yes'),('B0237.001097','B0237','BB00195','2024-12-24','Tersedia',NULL,'Yes'),('B0237.001098','B0237','BB00195','2024-12-24','Tersedia',NULL,'Yes'),('B0238.000958','B0238','BB00165','2024-10-02','Tersedia',NULL,'Yes');
/*!40000 ALTER TABLE `barang_inventaris` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_mati`
--

DROP TABLE IF EXISTS `barang_mati`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang_mati` (
  `no_barang_mati` char(7) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kd_inventaris` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kerusakan` varchar(100) DEFAULT NULL,
  `serial_number` varchar(50) DEFAULT NULL,
  `pelanggan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kd_petugas` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status_approval_barang_mati` enum('Approve','Belum Approve','-') NOT NULL,
  `kd_kategori` char(4) DEFAULT NULL,
  PRIMARY KEY (`no_barang_mati`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_mati`
--

LOCK TABLES `barang_mati` WRITE;
/*!40000 ALTER TABLE `barang_mati` DISABLE KEYS */;
INSERT INTO `barang_mati` VALUES ('BM00017','B0004.000863','tes','6768e048bb121-Acer_Wallpaper_02_5000x2813.jpg','2024-12-23','mati','THRH12128','Kantor Camat Sako ( PSS Palembang )','P002','Approve',NULL),('BM00019','B0207.000781','tes','676a8141e5cbb-Acer_Wallpaper_02_5000x2813.jpg','2024-12-25','tes',' wdwevgvuwuq',' PT Bank Mandiri Kec Palembang Sukajadi ( KM12 ) ','P002','Approve',NULL),('BM00020','B0047.000631','tes','6771f6dcccbab-Acer_Wallpaper_01_5000x2814.jpg','2024-12-31','rusak','sawd323e3','PT. Cendikia Global Solusi','P002','Belum Approve',NULL),('BM00016','B0183.001090','tes','6768dfa58b906-Acer_Wallpaper_01_5000x2814.jpg','2024-12-24','rusak','70A74146E4D9','Kantor NHT Bekasi','P002','Approve',NULL),('BM00018','B0004.000203','tes123','676a7f44d2973-Acer_Wallpaper_01_5000x2814.jpg','2024-12-25','rusak','qwt3e2eqv','PT Sinar Baru Wijaya Perkasa Site Sekayu ( PSS Palembang )','P002','Approve',NULL);
/*!40000 ALTER TABLE `barang_mati` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departemen`
--

DROP TABLE IF EXISTS `departemen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departemen` (
  `kd_departemen` char(4) NOT NULL,
  `nm_departemen` varchar(100) NOT NULL,
  PRIMARY KEY (`kd_departemen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departemen`
--

LOCK TABLES `departemen` WRITE;
/*!40000 ALTER TABLE `departemen` DISABLE KEYS */;
INSERT INTO `departemen` VALUES ('D001','NHT Bekasi'),('D002','NHT Palembang'),('D004','Palembang Siber Solusindo (PSS)'),('D005','NHT Bekasi - Indocyber');
/*!40000 ALTER TABLE `departemen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori` (
  `kd_kategori` char(4) NOT NULL,
  `nm_kategori` varchar(100) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  PRIMARY KEY (`kd_kategori`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES ('K001','RADIO','RADIO'),('K002','Arrester Eth-sp','Perlindungan ke jaringan'),('K003','Access Point','Menerima Akses Internet'),('K004','Modem','Penghubung Perangkat ke Internet'),('K005','Adaptor ','Penghubung Antara Kabel '),('K006','AKI','Baterai'),('K007','Barel RJ','Barel RJ'),('K008','BOLT ','BOLT '),('K009','BOX ODP ','BOX ODP '),('K010','CCTV','Kamera'),('K011','China Mobile','China Mobile'),('K012','Cloud Switch','CRS'),('K013','Corong Radio','Pengeras Suara'),('K014','Epon','Pengubah Sinyal optik menjadi sinyal listrik'),('K015','Fiber Optical Switch','saklar Ethernet serat optik'),('K016','Finger Print','Alat Absen Karyawan'),('K017','Giga Ethernet ','transmisi frame Ethernet pada tingkat gigabit per detik'),('K018','Kabel','Kabel Jaringan isi 6'),('K019','Kipas Server','Pendingin perangkat'),('K020','MC','Perhitungan selisih'),('K021','Mikrotik','kabel jaringan'),('K022','NanoStation AC Loco','NanoStation AC Loco'),('K023','OLT','Optical Line Terminal'),('K024','Patchcore','menghubungkan perangkat pasif ke aktif'),('K025','Pigtail','konektor pembaca sinyal'),('K026','PoE Adaptor ','kabel jaringan Ethernet yang menyalurkan tenaga listrik tanpa perlu melakukan penarikan kabel power'),('K027','Power Inverter','Kabel Listrik AC/DC'),('K028','Prolink','UPS'),('K029','Protect FO','Protect FO'),('K030','Roset',' konektor terminal pesawat jaringan'),('K031','SFP','mengubah sinyal elektrik menjadi sinyal optik'),('K032','SPL','Startup Project Leadership'),('K033','Splitter',' komponen optik pasif yang dapat membagi sinar yang datang menjadi dua atau lebih sinar'),('K034','STB','mengonversi sinyal digital menjadi gambar dan suara'),('K035','Switch ','Switch '),('K036','TV Box','TV Box'),('K037','Unifi AP AC Pro Ceiling ','Unifi AP AC Pro Celling '),('K038','UPS','UPS'),('K039','USB','USB'),('K040','Xpon ONU','Xpon ONU'),('K041','Walkie Talkie','Alat Komunikasi'),('K042','Splicer ','Mesin penyambung kabel '),('K043','Baterai','Baterai'),('K044','Printer','Printer'),('K045','Media Converter ','Media Converter '),('K046','Tali','Tali'),('K047','Safety','Keamanan'),('K048','Connector','connector'),('K049','Tang','Tang'),('K050','Router ','Router'),('K051','Double Tape','Double Tape'),('K052','Alat FO','Alat FO'),('K053','Kendaraan','Operasional Kantor'),('K054','Alat Kantor','Tas Laptop');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_data_service`
--

DROP TABLE IF EXISTS `log_data_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_data_service` (
  `id_log_service` int NOT NULL AUTO_INCREMENT,
  `no_service` char(7) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_service` date NOT NULL,
  `kd_vendor_service` char(7) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `kd_petugas` char(5) COLLATE utf8mb4_general_ci NOT NULL,
  `aktivitas` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log_service`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_data_service`
--

LOCK TABLES `log_data_service` WRITE;
/*!40000 ALTER TABLE `log_data_service` DISABLE KEYS */;
INSERT INTO `log_data_service` VALUES (1,'SS00004','2023-10-12','V001','','P001','Input Data','0000-00-00 00:00:00'),(2,'SS00005','2023-10-12','V001','','P001','Input Data','0000-00-00 00:00:00'),(3,'SS00006','2023-10-02','V001','','P001','Input Data','2023-10-12 07:38:57'),(4,'SS00006','2023-10-05','V001','','P002','Input Data','2023-10-18 05:07:30'),(5,'SS00007','2023-10-18','V002','','P002','Input Data','2023-10-18 05:08:27'),(6,'SS00001','2023-11-20','V001','','P001','Input Data','2023-11-20 02:47:58'),(7,'SS00001','2023-11-23','V001','','P001','Input Data','2023-11-23 04:40:20');
/*!40000 ALTER TABLE `log_data_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lokasi`
--

DROP TABLE IF EXISTS `lokasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lokasi` (
  `kd_lokasi` char(5) NOT NULL,
  `nm_lokasi` varchar(100) NOT NULL,
  `kd_departemen` char(4) NOT NULL,
  PRIMARY KEY (`kd_lokasi`),
  KEY `foreign` (`kd_departemen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lokasi`
--

LOCK TABLES `lokasi` WRITE;
/*!40000 ALTER TABLE `lokasi` DISABLE KEYS */;
INSERT INTO `lokasi` VALUES ('L0001','SMP PGRI RAWALUMBU','D001'),('L0002','CV. Alfisa Bekasi','D001'),('L0003','PT. ACBOS Indonesia','D001'),('L0004','CV. Sukses Karya Mandiri','D002'),('L0005','Dinas Lingkungan Hidup dan Pertahanan Provinsi Sumatera Selatan','D002'),('L0006','Pabrik Bihun','D002'),('L0007','PT. Astaka Dodol','D002'),('L0008','PT. Astaka Dodol (Mess)','D002'),('L0009','PT. Baturona Adimulya','D002'),('L0010','PT. Baturona Adimulya (Pelabuhan)','D002'),('L0011','PT. Cendikia Global Solusi','D002'),('L0012','PT. Fortuna Marina Sejahtera','D002'),('L0013','PT. Fossa Bara Indonesia','D002'),('L0014','PT. Gelumbang Agro Santosa','D002'),('L0015','PT. Indosat, Tbk (Adidaya)','D002'),('L0016','PT. Indosat, Tbk (Eksisting)','D002'),('L0017','PT. Indosat, Tbk (Mitra Integrasi)','D002'),('L0018','PT. Indosat, Tbk (Fassy)','D002'),('L0019','PT. Indosat, Tbk (Nettocyber)','D002'),('L0020','PT. Karya Pacific Shipping (HO)','D002'),('L0021','PT. Karya Pacific Shipping (Palembang)','D002'),('L0022','PT. Laras Karya Kahuripan','D002'),('L0023','PT. Lumbung Pangan Banyuasin','D002'),('L0024','PT. Musi Lintas Permata','D002'),('L0025','PT. Nettocyber Indonesia','D002'),('L0026','PT. Penjaminan Kredit Sumsel (Baturaja)','D002'),('L0027','PT. Penjaminan Kredit Sumsel (HO)','D002'),('L0028','PT. Penjaminan Kredit Sumsel (Linggau)','D002'),('L0029','PT. Penjaminan Kredit Sumsel (Sekayu)','D002'),('L0030','PT. Pinago Utama (HO)','D002'),('L0031','PT. Pinago Utama, Tbk (Metro E)','D002'),('L0032','PT. Pinago Utama, Tbk (Site Sekayu)','D002'),('L0033','PT. Pratama Palm Abadi','D002'),('L0034','PT. Rambang Agro Jaya','D002'),('L0035','PT. Rizki Tujuhbelas Kelola','D002'),('L0036','PT. Roempoen 6 Bersaudara','D002'),('L0037','PT. Solusi Mitra Kreasindo','D002'),('L0038','PT. Surya Agro Persada','D002'),('L0039','PT. Sutopo Lestari Jaya','D002'),('L0040','PT. Swarna Dwipa Sumsel Gemilang','D002'),('L0041','PT. Tedmond Indonesia','D002'),('L0042','PT. Triantama Skip Sejahtera','D002'),('L0043','PT. Tunas Auto Graha','D002'),('L0044','PT. Tunas Auto Graha (Linggau)','D002'),('L0045','PT. Tunas Auto Graha (Muara Enim)','D002'),('L0046','PT. Tunas Auto Graha (Prabumulih)','D002'),('L0047','PT. Visioner Maju Bersama','D002'),('L0048','PT. Wanapotensi Guna','D002'),('L0049','PT. Wanapotensi Guna (Office)','D002'),('L0050','SD Negeri 01 Palembang','D002'),('L0051','SMAN 1 Air Saleh (Cyber)','D002'),('L0052','PT Sinar Baru Wijaya Perkasa Site Sekayu ( PSS Palembang )','D004'),('L0053','CV Artha Rasindo ( PSS Palembang ) ','D004'),('L0054',' PT Bank Mandiri Kec Palembang Sukajadi ( KM12 ) ','D004'),('L0055','Gachi Korean Restaurant  ( PSS Palembang ) ','D004'),('L0056','PT. Hamita Utama Karsa','D002'),('L0057','Kantor Camat Sako ( PSS Palembang )','D004'),('L0058','Kantor NHT Bekasi','D001'),('L0059','Balai Karantina Hewan,Ikan Tumbuhan','D004'),('L0060','PT. Indosat, Tbk (BULUH CAWANG)','D002'),('L0061','PT. Indonusa Agromulia','D002'),('L0062','PT. Golden Blossom Sumatera','D002');
/*!40000 ALTER TABLE `lokasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mutasi`
--

DROP TABLE IF EXISTS `mutasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mutasi` (
  `no_mutasi` char(7) NOT NULL,
  `tgl_mutasi` date NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_mutasi`),
  KEY `foreign_petugas` (`kd_petugas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mutasi`
--

LOCK TABLES `mutasi` WRITE;
/*!40000 ALTER TABLE `mutasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `mutasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mutasi_asal`
--

DROP TABLE IF EXISTS `mutasi_asal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mutasi_asal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_mutasi` char(7) NOT NULL,
  `no_penempatan_lama` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `foreign` (`kd_inventaris`,`no_mutasi`,`no_penempatan_lama`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mutasi_asal`
--

LOCK TABLES `mutasi_asal` WRITE;
/*!40000 ALTER TABLE `mutasi_asal` DISABLE KEYS */;
/*!40000 ALTER TABLE `mutasi_asal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mutasi_tujuan`
--

DROP TABLE IF EXISTS `mutasi_tujuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mutasi_tujuan` (
  `no_mutasi` char(7) NOT NULL,
  `no_penempatan` char(7) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  KEY `foreign` (`no_mutasi`,`no_penempatan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mutasi_tujuan`
--

LOCK TABLES `mutasi_tujuan` WRITE;
/*!40000 ALTER TABLE `mutasi_tujuan` DISABLE KEYS */;
/*!40000 ALTER TABLE `mutasi_tujuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opname`
--

DROP TABLE IF EXISTS `opname`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opname` (
  `kd_opname` char(5) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  `tahun_opname` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `foto_barang` varchar(255) NOT NULL,
  `status` varchar(25) NOT NULL,
  PRIMARY KEY (`kd_opname`),
  KEY `foreign` (`kd_petugas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opname`
--

LOCK TABLES `opname` WRITE;
/*!40000 ALTER TABLE `opname` DISABLE KEYS */;
/*!40000 ALTER TABLE `opname` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opname_item`
--

DROP TABLE IF EXISTS `opname_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opname_item` (
  `kd_opname` char(5) NOT NULL,
  `kd_inventaris` varchar(12) NOT NULL,
  KEY `foreign` (`kd_opname`,`kd_inventaris`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opname_item`
--

LOCK TABLES `opname_item` WRITE;
/*!40000 ALTER TABLE `opname_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `opname_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pegawai`
--

DROP TABLE IF EXISTS `pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pegawai` (
  `kd_pegawai` char(5) NOT NULL,
  `nm_pegawai` varchar(100) NOT NULL,
  `kd_departemen` char(4) NOT NULL,
  `jns_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(12) NOT NULL,
  PRIMARY KEY (`kd_pegawai`),
  KEY `foreign_departemen` (`kd_departemen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pegawai`
--

LOCK TABLES `pegawai` WRITE;
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
INSERT INTO `pegawai` VALUES ('P0001','Abdus somad','D001','Laki-laki','Kav. Sawah Indah, Marga Mulya, Bekasi Utara','087880202474'),('P0002','Anggun Nur Maulidya','D001','Perempuan','Jl. BKKBN NO. 33 rt03/07, Mustika Jaya, Bekasi','089527522894'),('P0003','Fadilah Nur Aulia','D001','Perempuan','Kp. Rawa panjang Jl. Siliwangi Gg. Hj. Jole RT 003/004 Kel. Sepanjang Jaya Kec. Rawalumbu Kota Bekasi Jawa Barat','089533402443'),('P0004','Muhamad Ridwan Ahfi','D001','Laki-laki','Kp. Pintu Air RT 001 RW 007 Kel. Harapan Mulya, Kec. Medan Satria Kota Bekasi 17143','089630918829'),('P0005','Mustofa','D001','Laki-laki','Alamanda Regency Blok G7 no 08 RT 021/030','089560569326'),('P0006','Pitriani Sri Rahayu','D001','Perempuan','Graha Asri Residence Blok F 11  No.06','085722142795'),('P0007','Reza Novian Saputra','D001','Laki-laki','Gedung Sari','082124869388'),('P0008','Rizki Alfiatun Hasanah ','D001','Perempuan','Kel. Ori, RT.002 RW.002, Kec. Kuwarasan, Kab. Kebumen ','083848801718'),('P0009','Sri Rahayu ','D001','Perempuan','Jl. Kemandoran No. 18 RT 007/RW 022, Pekayon Jaya, Bekasi Selatan ','08118717606'),('P0010','Nurjanah','D002','Perempuan','Jl. Budar Blok B no. 11 C','081281191910'),('P0011','Fadli','D002','Laki-laki','Jl.Talang Kerangga Lr.Langgar RT.20 RW.07 No.354','088274382517'),('P0012','Egan Baretta Junior','D002','Laki-laki','Jl. Swakarsa RT 42 RW 08 Kel. Kemang Agung kec.kertapati Palembang','082176209569'),('P0013','Andika Berades','D002','Laki-laki','Jl. Sriwijaya raya kec.kertapati kota palembang sumatera selatan','082179078982'),('P0014','Daniel','D002','Laki-laki','Tepi Sungai Ogan','083104731034'),('P0015','Putra  ','D002','Laki-laki','Jl. Husin Basri Perum GSI-2 Blok H-12 RT 006 RW 001 Kel. Sukamulya Kec. Sematang Borang','085383691755'),('P0016','Sri Rahmawati','D002','Perempuan','Jalan Batu Dua RT 032 RW 006 Kelurahan 13 Ulu Kecamatan Seberang Ulu 2 Kota Palembang Sumatera Selatan','085161424116'),('P0017','Chaca Riandya Rahmawan','D002','Laki-laki','Dusun Ceuri Rt 002/006 Kel. Surian Kec Surian Kab. Sumedang','08567936236'),('P0018','Yudi handriyanto','D002','Laki-laki','Jln. Padang selasa rt. 18 rw. 06 no. 20 ilir barat 1','083849415370'),('P0019','Aldo Anusapati Kenri','D002','Laki-laki','Jl Netar Jaya Sukorejo Rt 012 Rw 02','089681843179'),('P0020','M Rizal Fachruddin','D002','Laki-laki','Jl.Hikmah Sukorejo No.27','08982028924'),('P0021','Robi Ultsani AR','D002','Laki-laki','Jl.Ki Merogan Lr.Wijaya RT035/007','085158555404'),('P0022','Ria febrianti','D002','Perempuan','JL Mayor Zen Lr Peternakan','085788619515'),('P0023','Hari Septian Haji Riansah','D002','Laki-laki','Komplek Taman Mekar Sari Lr.Melati Blok C 7 Rt.28 Rw.01 Kel.Talang Jambe Kec.Sukarame','085764155122');
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peminjaman` (
  `no_peminjaman` char(7) NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `tgl_akan_kembali` date NOT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `kd_pegawai` char(5) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `status_kembali` enum('Pinjam','Kembali') NOT NULL DEFAULT 'Pinjam',
  `kd_petugas` char(4) NOT NULL,
  `form_bast` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`no_peminjaman`),
  KEY `foreign` (`kd_pegawai`,`kd_petugas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman_item`
--

DROP TABLE IF EXISTS `peminjaman_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peminjaman_item` (
  `no_peminjaman` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  KEY `foreign` (`no_peminjaman`,`kd_inventaris`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman_item`
--

LOCK TABLES `peminjaman_item` WRITE;
/*!40000 ALTER TABLE `peminjaman_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `peminjaman_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penempatan`
--

DROP TABLE IF EXISTS `penempatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penempatan` (
  `no_penempatan` char(7) NOT NULL,
  `tgl_penempatan` date NOT NULL,
  `kd_lokasi` char(5) NOT NULL,
  `kd_departemen` char(4) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `jenis` enum('Baru','Mutasi') NOT NULL DEFAULT 'Baru',
  `kd_petugas` char(4) NOT NULL,
  `form_bast` longtext,
  PRIMARY KEY (`no_penempatan`),
  KEY `foreign` (`kd_lokasi`,`kd_departemen`,`kd_petugas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penempatan`
--

LOCK TABLES `penempatan` WRITE;
/*!40000 ALTER TABLE `penempatan` DISABLE KEYS */;
INSERT INTO `penempatan` VALUES ('PB00001','2024-11-16','L0012','D002',NULL,'Baru','P001','file0');
/*!40000 ALTER TABLE `penempatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penempatan_item`
--

DROP TABLE IF EXISTS `penempatan_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penempatan_item` (
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `status_aktif` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  KEY `foreign` (`no_penempatan`,`kd_inventaris`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penempatan_item`
--

LOCK TABLES `penempatan_item` WRITE;
/*!40000 ALTER TABLE `penempatan_item` DISABLE KEYS */;
INSERT INTO `penempatan_item` VALUES ('PB00001','B0001.000006','Yes');
/*!40000 ALTER TABLE `penempatan_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengadaan`
--

DROP TABLE IF EXISTS `pengadaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengadaan` (
  `no_pengadaan` char(7) NOT NULL,
  `tgl_pengadaan` date NOT NULL,
  `kd_supplier` char(5) DEFAULT NULL,
  `jenis_pengadaan` varchar(100) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `kd_petugas` char(4) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `foto_form` varchar(255) DEFAULT NULL,
  `status_approval` enum('Approve','Belum Approve','-') NOT NULL,
  `nomor_resi` varchar(255) DEFAULT NULL,
  `kd_departemen` char(4) DEFAULT NULL,
  `kd_lokasi` char(5) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`no_pengadaan`),
  KEY `foreign` (`kd_supplier`,`kd_petugas`,`kd_departemen`,`kd_lokasi`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengadaan`
--

LOCK TABLES `pengadaan` WRITE;
/*!40000 ALTER TABLE `pengadaan` DISABLE KEYS */;
INSERT INTO `pengadaan` VALUES ('BB00001','2024-01-02','A0003','Pembelian','Keperluan Troubleshoot PT R6B Site Gunung Raja','P001','Pengadaan Barang Keperluan Troubleshoot PT R6B Site Gunung Raja.pdf','','-','','','',NULL),('BB00002','2024-01-02','A0004','Pembelian','Keperluan Troubleshoot PT R6B Site Gunung Raja','P001','Pengadaan Barang Keperluan Troubleshoot PT R6B Site Gunung Raja.pdf','','-','','','',NULL),('BB00003','2024-01-05','A0001','Pembelian','Barang Instalasi Kantor Kementrian Kelautan Dan Perikanan Sumsel','P001','Pengadaan Barang Instalasi Kantor Kementrian Kelautan Dan Perikanan Sumsel (1).rar','','-','','','',NULL),('BB00004','2024-01-11','A0005','Pembelian','Barang Keperluan Tools Kantor NHT Palembang','P001','Pengadaan Barang Keperluan Tools Kantor NHT Palembang.rar','','-','','','',NULL),('BB00005','2024-01-15','A0003','Pembelian','Barang Keperluan Troubleshoot Dispora','P001','Pengaaan Barang Keperluan Troubleshoot Dispora.rar','','-','','','',NULL),('BB00006','2024-01-15','A0004','Pembelian','Barang Keperluan Troubleshoot PT Sutopo Jaya Lestari','P001','Pengadaan Barang Keperluan Troubleshoot PT Sutopo Jaya Lestari.rar','','-','','','',NULL),('BB00007','2024-01-15','A0003','Pembelian','Barang Keperluan Troubleshoot PT Sutopo Jaya Lestari','P001','Pengadaan Barang Keperluan Troubleshoot PT Sutopo Jaya Lestari.rar','','-','','','',NULL),('BB00008','2024-01-16','A0006','Pembelian',' Barang Tools Kantor Palembang','P001','Pengadaan Barang Tools Kantor Palembang.rar','','-','','','',NULL),('BB00009','2024-01-19','A0003','Pembelian','Barang Keperluan Instalasi PT Bina Sarana Sukses','P001','Pengadaan Barang Keperluan Instalasi PT Bina Sarana Sukses.rar','','-','','','',NULL),('BB00010','2024-01-19','A0003','Pembelian','Barang Keperluan Troubleshoot STO Road Sungai Lilin','P001','Pengadaan Barang Keperluan Troubleshoot STO Road Sungai Lilin.rar','','-','','','',NULL),('BB00011','2024-01-19','A0001','Pembelian','Barang Keperluan Spare Kantor NHT Solution','P001','Pengadaan Barang Keperluan Spare Kantor NHT Solution.rar','','-','','','',NULL),('BB00012','2024-01-24','A0003','Pembelian',' Barang Keperluan Troubleshoot PT R6B Site Payakabung','P001','Reimburs Beli Barang Keperluan Troubleshoot PT R6B Site Payakabung.rar','','-','','','',NULL),('BB00013','2024-01-25','A0003','Pembelian','Barang Troubleshoot PT Sutopo Jaya Lestari','P001','Pengadaan Barang Troubleshoot PT Sutopo Jaya Lestari.rar','','-','','','',NULL),('BB00014','2024-01-25','A0004','Pembelian','Barang Troubleshoot PT Sutopo Jaya Lestari','P001','Pengadaan Barang Troubleshoot PT Sutopo Jaya Lestari.rar','','-','','','',NULL),('BB00025','2024-02-02','A0001','Pembelian',' Barang Keperluan Perangkat Radio PT Golden Great Borneo','P001','Pengadaan Barang Keperluan Perangkat Radio PT Golden Great Borneo.rar','','-','','','',NULL),('BB00016','2024-02-13','A0005','Pembelian',' Barang Keperluan Upgrade PT Pratama Palm Abadi (PT PPA)','P001','Pengadaan Barang Keperluan Upgrade PT Pratama Palm Abadi (PT PPA).rar','','-','','','',NULL),('BB00017','2024-02-13','A0006','Pembelian','Barang Keperluan Instalasi Project MV HOME','P001','Pengadaan Barang Keperluan Instalasi Project MV HOME.rar','','-','','','',NULL),('BB00018','2024-02-13','A0006','Pembelian',' Barang Keperluan Instalasi Project MV HOME','P001','','','-','','','',NULL),('BB00019','2024-02-16','A0004','Pembelian','Barang Troubleshoot PT Penjaminan Kredit Site Palembang','P001','Pengadaan Barang Troubleshoot PT Penjaminan Kredit Site Palembang.rar','','-','','','',NULL),('BB00020','2024-02-19','A0003','Pembelian','Barang Troubleshoot PT Pratama Palm Abadi','P001','WhatsApp Image 2024-04-19 at 15.19.30.jpeg','','-','','','',NULL),('BB00026','2024-02-02','A0007','Pembelian','Barang Keperluan Perangkat Radio PT Golden Great Borneo','P001','Pengadaan Barang Keperluan Perangkat Radio PT Golden Great Borneo.rar','','-','','','',NULL),('BB00027','2024-02-20','A0007','Pembelian','Barang Replace Perangkat Troubleshoot PT Sutopo Jaya Lestari','P001','Pengadaan Barang Replace Perangkat Ts PT Sutopo Jaya Lestari.rar','','-','','','',NULL),('BB00023','2024-02-20','A0003','Pembelian','Barang Troubleshoot PT Nettocyber Site Lakitan Dan Riam','P001','Pengadaan Barang Troubleshoot PT Nettocyber Site Lakitan Dan Riam.rar','','-','','','',NULL),('BB00024','2024-02-20','A0004','Pembelian',' Barang Troubleshoot PT Nettocyber Site Lakitan Dan Riam','P001','Pengadaan Barang Troubleshoot PT Nettocyber Site Lakitan Dan Riam.rar','','-','','','',NULL),('BB00028','2024-02-20','A0001','Pembelian','Barang Replace Perangkat Troubleshoot PT Sutopo Jaya Lestari','P001','Pengadaan Barang Replace Perangkat Ts PT Sutopo Jaya Lestari.rar','','-','','','',NULL),('BB00029','2024-02-20','A0007','Pembelian','Barang Replace Perangkat Troubleshoot STO Road Sungai Lilin','P001','Pengadaan Barang Replace Perangkat Ts STO Road Sungai Lilin.rar','','-','','','',NULL),('BB00030','2024-02-20','A0001','Pembelian',' Barang Replace Perangkat Troubleshoot STO Road Sungai Lilin','P001','Pengadaan Barang Replace Perangkat Ts STO Road Sungai Lilin.rar','','-','','','',NULL),('BB00031','2024-02-20','A0007','Pembelian','Barang Upgrade PT Pratama Palm Abadi (PT PPA)','P001','Pengadaan Barang Keperluan Upgrade PT Pratama Palm Abadi (PT PPA).rar','','-','','','',NULL),('BB00032','2024-02-26','A0004','Pembelian','Barang Troubleshoot Jamkrida Site Palembang','P001','Pengadaan Barang Troubleshoot Jamkrida Site Palembang.rar','','-','','','',NULL),('BB00033','2024-02-27','A0003','Pembelian','Barang Keperluan Relokasi PT Penjaminan Kredit Site Lubuk Lingau','P001','Pengadaan Barang Keperluan Relokasi PT Penjaminan Kredit Site Lubuk Lingau.rar','','-','','','',NULL),('BB00034','2024-02-27','A0004','Pembelian','Barang Keperluan Relokasi PT Penjaminan Kredit Site Lubuk Lingau','P001','Pengadaan Barang Keperluan Relokasi PT Penjaminan Kredit Site Lubuk Lingau.rar','','-','','','',NULL),('BB00035','2024-02-27','A0007','Pembelian','Barang Keperluan Relokasi PT Penjaminan Kredit Site Lubuk Lingau','P001','Pengadaan Barang Keperluan Relokasi PT Penjaminan Kredit Site Lubuk Lingau.rar','','-','','','',NULL),('BB00036','2024-02-27','A0004','Pembelian','Barang Keperluan Upgrade PT Pratama Palm Abadi ','P001','Pengadaan Barang Keperluan Upgrade PT Pratama Palm Abadi.rar','','-','','','',NULL),('BB00037','2024-02-27','A0001','Pembelian',' Barang Replace Perangkat Troubleshoot PT Baturona Adhimulya','P001','Pengadaan Barang Replace Perangkat Troubleshoot PT Baturona Adhimulya.rar','','-','','','',NULL),('BB00038','2024-02-27','A0004','Pembelian',' Barang Replace Perangkat Troubleshoot PT Baturona Adhimulya','P001','Pengadaan Barang Replace Perangkat Troubleshoot PT Baturona Adhimulya.rar','','-','','','',NULL),('BB00039','2024-02-27','A0001','Pembelian',' Barang Replace Perangkat Troubleshoot PT Pratama Palm Abadi','P001','Pengadaan Barang Replace Perangkat Troubleshoot PT Pratama Palm Abadi.rar','','-','','','',NULL),('BB00040','2024-02-27','A0001','Pembelian','Barang Replace Perangkat Ts PT Jambi Semesta Biomassa Pematang Lumut','P001','Peng. Barang Replace Perangkat Ts PT Jambi Semesta Biomassa Pematang Lumut.rar','','-','','','',NULL),('BB00041','2024-02-27','A0001','Pembelian','Barang Keperluan Instalasi PT Golden Great Borneo','P001','Pengadaan Barang Keperluan Instalasi PT Golden Great Borneo.rar','','-','','','',NULL),('BB00042','2024-02-27','A0002','Pembelian','Barang Instalasi PT Nettocyber (VELO) Site SEI Gn. Malayu & SEI Rumbuyah Estate','P001','Barang Instalasi PT Nettocyber (VELO) Site SEI Gn. Malayu & SEI Rumbuyah Estate.rar','','-','','','',NULL),('BB00043','2024-02-27','A0001','Pembelian','Barang Instalasi PT Nettocyber (VELO) Site SEI Gn. Malayu & SEI Rumbuyah Estate','P001','','','-','','','',NULL),('BB00046','2024-02-27','A0003','Pembelian',' Barang Instalasi PT Nettocyber (VELO) Site SEI Gn. Malayu & SEI Rumbuyah Estate','P001','Barang Instalasi PT Nettocyber (VELO) Site SEI Gn. Malayu & SEI Rumbuyah Estate.rar','','-','','','',NULL),('BB00045','2024-02-27','A0007','Pembelian',' Barang Instalasi PT Nettocyber (VELO) Site SEI Gn. Malayu & SEI Rumbuyah Estate','P001','Barang Instalasi PT Nettocyber (VELO) Site SEI Gn. Malayu & SEI Rumbuyah Estate.rar','','-','','','',NULL),('BB00047','2024-03-07','A0003','Pembelian',' Barang Keperluan Instalasi Balai Karantina Hewan, Ikan Tumbuhan','P001','','','-','','','',NULL),('BB00048','2024-03-07','A0004','Pembelian','Barang Keperluan Instalasi Balai Karantina Hewan, Ikan Tumbuhan','P001','','','-','','','',NULL),('BB00049','2024-03-07','A0007','Pembelian',' Barang Keperluan Instalasi Balai Karantina Hewan, Ikan Tumbuhan','P001','','','-','','','',NULL),('BB00050','2024-03-07','A0004','Pembelian',' Barang Keperluan Instalasi Balai Pemantapan Kawasan Hutan','P001','','','-','','','',NULL),('BB00051','2024-03-07','A0007','Pembelian',' Barang Keperluan Instalasi Balai Pemantapan Kawasan Hutan','P001','','','-','','','',NULL),('BB00052','2024-03-07','A0003','Pembelian',' Barang Keperluan Instalasi Bank Bukopin Cab PLG (Ramayana)','P001','','','-','','','',NULL),('BB00053','2024-04-20','A0004','Pembelian',' Barang Keperluan Instalasi Bank Bukopin Cab PLG (Ramayana)','P001','','','-','','','',NULL),('BB00054','2024-03-13','A0001','Pembelian',' Barang Keperluan Replace Perangkat Instalasi Balai Karantina HIT','P001','','','-','','','',NULL),('BB00055','2024-03-13','A0001','Pembelian','Barang Keperluan Replace Perangkat Instalasi Bank Bukopin (Ramayana)','P001','','','-','','','',NULL),('BB00056','2024-03-15','A0003','Pembelian','Barang Keperluan Instalasi PT Astaka Dodol (Mess)','P001','','','-','','','',NULL),('BB00057','2024-03-15','A0007','Pembelian',' Barang Keperluan Instalasi PT Astaka Dodol (Mess)','P001','','','-','','','',NULL),('BB00058','2024-03-15','A0003','Pembelian','Barang Keperluan Instalasi PT Astaka Dodol (Mess)','P001','','','-','','','',NULL),('BB00059','2024-03-15','A0004','Pembelian',' Barang Keperluan Instalasi PT Astaka Dodol (Mess)','P001','','','-','','','',NULL),('BB00060','2024-03-15','A0001','Pembelian','Barang Keperluan Instalasi PT Astaka Dodol (Mess)','P001','','','-','','','',NULL),('BB00061','2024-03-23','A0001','Pembelian','Barang Keperluan Spare Kantor NHT Palembang','P001','','','-','','','',NULL),('BB00062','2024-03-25','A0004','Pembelian','Barang Keperluan Replace Perangkat PT Sutopo Lestari Jaya','P001','','','-','','','',NULL),('BB00063','2024-03-25','A0003','Pembelian','Barang Keperluan Replace Perangkat PT Nettocyber Site Riam','P001','','','-','','','',NULL),('BB00064','2024-04-20','A0001','Pembelian','','P001','','','-','','','',NULL),('BB00065','2024-04-20','A0003','Pembelian','Barang Keperluan Instalasi PT Hevea MK 2','P001','','','-','','','',NULL),('BB00066','2024-04-20','A0004','Pembelian','Barang Keperluan Instalasi PT Hevea MK 2','P001','','','-','','','',NULL),('BB00067','2024-04-21','A0001','Pembelian','Barang Keperluan Instalasi PT Remco Rubber','P001','','','-','','','',NULL),('BB00068','2024-04-21','A0003','Pembelian','Barang Keperluan Instalasi PT Remco Rubber','P001','','','-','','','',NULL),('BB00069','2024-04-21','A0004','Pembelian','Barang Keperluan Instalasi PT Remco Rubber','P001','','','-','','','',NULL),('BB00070','2024-04-21','A0007','Pembelian','Barang Keperluan Instalasi PT Remco Rubber','P001','','','-','','','',NULL),('BB00071','2024-04-21','A0001','Pembelian','Barang Keperluan Instalasi PT Sunan Rubber','P001','','','-','','','',NULL),('BB00072','2024-04-21','A0003','Pembelian','Barang Keperluan Instalasi PT Sunan Rubber','P001','','','-','','','',NULL),('BB00073','2024-04-21','A0004','Pembelian','Barang Keperluan Instalasi PT Sunan Rubber','P001','','','-','','','',NULL),('BB00074','2024-04-21','A0007','Pembelian','Barang Keperluan Instalasi PT Sunan Rubber','P001','','','-','','','',NULL),('BB00075','2024-04-22','A0007','Pembelian','Barang Keperluan Instalasi PT Astaka Dodol (Mess)','P001','','','-','','','',NULL),('BB00076','2024-03-15','A0001','Pembelian','Barang Keperluan Instalasi PT Astaka Dodol (Mess)','P001','','','-','','','',NULL),('BB00077','2024-04-22','A0001','Pembelian','Barang Keperluan Instalasi PT Astaka Dodol (Mess)','P001','','','-','','','',NULL),('BB00078','2024-03-15','A0001','Pembelian','Barang Keperluan Instalasi PT Astaka Dodol (Mess)','P001','','','-','','','',NULL),('BB00079','2024-03-15','A0005','Pembelian','Pengadaan Tali Keperluan Kantor Palembang','P001','','','-','','','',NULL),('BB00080','2024-03-06','A0004','Pembelian','Barang Keperluan Troubleshoot PT Astaka Dodol','P001','','','-','','','',NULL),('BB00081','2024-03-07','A0007','Pembelian','Barang Keperluan Instalasi Balai Karantina Hewan, Ikan Tumbuhan','P001','','','-','','','',NULL),('BB00082','2024-04-22','A0007','Pembelian','Barang Keperluan Instalasi Balai Pemantapan Kawasan Hutan','P001','','','-','','','',NULL),('BB00083','2024-03-21','A0005','Pembelian','Barang Spare Kantor NHT Palembang','P001','','','-','','','',NULL),('BB00084','2024-03-28','A0007','Pembelian','Pengadaan Barang Keperluan Instalasi Mess PT Astaka Dodol','P001','','','-','','','',NULL),('BB00085','2024-03-28','A0006','Pembelian','Alat Safety Teknisi NHT Solution Palembang','P001','','','-','','','',NULL),('BB00086','2024-01-10','A0006','Pembelian','Barang Keperluan Wifi Rumah','P001','','','-','','','',NULL),('BB00087','2024-01-11','A0001','Pembelian','Barang Spare Inet NHT Bekasi','P001','','','-','','','',NULL),('BB00088','2024-01-11','A0002','Pembelian','Barang Spare Inet NHT Bekasi','P001','','','-','','','',NULL),('BB00089','2024-01-11','A0006','Pembelian','Barang Spare Inet NHT Bekasi','P001','','','-','','','',NULL),('BB00090','2024-01-23','A0001','Pembelian',' Barang Keperluan PT First Solution Indonesia (FSI) (SMK)','P001','','','-','','','',NULL),('BB00091','2024-02-01','A0001','Pembelian',' Barang Spare Keperluan Inet Rumah','P001','','','-','','','',NULL),('BB00092','2024-02-01','A0006','Pembelian','Barang Spare Keperluan Inet Rumah','P001','','','-','','','',NULL),('BB00093','2024-02-01','A0006','Pembelian','Barang Spare Keperluan Inet Rumah','P001','','','-','','','',NULL),('BB00094','2024-02-16','A0006','Pembelian','Barang Spare Troubleshoot Inet Rumah','P001','','','-','','','',NULL),('BB00095','2024-02-22','A0006','Pembelian','Kabel Buat Inet Rumah','P001','','','-','','','',NULL),('BB00096','2024-02-23','A0006','Pembelian','Barang Stock Perlengkapan Inet Rumah','P001','','','-','','','',NULL),('BB00097','2024-02-27','A0006','Pembelian','Kabel Spare Inet Bekasi','P001','','','-','','','',NULL),('BB00098','2024-03-06','A0006','Pembelian','Barang Keperluan Wifi Rumah','P001','','','-','','','',NULL),('BB00099','2024-03-08','A0006','Pembelian','Spare Barang Inet NHT Bekasi','P001','','','-','','','',NULL),('BB00100','2024-03-18','A0006','Pembelian','Spare Barang Buat Inet Rumah','P001','','','-','','','',NULL),('BB00101','2024-03-26','A0006','Pembelian','Barang Maintenance Inet Rumah','P001','','','-','','','',NULL),('BB00102','2024-05-29','A0008','Pembelian','Service Mobil Ferozza BG 1857 ZQ','P003','BEA26F69-DAE4-47A0-A6B7-D3381C8F9885.jpeg','','Approve','','','',NULL),('BB00103','2024-05-29','A0008','Pembelian','Service Mobil Taruna BG 1723 IF','P003','7F63F3ED-92A3-4126-85A0-FBA8DF0067D9.jpeg','','Approve','','','',NULL),('BB00104','2024-05-29','A0006','Pembelian','Keperluan Troubleshoot BTS Indosat Gasing','P003','E2164BE6-57F7-4770-9F8A-C56CA3F2B5E9.jpeg','','Approve','','','',NULL),('BB00105','2024-05-29','A0003','Pembelian','Troubleshoot STO Sungai Lilin','P003','WhatsApp Image 2024-05-29 at 10.15.18.jpeg','','Approve','','','',NULL),('BB00106','2024-05-29','A0007','Pembelian','Troubleshoot STO Sungai Lilin','P003','WhatsApp Image 2024-05-29 at 12.15.24.jpeg','','Approve','','','',NULL),('BB00107','2024-05-29','A0010','Pembelian','Riben Kaca Mobil Ops Kantor ','P003','WhatsApp Image 2024-05-29 at 17.19.37.jpeg','','Approve','','D002','Koson',NULL),('BB00108','2024-06-04','A0011','Pembelian','Service Mobil Ops Kantor Taruna BG 1723 IF ','P003','WhatsApp Image 2024-06-03 at 10.28.40.jpeg','','Approve','','D002','Koson',NULL),('BB00109','2024-06-04','A0005','Pembelian','Untuk Keperluan Kantor NHT Solution Palembang ','P003','WhatsApp Image 2024-06-04 at 12.37.33.jpeg','','Approve','','D002','Koson',NULL),('BB00110','2024-06-04','A0005','Pembelian','Untuk Keperluan Kantor NHT Solution Palembang ','P003','WhatsApp Image 2024-06-04 at 12.09.49.jpeg','','Approve','','D002','Koson',NULL),('BB00111','2024-06-04','A0005','Pembelian','Untuk Keperluan Kantor NHT Solution Palembang ','P003','WhatsApp Image 2024-06-04 at 12.09.02.jpeg','','Approve','','D002','Koson',NULL),('BB00112','2024-06-04','A0005','Pembelian','Untuk Keperluan Kantor NHT Solution Palembang ','P003','WhatsApp Image 2024-06-04 at 10.49.50.jpeg','','Approve','','D002','Koson',NULL),('BB00113','2024-06-04','A0012','Pembelian','Untuk Keperluan Genset Kantor NHT Solution Palembang ','P003','','','Approve','','D002','Koson',NULL),('BB00114','2024-06-12','A0013','Pembelian','Reimburs Biaya Service Genset NHT Solution Palembang','P003','AKI Genset.png','','Approve','','D002','Koson',NULL),('BB00115','2024-06-12','A0013','Pembelian','Reimburs Biaya Service Genset NHT Solution Palembang','P003','Busi & Oli Genset.png','','Approve','','D002','Koson',NULL),('BB00116','2024-06-12','A0013','Pembelian','Reimburs Biaya Service Genset NHT Solution Palembang ','P003','Kunci Busi.png','','Approve','','D002','Koson',NULL),('BB00117','2024-06-12','A0013','Pembelian','Reimburs Biaya Service Genset NHT Solution Palembang','P003','Vitamin.png','','Approve','','D002','Koson',NULL),('BB00118','2024-06-12','A0003','Pembelian','Untuk Keperluan Instalasi CCTV','P003','','','Approve','','D002','L0005',NULL),('BB00119','2024-06-12','A0003','Pembelian','Untuk Keperluan Instalasi PT Sinar Baru Wijaya Perkasa Site Pali','P003','','','Approve','','D005','Koson',NULL),('BB00120','2024-06-12','A0014','Pembelian','Untuk Keperluan Mobil Ops Kantor Terios B 2585 KRE','P003','WhatsApp Image 2024-06-11 at 14.45.54.jpeg','','Approve','','D002','Koson',NULL),('BB00121','2024-06-12','A0014','Pembelian','Untuk Keperluan Mobil Ops Kantor Taruna B 2585 KRE','P003','WhatsApp Image 2024-06-11 at 14.45.54 (1).jpeg','','Approve','','D002','Koson',NULL),('BB00122','2024-06-18','A0014','Pembelian','Untuk Keperluan Mobil Ops Kantor Taruna BG 1723 IF','P003','WhatsApp Image 2024-06-18 at 11.23.10.jpeg','','Approve','','D002','Koson',NULL),('BB00123','2024-06-24','A0001','Pembelian','Untuk Keperluan Upgrade Radio PT Pratama Palm Abadi ( PT PPA )','P003','','','Approve','','D002','L0033',NULL),('BB00124','2024-06-24','A0016','Pembelian','Untuk Keperluan Penambahan Titik Lokasi Kantor Baru PT Baturona Adimulya Site Pelabuhan','P003','WhatsApp Image 2024-06-24 at 11.04.19.jpeg','','Approve','','D002','L0010',NULL),('BB00125','2024-06-24','A0007','Pembelian','Untuk Keperluan Penambahan Titik Lokasi Kantor Baru PT Baturona Adimulya Site Pelabuhan','P003','WhatsApp Image 2024-06-24 at 11.05.55.jpeg','','Approve','','D002','L0010',NULL),('BB00126','2024-06-24','A0007','Pembelian','Untuk Keperluan Penambahan Titik Lokasi Kantor Baru PT Baturona Adimulya Site Pelabuhan','P003','WhatsApp Image 2024-06-24 at 11.05.55.jpeg','','Approve','','D002','L0010',NULL),('BB00127','2024-06-24','A0003','Pembelian','Untuk Keperluan Penambahan Titik Lokasi Kantor Baru PT Baturona Adimulya Site Pelabuhan','P003','WhatsApp Image 2024-06-24 at 11.07.10.jpeg','','Approve','','D002','L0010',NULL),('BB00128','2024-06-24','A0015','Pembelian','Untuk Keperluan Penambahan Titik Lokasi Kantor Baru PT Baturona Adimulya Site Pelabuhan ','P003','WhatsApp Image 2024-06-24 at 11.39.28.jpeg','','Approve','','D002','L0010',NULL),('BB00129','2024-06-27','A0003','Pembelian','Untuk Keperluan Instalasi CV Artha Rasindo ','P003','WhatsApp Image 2024-06-27 at 10.13.12.jpeg','','Approve','','D002','L0053',NULL),('BB00130','2024-06-27','A0003','Pembelian','Untuk Keperluan Instalasi CV Artha Rasindo ','P003','WhatsApp Image 2024-06-27 at 10.12.52.jpeg','','Approve','','D002','L0053',NULL),('BB00131','2024-06-27','A0007','Pembelian','Untuk Keperluan Instalasi CV Artha Rasindo ','P003','WhatsApp Image 2024-06-27 at 10.04.09.jpeg','','Approve','','D002','L0053',NULL),('BB00134','2024-07-17','A0017','Pembelian','Biaya Ganti Ban Standar ke MT Mobil Ops Kantor Terios B 2585 KRE 16072024','P003','WhatsApp Image 2024-07-17 at 12.18.01.jpeg','','Approve','','D002','Koson',NULL),('BB00135','2024-07-17','A0005','Pembelian','Pengadaan Barang Untuk Keperluan Kantor NHT Solution Palembang ','P003','opm baterai.png','','Approve','','D002','Koson',NULL),('BB00133','2024-06-27','A0014','Pembelian','Untuk Keperluan Mobil Ops Kantor Terios B 2585 KRE ','P003','','','Approve','','D002','Koson',NULL),('BB00132','2024-06-27','A0014','Pembelian','Untuk Keperluan Mobil Ops Kantor Terios B 2585 KRE ','P003','WhatsApp Image 2024-06-27 at 08.14.04.jpeg','','Approve','','D002','Koson',NULL),('BB00136','2024-07-17','A0005','Pembelian','Pengadaan Barang Untuk Keperluan Kantor NHT Solution Palembang ','P003','Tangga.png','','Approve','','D002','Koson',NULL),('BB00137','2024-07-24','A0007','Pembelian','Pengadaan Barang Untuk Keperluan Peremajaan Access Point PT Pratama Palm Abadi','P003','WhatsApp Image 2024-07-24 at 13.48.21.jpeg','','Approve','','D002','L0033',NULL),('BB00138','2024-07-26','A0014','Pembelian','Untuk Keperluan Mobil Ops Kantor Taruna BG 1723 IF ','P003','WhatsApp Image 2024-07-25 at 18.25.05 - Copy.jpeg','','Approve','','D002','Koson',NULL),('BB00139','2024-07-31','A0007','Pembelian','Untuk Keperluan Peremajaan PT Pratama Palm Abadi ( PPA)','P003','e98e6fa3-cd3a-4cbc-9964-f31e42b3ae0e.jpg','','Approve','','D002','L0033',NULL),('BB00140','2024-08-06','A0003','Pembelian',' PT Bank Mandiri Kec Palembang Sukajadi ( KM12 ) ','P003','WhatsApp Image 2024-08-06 at 10.29.10.jpeg','','Approve','','D004','L0054',NULL),('BB00141','2024-08-06','A0003','Pembelian',' PT Bank Mandiri Kec Palembang Sukajadi ( KM12 ) ','P003','WhatsApp Image 2024-08-06 at 10.28.37.jpeg','','Approve','','D004','L0054',NULL),('BB00142','2024-08-06','A0007','Pembelian',' PT Bank Mandiri Kec Palembang Sukajadi ( KM12 ) ','P003','WhatsApp Image 2024-08-06 at 09.48.39.jpeg','','Approve','','D004','L0054',NULL),('BB00143','2024-08-13','A0009','Pembelian','Service Mobil Ops Kantor Ferozza BG 1857 ZO ','P003','WhatsApp Image 2024-08-06 at 15.14.14.jpeg','','Approve','','D002','Koson',NULL),('BB00144','2024-08-13','A0001','Pembelian','Pengadaan Barang Untuk Keperluan Spare Kantor NHT Solution Palembang','P003','','','Approve','','D002','Koson',NULL),('BB00145','2024-08-19','A0005','Pembelian','Pengadaan Barang Untuk Keperluan Kantor NHT Solution Palembang ','P003','','','Approve','','D002','Koson',NULL),('BB00146','2024-08-20','A0018','Pembelian','Pengadaan Barang Untuk Keperluan Instalasi Gachi Korean Restaurant ','P003','Mikrotik.jpeg','','Approve','','D004','L0055',NULL),('BB00147','2024-08-20','A0007','Pembelian','Pengadaan Barang Untuk Keperluan Instalasi Gachi Korean Restaurant ','P003','Rujie.jpeg','','Approve','','D004','L0055',NULL),('BB00148','2024-08-20','A0003','Pembelian','Pengadaan Barang Untuk Keperluan Instalasi Gachi Korean Restaurant ','P003','Switch.jpeg','','Approve','','D004','L0055',NULL),('BB00149','2024-08-23','A0009','Pembelian','Biaya Service Mobil Ops Kantor Taruna BG 1723 IF ','P003','WhatsApp Image 2024-08-22 at 17.41.17.jpeg','','Approve','','D002','Koson',NULL),('BB00150','2024-08-23','A0003','Pembelian','Pengadaan Barang Untuk Keperluan Instalasi Gachi Korean Restaurant ','P003','WhatsApp Image 2024-08-23 at 10.54.56.jpeg','','Approve','','D004','L0055',NULL),('BB00151','2024-08-23','A0005','Pembelian','Pengadaan Barang Untuk Keperluan Kantor NHT Solution Palembang ','P003','','','Approve','','D002','Koson',NULL),('BB00152','2024-08-26','A0003','Pembelian','Pengadaan Barang Untuk Keperluan  Troubleshoot PT. Hamita Utama Karsa','P003','WhatsApp Image 2024-08-26 at 12.20.25.jpeg','','Approve','','D002','L0056',NULL),('BB00153','2024-08-26','A0003','Pembelian','Pengadaan Barang Untuk Keperluan Instalasi Kantor Camat Sako','P003','AP Hikvision , RB 951 , RB 750.jpeg','','Approve','','D004','L0057',NULL),('BB00154','2024-08-26','A0003','Pembelian','Pengadaan Barang Untuk Keperluan Instalasi Kantor Camat Sako','P003','8 PORT.jpeg','','Approve','','D004','L0057',NULL),('BB00155','2024-08-26','A0007','Pembelian','Pengadaan Barang Untuk Keperluan Instalasi Kantor Camat Sako','P003','RUJIE.jpeg','','Approve','','D004','L0057',NULL),('BB00156','2024-08-26','A0007','Pembelian','Pengadaan Barang Untuk Keperluan Instalasi Kantor Camat Sako','P003','KABEL HIKVISION.jpeg','','Approve','','D004','L0057',NULL),('BB00159','2024-09-10',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Troubleshoot    Balai Karantina Hewan,Ikan Tumbuhan','P003','WhatsApp Image 2024-09-10 at 13.40.50.jpeg','','Approve','','D004','L0059',NULL),('BB00158','2024-09-10',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Instalasi Kantor Camat Sako','P003','MC.jpeg','','Approve','','D004','L0057',NULL),('BB00189','2024-12-03',NULL,'Pembelian','','P002','','','Approve','','D001','L0001','Purchase Request'),('BB00190','2024-12-03',NULL,'Pembelian','','P002','','','Approve','','D002','L0011','Purchase Request'),('BB00161','2024-09-17',NULL,'Pembelian','Pengadaan Kabel Untuk Keperluan Spare Kantor NHT Solution Palembang ','P003','WhatsApp Image 2024-09-17 at 12.41.50.jpeg','','Approve','','D002','Koson',NULL),('BB00162','2024-09-20',NULL,'Pembelian','Pengadaan barang untuk keperluan troubleshoot PT Roempoen Enam Bersaudara Site Gunung Raja','P003','WhatsApp Image 2024-09-20 at 11.19.19 (1).jpeg','','Approve','','D002','L0036',NULL),('BB00163','2024-10-01',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Troubleshoot PT. Buluh Cawang Plantations','P003','WhatsApp Image 2024-10-01 at 09.51.27.jpeg','','Approve','','D002','L0060',NULL),('BB00164','2024-10-02',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Troubleshoot PT. Indonusa Agromulia','P003','','','Approve','','D002','L0061',NULL),('BB00165','2024-10-02',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Spare Kantor NHT Solution Palembang ','P003','','','Approve','','Semu','Koson',NULL),('BB00166','2024-10-03',NULL,'Pembelian','Pengadaan Kabel Untuk Keperluan Kantor NHT Solution Palembang ','P003','WhatsApp Image 2024-10-03 at 09.36.54.jpeg','','Approve','','D002','Koson',NULL),('BB00167','2024-10-07',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Kantor NHT Solution Palembang ','P003','','','Approve','','D002','Koson',NULL),('BB00168','2024-10-16',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Upgrade PT Astaka Dodol','P003','Pembelian NHT 17 Oktober 2024 (1).pdf','','Approve','','D002','L0007',NULL),('BB00169','2024-10-16',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Troubleshoot PT Surya Agro Persada ','P003','Pembelian NHT 17 Oktober 2024 (2).pdf','','Approve','','D002','L0038',NULL),('BB00170','2024-10-21',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Upgrade PT Astaka Dodol ','P003','','','Approve','','D002','L0007',NULL),('BB00171','2024-10-29',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Peremajaan Perangkat Dan Troubleshoot  PT Baturona Adimulya Pelabuh','P003','','','Approve','','D002','L0010',NULL),('BB00172','2024-10-29',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Troubleshoot BTS Pematang Lumut','P003','','','Approve','','D002','L0016',NULL),('BB00173','2024-10-29',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Troubleshoot STO Sungai Lilin ','P003','','','Approve','','D002','L0010',NULL),('BB00174','2024-10-29',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Troubleshoot PT Gelumbang Agro Sentosa','P003','','','Approve','','D002','L0014',NULL),('BB00175','2024-10-30',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Spare Kantor NHT Solution Palembang ','P003','','','Approve','','D002','Koson',NULL),('BB00176','2024-10-30',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Upgrade PT Astaka Dodol ( Mess ) ','P003','','','Approve','','D002','L0008',NULL),('BB00177','2024-10-30',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Upgrade PT Astaka Dodol ( Office ) ','P003','','','Approve','','D002','L0007',NULL),('BB00178','2024-10-30',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Peremajaan PT Surya Agro Persada','P003','','','Approve','','D002','L0038',NULL),('BB00179','2024-11-06',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Troubleshoot BTS Indosat Tugu Mulyo','P003','WhatsApp Image 2024-11-10 at 12.52.38.jpeg','','Approve','','D002','L0019',NULL),('BB00180','2024-11-10',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Troubleshoot PT Astaka Dodol Site Mess','P003','','','Approve','','D002','L0008',NULL),('BB00181','2024-11-10',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Troubleshoot STO Sungai Lilin','P003','','','Approve','','D002','L0010',NULL),('BB00182','2024-11-10',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Troubleshoot PT. Golden Blossom Sumatera','P003','','','Approve','','D002','L0062',NULL),('BB00183','2024-11-10',NULL,'Pembelian','Pengadaan Barang Untuk Keperluan Troubleshoot PT Baturona Adimulya  Site Pelabuhan','P003','','','Approve','','D002','L0010',''),('BB00188','2024-11-19',NULL,'Pembelian','tes pengadaan 2','P002','was.jpeg','admin.png','Approve','','D001','L0058','Sudah Diterima'),('BB00185','2024-11-18',NULL,'Pembelian','tes','P002','','','Approve','','D001','L0003','Sudah Diterima'),('BB00186','2024-11-19',NULL,'Pembelian','test','P002','674437ddc5759-circuit.jpg;674437f1a7cb3-ipad class1.jpg','','Approve','','D001','L0058','Sudah Diterima'),('BB00187','2024-11-19',NULL,'Pembelian','tes pengajuan','P002','m.png','','Approve','','D001','L0001','Pengajuan'),('BB00191','2024-12-09',NULL,'Pembelian','','P002','','','Approve','','D001','L0001','Purchase Request'),('BB00192','2024-12-09',NULL,'Pembelian','tes','P002','','','Approve','','D004','L0054','Purchase Request'),('BB00193','2024-12-09',NULL,'Pembelian','tes','P002','','','Belum Approve','','D001','L0001','Purchase Request'),('BB00194','2024-12-11',NULL,'Pembelian','tes','P002','','','Belum Approve','12345','D001','L0002','Purchase Request'),('BB00195','2024-12-24',NULL,'Pembelian','Tes','P002','','','Approve','','D002','L0010','Sudah Diterima');
/*!40000 ALTER TABLE `pengadaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengadaan_item`
--

DROP TABLE IF EXISTS `pengadaan_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengadaan_item` (
  `no_pengadaan` char(7) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `kd_supplier` char(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga_beli` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  KEY `nomor_penjualan_tamu` (`no_pengadaan`,`kd_barang`,`kd_supplier`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengadaan_item`
--

LOCK TABLES `pengadaan_item` WRITE;
/*!40000 ALTER TABLE `pengadaan_item` DISABLE KEYS */;
INSERT INTO `pengadaan_item` VALUES ('BB00001','B0084','',645000,1),('BB00002','B0154','',92000,2),('BB00003','B0117','',2150000,2),('BB00003','B0118','',985000,2),('BB00003','B0122','',1725000,2),('BB00003','B0127','',198000,6),('BB00003','B0021','',275000,18),('BB00003','B0018','',930000,6),('BB00003','B0019','',655000,6),('BB00004','B0155','',339000,2),('BB00005','B0084','',645000,1),('BB00006','B0154','',92000,1),('BB00007','B0133','',87000,1),('BB00008','B0156','',8500000,1),('BB00009','B0084','',835000,1),('BB00010','B0084','',835000,1),('BB00011','B0122','',1725000,1),('BB00011','B0119','',1880000,1),('BB00011','B0117','',2150000,1),('BB00011','B0101','',197000,2),('BB00011','B0055','',102000,4),('BB00011','B0127','',198000,4),('BB00012','B0084','',615000,1),('BB00013','B0084','',615000,1),('BB00014','B0133','',60000,1),('BB00025','B0118','',990000,5),('BB00025','B0157','',2280000,1),('BB00025','B0127','',198000,6),('BB00016','B0159','',600000,1),('BB00016','B0146','',330000,1),('BB00017','B0160','',467000,1),('BB00018','B0160','',467000,1),('BB00019','B0154','',92000,4),('BB00020','B0080','',840000,1),('BB00028','B0127','',195000,2),('BB00026','B0056','',675000,2),('BB00027','B0056','',675000,1),('BB00023','B0133','',60000,2),('BB00024','B0154','',92000,2),('BB00029','B0056','',675000,1),('BB00030','B0127','',195000,2),('BB00031','B0056','',692700,1),('BB00032','B0154','',92000,1),('BB00033','B0004','',220000,3),('BB00033','B0084','',670000,1),('BB00034','B0154','',92000,2),('BB00035','B0056','',692700,1),('BB00036','B0154','',92000,2),('BB00037','B0127','',200000,2),('BB00037','B0119','',1880000,1),('BB00038','B0154','',92000,1),('BB00039','B0021','',290000,3),('BB00040','B0127','',200000,1),('BB00041','B0118','',990000,1),('BB00042','B0121','',3996000,1),('BB00043','B0145','',181000,2),('BB00043','B0133','',85000,2),('BB00043','B0127','',200000,4),('BB00043','B0117','',2050000,3),('BB00046','B0084','',730000,2),('BB00045','B0056','',693500,2),('BB00047','B0080','',850000,1),('BB00048','B0154','',92000,1),('BB00049','B0056','',693500,1),('BB00050','B0154','',92000,1),('BB00051','B0056','',693500,1),('BB00052','B0080','',850000,1),('BB00052','B0004','',220000,3),('BB00053','B0154','',92000,1),('BB00054','B0127','',195000,2),('BB00054','B0122','',1760000,1),('BB00054','B0161','',2300000,1),('BB00055','B0127','',195000,1),('BB00055','B0118','',990000,1),('BB00056','B0080','',850000,2),('BB00057','B0056','',717500,1),('BB00058','B0133','',60000,2),('BB00059','B0154','',92000,3),('BB00060','B0127','',198000,4),('BB00060','B0118','',975000,1),('BB00060','B0121','',3850000,1),('BB00060','B0117','',2050000,1),('BB00061','B0101','',197000,5),('BB00061','B0122','',1740000,1),('BB00061','B0118','',975000,1),('BB00061','B0121','',3850000,1),('BB00061','B0117','',2050000,1),('BB00062','B0154','',92000,1),('BB00063','B0133','',60000,1),('BB00064','B0127','',198000,1),('BB00064','B0119','',1850000,1),('BB00065','B0080','',880000,1),('BB00066','B0154','',92000,1),('BB00067','B0127','',198000,1),('BB00067','B0119','',1850000,1),('BB00068','B0080','',880000,1),('BB00069','B0154','',92000,1),('BB00070','B0056','',717500,1),('BB00071','B0127','',198000,1),('BB00071','B0119','',1850000,1),('BB00072','B0080','',880000,1),('BB00073','B0154','',92000,1),('BB00074','B0056','',717500,1),('BB00075','B0162','',730000,1),('BB00076','B0163','',1560000,1),('BB00077','B0164','',130000,3),('BB00078','B0158','',1170000,2),('BB00079','B0165','',1074101,1),('BB00080','B0123','',645000,1),('BB00081','B0021','',293000,3),('BB00082','B0021','',293000,2),('BB00083','B0120','',624500,2),('BB00084','B0167','',1046000,1),('BB00085','B0166','',300000,1),('BB00086','B0173','',150000,1),('BB00086','B0172','',135000,1),('BB00086','B0171','',90000,1),('BB00086','B0170','',5000,10),('BB00086','B0169','',42100,1),('BB00086','B0168','',2700,20),('BB00086','B0174','',377950,1),('BB00087','B0175','',92000,10),('BB00088','B0187','',155400,15),('BB00089','B0178','',830000,1),('BB00089','B0177','',18500,5),('BB00089','B0176','',11200,5),('BB00089','B0080','',825000,1),('BB00090','B0075','',1650000,1),('BB00091','B0179','',670000,1),('BB00092','B0173','',150000,1),('BB00092','B0172','',135000,1),('BB00092','B0168','',2700,20),('BB00093','B0180','',140000,8),('BB00094','B0180','',135000,5),('BB00094','B0170','',5000,20),('BB00094','B0168','',2700,30),('BB00094','B0182','',78000,2),('BB00094','B0188','',47000,2),('BB00094','B0181','',50000,2),('BB00094','B0173','',123000,5),('BB00094','B0183','',14000,2),('BB00095','B0184','',7200,5),('BB00096','B0185','',115000,10),('BB00097','B0168','',2700,30),('BB00097','B0189','',630000,1),('BB00098','B0185','',110000,12),('BB00099','B0190','',18550,1),('BB00099','B0183','',14000,2),('BB00099','B0168','',2700,30),('BB00100','B0185','',110000,10),('BB00100','B0168','',2700,30),('BB00100','B0189','',630000,1),('BB00101','B0183','',14000,2),('BB00101','B0184','',7200,3),('BB00101','B0182','',78000,1),('BB00101','B0188','',47000,2),('BB00101','B0181','',43000,2),('BB00101','B0186','',30695,2),('BB00103','B0194','',650000,1),('BB00102','B0194','',350000,1),('BB00104','B0047','',725300,2),('BB00106','B0056','',708100,1),('BB00105','B0137','',640000,1),('BB00107','B0194','',300000,1),('BB00108','B0194','',630000,1),('BB00110','B0199','',64268,1),('BB00111','B0198','',35499,1),('BB00109','B0201','',67030,1),('BB00112','B0200','',2251320,1),('BB00113','B0202','',900000,2),('BB00114','B0203','',325000,1),('BB00115','B0204','',45000,1),('BB00115','B0205','',25000,1),('BB00116','B0206','',20000,1),('BB00117','B0207','',42500,1),('BB00118','B0209','',1000,10),('BB00118','B0208','',2300,16),('BB00118','B0210','',2200,100),('BB00118','B0042','',880000,2),('BB00119','B0133','',60000,2),('BB00119','B0127','',0,2),('BB00119','B0158','',0,1),('BB00119','B0119','',0,1),('BB00120','B0213','',25857,2),('BB00120','B0212','',234600,1),('BB00121','B0214','',142800,1),('BB00122','B0215','',179520,1),('BB00123','B0124','',0,1),('BB00124','B0127','',275000,2),('BB00125','B0020','',487000,1),('BB00126','B0056','',710000,1),('BB00127','B0133','',61000,2),('BB00128','B0123','',750000,2),('BB00129','B0080','',845000,1),('BB00130','B0154','',74000,1),('BB00131','B0056','',710000,1),('BB00135','B0220','',0,1),('BB00134','B0218','',1000000,2),('BB00133','B0217','',700000,1),('BB00132','B0216','',650000,1),('BB00136','B0219','',0,1),('BB00137','B0021','',297000,4),('BB00138','B0221','',49500,1),('BB00139','B0056','',710000,1),('BB00140','B0004','',220000,1),('BB00140','B0084','',710000,1),('BB00141','B0133','',60000,1),('BB00142','B0056','',710000,1),('BB00143','B0197','',350000,1),('BB00144','B0119','',0,1),('BB00144','B0192','',0,2),('BB00144','B0127','',0,4),('BB00144','B0101','',0,4),('BB00144','B0176','',0,5),('BB00144','B0095','',0,2),('BB00144','B0224','',0,5),('BB00144','B0225','',0,1),('BB00145','B0226','',0,2),('BB00146','B0080','A0018',875000,1),('BB00147','B0021','A0007',297500,2),('BB00148','B0133','A0003',60000,1),('BB00149','B0229','A0009',300000,1),('BB00149','B0228','A0009',250000,1),('BB00149','B0227','A0009',275000,1),('BB00150','B0230','A0003',95000,1),('BB00151','B0226','A0005',0,4),('BB00151','B0231','A0005',0,2),('BB00152','B0084','A0003',710000,1),('BB00153','B0084','A0003',710000,4),('BB00153','B0080','A0003',890000,1),('BB00153','B0004','A0003',220000,8),('BB00154','B0154','A0003',74000,1),('BB00155','B0021','A0007',295500,4),('BB00156','B0056','A0007',710000,1),('BB00159','B0084','A0003',665000,2),('BB00158','B0233','A0003',95000,3),('BB00190','B0232','A0005',200000,2),('BB00189','B0124','A0007',300000,1),('BB00161','B0056','A0007',710000,1),('BB00162','B0084','A0003',665000,1),('BB00162','B0133','A0003',60000,2),('BB00163','B0084','A0003',665000,1),('BB00164','B0084','A0003',665000,1),('BB00165','B0055','A0005',0,2),('BB00165','B0164','A0005',0,3),('BB00165','B0127','A0001',0,4),('BB00165','B0230','A0005',0,3),('BB00165','B0224','A0005',0,5),('BB00165','B0236','A0005',0,25),('BB00165','B0237','A0005',0,25),('BB00165','B0238','A0005',0,1),('BB00166','B0056','A0007',720000,1),('BB00167','B0198','A0005',0,12),('BB00167','B0199','A0005',0,12),('BB00168','B0127','A0001',195000,1),('BB00168','B0124','A0005',4725000,2),('BB00169','B0127','A0001',195000,1),('BB00169','B0124','A0005',4725000,2),('BB00170','B0020','A0007',497000,12),('BB00170','B0056','A0007',710500,3),('BB00170','B0230','A0003',90000,1),('BB00170','B0189','A0003',620000,1),('BB00170','B0140','A0003',212000,2),('BB00170','B0145','A0003',120000,1),('BB00171','B0080','A0016',885000,1),('BB00171','B0154','A0003',74000,2),('BB00171','B0133','A0003',64000,1),('BB00171','B0056','A0007',710500,1),('BB00172','B0133','A0003',64000,1),('BB00173','B0121','A0001',0,1),('BB00174','B0118','A0001',0,1),('BB00175','B0101','A0001',0,4),('BB00175','B0099','A0001',0,4),('BB00175','B0127','A0001',0,4),('BB00175','B0118','A0001',0,1),('BB00175','B0131','A0001',0,1),('BB00176','B0122','A0001',0,2),('BB00176','B0230','A0003',95000,1),('BB00176','B0020','A0007',0,1),('BB00176','B0145','A0003',120000,1),('BB00176','B0080','A0016',885000,1),('BB00177','B0080','A0016',885000,1),('BB00177','B0230','A0003',95000,4),('BB00178','B0121','A0001',0,2),('BB00178','B0154','A0003',74000,1),('BB00178','B0230','A0003',95000,1),('BB00179','B0080','A0016',685000,1),('BB00180','B0124','A0019',0,1),('BB00180','B0127','A0001',0,2),('BB00180','B0230','A0003',0,2),('BB00180','B0101','A0001',0,1),('BB00180','B0099','A0001',0,1),('BB00181','B0121','A0019',0,2),('BB00182','B0154','A0003',0,1),('BB00182','B0133','A0003',0,1),('BB00182','B0117','A0001',0,1),('BB00182','B0127','A0001',0,2),('BB00182','B0121','A0019',0,1),('BB00183','B0154','1',1,1),('BB00183','B0133','1',1,1),('BB00183','B0101','1',1,1),('BB00183','B0127','1',1,1),('BB00183','B0121','1',1,1),('BB00183','B0140','1',1,1),('BB00183','B0080','1',1,1),('BB00188','B0230','A0007',730000,2),('BB00191','B0158','A0005',150000,1),('BB00185','B0156','A0002',50000,5),('BB00185','B0055','A0001',2000000,1),('BB00185','B0238','A0005',20000,4),('BB00186','B0183','A0006',35000,5),('BB00187','B0168','A0005',200000,1),('BB00187','B0112','A0001',350000,3),('BB00192','B0037','A0007',500000,1),('BB00193','B0225','A0008',150000,1),('BB00194','B0237','A0006',100000,1),('BB00195','B0237','A0005',20000,2);
/*!40000 ALTER TABLE `pengadaan_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengembalian`
--

DROP TABLE IF EXISTS `pengembalian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengembalian` (
  `no_pengembalian` char(7) NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `no_peminjaman` char(7) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  `form_bast` longtext NOT NULL,
  PRIMARY KEY (`no_pengembalian`),
  KEY `foreign` (`no_peminjaman`,`kd_petugas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengembalian`
--

LOCK TABLES `pengembalian` WRITE;
/*!40000 ALTER TABLE `pengembalian` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengembalian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `petugas`
--

DROP TABLE IF EXISTS `petugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `petugas` (
  `kd_petugas` char(4) NOT NULL,
  `nm_petugas` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'Kasir',
  `kd_departemen` char(4) NOT NULL,
  PRIMARY KEY (`kd_petugas`),
  KEY `departemen-fk` (`kd_departemen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `petugas`
--

LOCK TABLES `petugas` WRITE;
/*!40000 ALTER TABLE `petugas` DISABLE KEYS */;
INSERT INTO `petugas` VALUES ('P001','Administrator','02147483647','admin','21232f297a57a5a743894a0e4a801fc3','20171019094245-avatar.png','Admin','Koso'),('P002','Sri Rahayu','089212009182','ayu','29c65f781a1068a41f735e1b092546de','','Petugas','D001'),('P003','Sri Rahmawati','08888888888','sri','d1565ebd8247bbb01472f80e24ad29b6','','Petugas','D002'),('P004','Yudi Handriyanto','082111111111','yudi','c232864d5de2064450915c0b9e4cc0b5','','Petugas','D003'),('P005','Nurjanah','08966666666','nur','b55178b011bfb206965f2638d0f87047','','Petugas','D002');
/*!40000 ALTER TABLE `petugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_item`
--

DROP TABLE IF EXISTS `service_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_item` (
  `no_service` char(7) NOT NULL,
  `kd_inventaris` varchar(12) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `kerusakan` varchar(100) DEFAULT NULL,
  `harga_service` int DEFAULT '0',
  `jumlah` int DEFAULT NULL,
  `customer` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `serial_number` varchar(50) DEFAULT NULL,
  `serial_number_baru` varchar(50) DEFAULT NULL,
  KEY `nomor_penjualan_tamu` (`no_service`,`kd_inventaris`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_item`
--

LOCK TABLES `service_item` WRITE;
/*!40000 ALTER TABLE `service_item` DISABLE KEYS */;
INSERT INTO `service_item` VALUES ('SS00004','B0117.000063','','mati',0,NULL,'BTS Road Lilin','Barang Tidak Dikirim - SN : F492BFBE8EB4',NULL,NULL),('SS00003','B0121.000221','','Mati',0,NULL,'PT. Nettocyber Indonesia','Servisan','784558A432F0',NULL),('SS00005','B0117.000063','','mati',0,NULL,'','Barang Tidak Dikirim-SN 245A4C0CB693',NULL,NULL),('SS00001','B0117.000063','','Mati',0,NULL,'PT. Nettocyber Indonesia','','2338G AC8BA9CA5 180','2338G AC8BA9CA5 180'),('SS00002','B0117.000063','','Mati',0,NULL,'PT. Nettocyber Indonesia','','2338G AC8BA9CA4F7C',NULL),('SS00006','B0117.000063','','mati',0,NULL,'','Barang Tidak Dikirim - SN : F492BFBE8D93',NULL,NULL),('SS00007','B0117.000063','','mati',0,NULL,'','Barang Tidak Dikirim - SN : 784558AC804C',NULL,NULL),('SS00008','B0117.000063','','mati, kena petir',0,NULL,'','Barang Tidak Dikirim - SN : F492BFBE7ECC',NULL,NULL),('SS00009','B0117.000063','','mati',0,NULL,'BTS Megang Sakti Lubuk Panda','Barang Tidak Dikirim - SN 245A4C0CB705',NULL,NULL),('SS00010','B0117.000063','','mati',0,NULL,'','Barang Tidak Dikirim - SN : 70A74144BBA3',NULL,NULL),('SS00011','B0120.000309','','mati',0,NULL,'','Barang Tidak Dikirim - MAC : 18406B4FBE45831D71',NULL,NULL),('SS00012','B0120.000309','','Mati Total',0,NULL,'','Barang Tidak Dikirim - MAC : 1750KFCECDA08172F',NULL,NULL),('SS00013','B0120.000309','','mati',0,NULL,'PT. Jambi Biomassa','Barang Tidak Dikirim - MAC : 2121K245A4CBC5DFF',NULL,NULL),('SS00014','B0120.000309','','mati',0,NULL,'','Barang Tidak Dikirim - MAC : 1805G788A20E6AB3B',NULL,NULL),('SS00015','B0120.000309','','mati',0,NULL,'BTS ISAT Sekayu','barang tidak di kirim ',NULL,NULL),('SS00016','B0120.000309','','mati',0,NULL,'','Barang Tidak Dikirim - MAC : 1835GFCECDA6E8333',NULL,NULL),('SS00017','B0120.000309','','mati',0,NULL,'','barang tidak di kirim mac :1314GDC9FDB62FFB7',NULL,NULL),('SS00018','B0124.000795','','mati',0,NULL,'PT. Pratama Palm Abadi','Barang Tidak Dikirim - MAC :220C-D021F9AF3973',NULL,NULL),('SS00019','B0042.000653','','Korsleting',50000,NULL,'Dinas Lingkungan Hidup dan Pertahanan Provinsi Sumatera Selatan','Untuk Karyawan Baru','KL928102511OP2',NULL),('SS00020','B0004.000864','','Korslet',200000,NULL,'Kantor Camat Sako ( PSS Palembang )','oke','OKW9271992',NULL),('SS00021','B0004.000869','','tes',0,NULL,'Kantor Camat Sako ( PSS Palembang )','tes',NULL,NULL),('SS00022','B0020.000998','','tes kerusakan',0,NULL,'PT. Astaka Dodol','oke','',NULL),('SS00023','B0183.001090','','Tes kerusakan',0,NULL,'Kantor NHT Bekasi','oke','70A74146E4D9',NULL),('SS00024','B0001.000002','','tes',100000,NULL,'nuri','','',NULL),('SS00025','B0001.000003','','rusak',100000,NULL,'','','',NULL),('SS00027','B0001.000003','','korslet',0,NULL,'PT. Fossa Bara Indonesia','test','',NULL),('SS00029','B0001.000003','','korslet',0,NULL,'PT. Fossa Bara Indonesia','test','',NULL),('SS00030','B0001.000006','','rusak',150000,NULL,'PT. Fortuna Marina Sejahtera','tes','',NULL),('SS00031','B0001.000004','','rusak',150000,NULL,'lala','tes','',NULL),('SS00032','B0001.000003','','rusakk',250000,NULL,'lulu','ngetes','',NULL),('SS00038','B0001.000005','','rusak',100000,NULL,'lala','tes','123456',''),('SS00034','B0020.000999','','rusak',400000,NULL,'PT. Astaka Dodol','tes','',NULL),('SS00039','B0001.000006','','mati total',150000,NULL,'PT. Fortuna Marina Sejahtera','coba','',NULL),('SS00037','B0001.000006','','rusak',150000,NULL,'PT. Fortuna Marina Sejahtera','tes','',NULL),('SS00040','B0001.000008','','rusak',200000,NULL,'sasa','coba','',NULL),('SS00042','B0001.000005','','rusak',200000,NULL,'lala','tes','12345',NULL),('SS00043','B0238.000958','','Mati',20000,NULL,'PT. Fossa Bara Indonesia','tes 1','HG123',NULL),('SS00044','B0236.000916','','putus',250000,NULL,'PT. Astaka Dodol (Mess)','tes','12345',NULL);
/*!40000 ALTER TABLE `service_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `no_service` char(7) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_kirim` date DEFAULT NULL,
  `tgl_sampai` date DEFAULT NULL,
  `tgl_service` date DEFAULT NULL,
  `tgl_return` date DEFAULT NULL,
  `kd_supplier` char(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kd_petugas` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kd_departemen` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kd_lokasi` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lokasi` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `surat_jalan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomor_resi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('IDLE','PROCESS','SEND','DONE','CANCEL') COLLATE utf8mb4_general_ci DEFAULT 'IDLE',
  `status_approval_service` enum('Approve','Belum Approve','-') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto_form` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`no_service`),
  KEY `fk` (`kd_supplier`,`kd_petugas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES ('SS00001','2024-09-24','2024-11-21','2024-10-03',NULL,'A0001','P005','','','nomor sn hilang','D002',NULL,'','CANCEL','Approve','file0',''),('SS00002','2024-09-24','2024-09-25','2024-10-03',NULL,'A0001','P005','','','','D002',NULL,'','PROCESS','Approve','file0',''),('SS00003','2024-09-24',NULL,NULL,NULL,'Koson','P005','','','Tidak Bisa diServis karena No. SN Hilang','D002',NULL,'','IDLE','Approve','',''),('SS00004','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00005','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00006','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00007','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00008','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00009','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00010','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00011','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00012','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00013','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00014','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00015','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00016','2024-10-04',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00017','2024-10-07',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00018','2024-10-17',NULL,NULL,NULL,'','P005','','','','D002','','','IDLE','Approve','',''),('SS00019','2024-11-15',NULL,NULL,NULL,NULL,'P001','','',NULL,'D001','WhatsApp Image 2024-11-06 at 08.47.08.jpeg','','IDLE','Approve',NULL,''),('SS00020','2024-11-18',NULL,NULL,NULL,'A0001','P001','','',NULL,'D002','','','IDLE','Approve',NULL,''),('SS00021','2024-11-20',NULL,NULL,NULL,'NULL','P001','','',NULL,'NULL','','','IDLE','Approve',NULL,''),('SS00022','2024-11-22',NULL,NULL,NULL,'A0001','P001','','',NULL,'D001','','','IDLE','Approve',NULL,''),('SS00023','2024-11-20',NULL,NULL,NULL,'','P002','','',NULL,'D002','','','IDLE','Approve',NULL,''),('SS00024','2024-12-04',NULL,NULL,NULL,'','P002','','',NULL,'D002','','','IDLE','Approve',NULL,''),('SS00025','2024-12-09',NULL,NULL,NULL,'','P002','','',NULL,'D001','','','IDLE','Approve',NULL,''),('SS00026','2024-12-09',NULL,NULL,NULL,'','P002',NULL,NULL,NULL,'D001','6756555c13084-Acer_Wallpaper_01_5000x2814.jpg',NULL,'IDLE','Approve',NULL,NULL),('SS00027','2024-12-09',NULL,NULL,NULL,'','P002',NULL,NULL,NULL,'D001','6756565ef10d3-Acer_Wallpaper_01_5000x2814.jpg',NULL,'IDLE','Approve',NULL,NULL),('SS00029','2024-12-09',NULL,NULL,NULL,'','P002',NULL,NULL,NULL,'D001','675657209e871-Acer_Wallpaper_01_5000x2814.jpg',NULL,'IDLE','Approve',NULL,NULL),('SS00030','2024-12-10',NULL,NULL,NULL,'A0006','P002',NULL,NULL,NULL,'D001','67566dc149fe9-Acer_Wallpaper_01_5000x2814.jpg',NULL,'IDLE','Approve',NULL,NULL),('SS00031','2024-12-09',NULL,NULL,NULL,'A0006','P002',NULL,NULL,NULL,'D001','6756ab9f022d0-Acer_Wallpaper_01_5000x2814.jpg',NULL,'IDLE','Approve',NULL,NULL),('SS00032','2024-12-09',NULL,NULL,NULL,'A0010','P002',NULL,NULL,NULL,'D001','6756b095c86e4-Acer_Wallpaper_01_5000x2814.jpg',NULL,'IDLE','Approve',NULL,NULL),('SS00034','2024-12-09',NULL,NULL,NULL,'A0010','P002',NULL,NULL,NULL,'D001','6756b2743267c-Acer_Wallpaper_01_5000x2814.jpg',NULL,'IDLE','Approve',NULL,NULL),('SS00037','2024-12-10',NULL,NULL,NULL,'A0010','P002',NULL,NULL,NULL,'D001','6757e7fc1f0bb-Acer_Wallpaper_01_5000x2814.jpg',NULL,'IDLE','Approve',NULL,NULL),('SS00038','2024-12-10','2024-12-10','2024-12-10',NULL,'','P002',NULL,NULL,'','D001','',NULL,'IDLE','Approve','file0',NULL),('SS00039','2024-12-11',NULL,NULL,NULL,'A0014','P002',NULL,NULL,NULL,'D002','6757f2269c8e8-Acer_Wallpaper_01_5000x2814.jpg',NULL,'IDLE','Approve',NULL,NULL),('SS00040','2024-12-10',NULL,NULL,NULL,'A0007','P002',NULL,NULL,NULL,'D001','6757f32d2593a-Acer_Wallpaper_01_5000x2814.jpg',NULL,'IDLE','Approve',NULL,NULL),('SS00042','2024-12-12',NULL,NULL,NULL,'A0009','P002',NULL,NULL,NULL,'D001','6758f3fb1411c-Acer_Wallpaper_01_5000x2814.jpg',NULL,'IDLE','Approve',NULL,NULL),('SS00043','2024-12-11',NULL,NULL,NULL,'','P002',NULL,NULL,NULL,'D001','6758f4d5d394a-Acer_Wallpaper_02_5000x2813.jpg',NULL,'IDLE','Belum Approve',NULL,NULL),('SS00044','2024-12-11',NULL,NULL,NULL,'A0005','P002',NULL,NULL,NULL,'D004','6759179996433-Acer_Wallpaper_02_5000x2813.jpg',NULL,'IDLE','Belum Approve',NULL,NULL);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier` (
  `kd_supplier` char(5) NOT NULL,
  `nm_supplier` varchar(200) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(200) NOT NULL,
  PRIMARY KEY (`kd_supplier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` VALUES ('A0001','Toko GlobalNET (Cici)','Harco Mangga Dua',''),('A0002','PT Gloria Jaya Utama','Harco Mangga Dua',''),('A0003','Mulia Jaya Computer','Palembang',''),('A0004','Mulia Jaya','Palembang',''),('A0005','Shopee','Jakarta',''),('A0006','Tokopedia','Jakarta',''),('A0007','PT Sentral Teknologi Asia','Palembang',''),('A0008','Kedaung AC','Jl diponegoro no 236 palembang','085268231133'),('A0009','Mobil Motor Service ( MMS ) Udin','Talang Kerangga Palembang ',''),('A0010','Edy Variasi','Jl Merdeka Palembang ','081373908883'),('A0011','Jimmy Service','Jl. Angkatan 45 No.2129, Lorok Pakjo, Kec. Ilir Bar. I, Kota Palembang, Sumatera Selatan 30137',''),('A0012','Istana Battery Patal','',''),('A0013','Toko Material Sudirman','Jl Jenderal Sudirman Palembang',''),('A0014','Lazada','',''),('A0015','Metrojaya Komputer','Jl Lingkaran 1 Dempo Palembang','+62 821-2222-3401'),('A0016','Terajaya Komputer','l. Mayor HM. Rasyad Nawawi No.243, 9 Ilir, Kec. Ilir Tim. II, Kota Palembang, Sumatera Selatan 30111','+62 853-6708-8909'),('A0017','Union Jaya Ban ','Jl. Perintis Kemerdekaan No.30 - 31, Kuto Batu, Kec. Ilir Tim. II, Kota Palembang, Sumatera Selatan 30111','0711712738'),('A0018','Media Jaya Komputer ','Jl. Lingkaran1 No.310 B, 15 Ilir, Kec. Ilir Tim. I, Kota Palembang, Sumatera Selatan 30126','+62 813-7759-3066'),('A0019','Agana Store','','+62 858-9000-7861');
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_mutasi`
--

DROP TABLE IF EXISTS `tmp_mutasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tmp_mutasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `foreign` (`kd_petugas`,`no_penempatan`,`kd_inventaris`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_mutasi`
--

LOCK TABLES `tmp_mutasi` WRITE;
/*!40000 ALTER TABLE `tmp_mutasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_mutasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_opname`
--

DROP TABLE IF EXISTS `tmp_opname`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tmp_opname` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `foreign` (`kd_inventaris`,`kd_petugas`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_opname`
--

LOCK TABLES `tmp_opname` WRITE;
/*!40000 ALTER TABLE `tmp_opname` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_opname` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_peminjaman`
--

DROP TABLE IF EXISTS `tmp_peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tmp_peminjaman` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `foreign` (`kd_inventaris`,`kd_petugas`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_peminjaman`
--

LOCK TABLES `tmp_peminjaman` WRITE;
/*!40000 ALTER TABLE `tmp_peminjaman` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_penempatan`
--

DROP TABLE IF EXISTS `tmp_penempatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tmp_penempatan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `foreign` (`kd_inventaris`,`kd_petugas`)
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_penempatan`
--

LOCK TABLES `tmp_penempatan` WRITE;
/*!40000 ALTER TABLE `tmp_penempatan` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_penempatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_pengadaan`
--

DROP TABLE IF EXISTS `tmp_pengadaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tmp_pengadaan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `kd_supplier` char(5) DEFAULT NULL,
  `harga_beli` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `no_pengadaan` char(7) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `foreign` (`kd_barang`,`kd_petugas`,`kd_supplier`,`no_pengadaan`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1113 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_pengadaan`
--

LOCK TABLES `tmp_pengadaan` WRITE;
/*!40000 ALTER TABLE `tmp_pengadaan` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_pengadaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_service`
--

DROP TABLE IF EXISTS `tmp_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tmp_service` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `harga_service` int NOT NULL,
  `jumlah` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `foreign` (`kd_inventaris`,`kd_petugas`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_service`
--

LOCK TABLES `tmp_service` WRITE;
/*!40000 ALTER TABLE `tmp_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor_service`
--

DROP TABLE IF EXISTS `vendor_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendor_service` (
  `kd_vendor_service` char(4) NOT NULL,
  `nm_vendor_service` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telpon` varchar(20) NOT NULL,
  PRIMARY KEY (`kd_vendor_service`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor_service`
--

LOCK TABLES `vendor_service` WRITE;
/*!40000 ALTER TABLE `vendor_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendor_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'asset'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-30  8:31:12
