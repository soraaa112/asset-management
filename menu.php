<section class="sidebar">
	<!-- Sidebar user panel -->
	<div class="user-panel">
		<div class="pull-left image">
			<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
		</div>
		<div class="pull-left info">
			<?php if (isset($_SESSION['SES_ADMIN'])) { ?>
				<p><?php echo $_SESSION['SES_NAMA']; ?></p>
			<?php } elseif (isset($_SESSION['SES_OPERATOR'])) { ?>
				<p><?php echo $_SESSION['SES_NAMA']; ?> | <?php echo $_SESSION['SES_UNIT']; ?></p>
			<?php } elseif (isset($_SESSION['SES_PETUGAS'])) { ?>
				<p><?php echo $_SESSION['SES_NAMA']; ?> | <?php echo $_SESSION['SES_UNIT']; ?></p>
			<?php } ?>
			<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
		</div>
	</div>

	<!-- sidebar menu: : style can be found in sidebar.less -->
	<ul class="sidebar-menu">
		<?php if (isset($_SESSION['SES_ADMIN'])) { ?>
			<li class="header" style='color:#fff; text-transform:uppercase; border-bottom:2px solid #00c0ef'>MENU <?php echo $_SESSION['level']; ?></li>
			<li><a href="?open"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			<li><a href="?open=Petugas-Data"><i class="fa fa-user"></i> <span>Data Pengguna</span></a></li>
			<li class="treeview">
				<a href="#"><i class="fa fa-th"></i> <span>Data Master</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="?open=Pegawai-Data"><i class="fa fa-circle-o"></i> Data Pegawai</a></li>
					<li><a href="?open=Supplier-Data"><i class="fa fa-circle-o"></i> Data Supplier</a></li>
					<li><a href="?open=Departemen-Data"><i class="fa fa-circle-o"></i> Data Departemen</a></li>
					<li><a href="?open=Lokasi-Data"><i class="fa fa-circle-o"></i> Data Lokasi</a></li>
					<li><a href="?open=Kategori-Data"><i class="fa fa-circle-o"></i> Data Kategori</a></li>
					<li><a href="?open=Barang-Data"><i class="fa fa-circle-o"></i> Data Barang</a></li>
				</ul>
			</li>
			<li><a href="?open=Pencarian-1"><i class="fa fa-search"></i> Pencarian Label Barang</a></li>
			<li class="treeview">
				<a href="#"><i class="fa fa-shopping-cart"></i> <span>Data Transaksi</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="?open=Pengadaan-Tampil"><i class="fa fa-circle-o"></i> Transaksi Pengadaan</a></li>
					<li><a href="?open=Penempatan-Tampil"><i class="fa fa-circle-o"></i> Transaksi Penempatan</a></li>
					<li><a href="?open=Mutasi-Tampil"><i class="fa fa-circle-o"></i> Transaksi Mutasi</a></li>
					<li><a href="?open=Peminjaman-Tampil"><i class="fa fa-circle-o"></i> Transaksi Peminjaman</a></li>
					<li><a href="?open=Service-Tampil"><i class="fa fa-circle-o"></i> Transaksi Service</a></li>
				</ul>
			</li>
			<li><a href="?open=Stok-Opname"><i class="fa fa-clipboard"></i> <span>Stok Opname</span></a></li>
			<li class="treeview">
				<a href="#"><i class="fa fa-calendar"></i> <span>Data Laporan</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="?open=Laporan-Pegawai"><i class="fa fa-circle-o"></i> Data Pegawai</a></li>
					<li><a href="?open=Laporan-Supplier"><i class="fa fa-circle-o"></i> Data Supplier</a></li>
					<li><a href="?open=Laporan-Departemen"><i class="fa fa-circle-o"></i> Data Departemen</a></li>
					<li><a href="?open=Laporan-Lokasi"><i class="fa fa-circle-o"></i> Data Lokasi</a></li>
					<li><a href="?open=Laporan-Kategori"><i class="fa fa-circle-o"></i> Data Kategori</a></li>
					<li><a href="?open=Laporan-Opname-Periode"><i class="fa fa-circle-o"></i> Data Stok Opname</a></li>
					<li><a href="?open=Laporan-Barang-Kategori"><i class="fa fa-circle-o"></i> Laporan Barang </a></li>
					<li><a href="?open=Laporan-Pengadaan-Periode"><i class="fa fa-circle-o"></i> Laporan Pengadaan </a></li>
					<li><a href="?open=Laporan-Penempatan-Periode"><i class="fa fa-circle-o"></i> Laporan Penempatan </a></li>
					<li><a href="?open=Laporan-Peminjaman-Pegawai"><i class="fa fa-circle-o"></i> Laporan Peminjaman </a></li>
					<li><a href="?open=Laporan-Service-Periode"><i class="fa fa-circle-o"></i> Laporan Data Service</a></li>
				</ul>
			</li>
			<li><a href="?open=Cetak-Barcode"><i class="fa fa-print"></i> <span>Cetak Label Barang</span></a></li>
			<li><a href="?open=Logout"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>

		<?php } elseif (isset($_SESSION['SES_OPERATOR'])) { ?>
			<li class="header" style='color:#fff; text-transform:uppercase; border-bottom:2px solid #00c0ef'>MENU <?php echo $_SESSION['level']; ?></li>
			<li><a href="?open"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			<li class="treeview">
				<a href="#"><i class="fa fa-th"></i> <span>Data Master</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="?open=Pegawai-Data"><i class="fa fa-circle-o"></i> Data Pegawai</a></li>
					<li><a href="?open=Supplier-Data"><i class="fa fa-circle-o"></i> Data Supplier</a></li>
					<li><a href="?open=Departemen-Data"><i class="fa fa-circle-o"></i> Data Departemen</a></li>
					<li><a href="?open=Lokasi-Data"><i class="fa fa-circle-o"></i> Data Lokasi</a></li>
					<li><a href="?open=Kategori-Data"><i class="fa fa-circle-o"></i> Data Kategori</a></li>
					<li><a href="?open=Barang-Data"><i class="fa fa-circle-o"></i> Data Barang</a></li>
				</ul>
			</li>
			<li><a href="?open=Pencarian-1"><i class="fa fa-search"></i> Pencarian Label Barang</a></li>
			<li class="treeview">
				<a href="#"><i class="fa fa-shopping-cart"></i> <span>Data Transaksi</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="?open=Pengadaan-Tampil"><i class="fa fa-circle-o"></i> Transaksi Pengadaan</a></li>
					<li><a href="?open=Penempatan-Tampil"><i class="fa fa-circle-o"></i> Transaksi Penempatan</a></li>
					<li><a href="?open=Mutasi-Tampil"><i class="fa fa-circle-o"></i> Transaksi Mutasi</a></li>
					<li><a href="?open=Peminjaman-Tampil"><i class="fa fa-circle-o"></i> Transaksi Peminjaman</a></li>
					<li><a href="?open=Service-Tampil"><i class="fa fa-circle-o"></i> Transaksi Service</a></li>
				</ul>
			</li>
			<li><a href="?open=Stok-Opname"><i class="fa fa-clipboard"></i> <span>Stok Opname</span></a></li>
			<li class="treeview">
				<a href="#"><i class="fa fa-calendar"></i> <span>Data Laporan</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="?open=Laporan-Pegawai"><i class="fa fa-circle-o"></i> Data Pegawai</a></li>
					<li><a href="?open=Laporan-Supplier"><i class="fa fa-circle-o"></i> Data Supplier</a></li>
					<li><a href="?open=Laporan-Departemen"><i class="fa fa-circle-o"></i> Data Departemen</a></li>
					<li><a href="?open=Laporan-Lokasi"><i class="fa fa-circle-o"></i> Data Lokasi</a></li>
					<li><a href="?open=Laporan-Kategori"><i class="fa fa-circle-o"></i> Data Kategori</a></li>
					<li><a href="?open=Laporan-Opname-Periode"><i class="fa fa-circle-o"></i> Data Stok Opname</a></li>
					<li><a href="?open=Laporan-Barang-Kategori"><i class="fa fa-circle-o"></i> Laporan Barang </a></li>
					<li><a href="?open=Laporan-Pengadaan-Periode"><i class="fa fa-circle-o"></i> Laporan Pengadaan </a></li>
					<li><a href="?open=Laporan-Penempatan-Periode"><i class="fa fa-circle-o"></i> Laporan Penempatan </a></li>
					<li><a href="?open=Laporan-Peminjaman-Pegawai"><i class="fa fa-circle-o"></i> Laporan Peminjaman </a></li>
					<li><a href="?open=Laporan-Service-Periode"><i class="fa fa-circle-o"></i> Laporan Data Service</a></li>
				</ul>
			</li>
			<li><a href="?open=Cetak-Barcode"><i class="fa fa-print"></i> <span>Cetak Label Barang</span></a></li>
			<li><a href="?open=Logout"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>

		<?php } elseif (isset($_SESSION['SES_PETUGAS'])) { ?>
			<li class="header" style='color:#fff; text-transform:uppercase; border-bottom:2px solid #00c0ef'>MENU <?php echo $_SESSION['level']; ?></li>
			<li><a href="?open"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			<li class="treeview">
				<a href="#"><i class="fa fa-th"></i> <span>Data Master</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="?open=Pegawai-Data"><i class="fa fa-circle-o"></i> Data Pegawai</a></li>
					<li><a href="?open=Supplier-Data"><i class="fa fa-circle-o"></i> Data Supplier</a></li>
					<li><a href="?open=Lokasi-Data"><i class="fa fa-circle-o"></i> Data Lokasi</a></li>
					<li><a href="?open=Barang-Data"><i class="fa fa-circle-o"></i> Data Barang</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#"><i class="fa fa-shopping-cart"></i> <span>Data Transaksi</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="?open=Pengadaan-Tampil"><i class="fa fa-circle-o"></i> Transaksi Pengadaan</a></li>
					<li><a href="?open=Penempatan-Tampil"><i class="fa fa-circle-o"></i> Transaksi Penempatan</a></li>
					<li><a href="?open=Mutasi-Tampil"><i class="fa fa-circle-o"></i> Transaksi Mutasi</a></li>
					<li><a href="?open=Peminjaman-Tampil"><i class="fa fa-circle-o"></i> Transaksi Peminjaman</a></li>
					<li><a href="?open=Service-Tampil"><i class="fa fa-circle-o"></i> Transaksi Service</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#"><i class="fa fa-calendar"></i> <span>Data Laporan</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="?open=Laporan-Pegawai"><i class="fa fa-circle-o"></i> Data Pegawai</a></li>
					<li><a href="?open=Laporan-Supplier"><i class="fa fa-circle-o"></i> Data Supplier</a></li>
					<li><a href="?open=Laporan-Lokasi"><i class="fa fa-circle-o"></i> Data Lokasi</a></li>
					<li><a href="?open=Laporan-Barang-Kategori"><i class="fa fa-circle-o"></i> Laporan Barang </a></li>
					<li><a href="?open=Laporan-Pengadaan-Periode"><i class="fa fa-circle-o"></i> Laporan Pengadaan </a></li>
					<li><a href="?open=Laporan-Penempatan-Periode"><i class="fa fa-circle-o"></i> Laporan Penempatan </a></li>
					<li><a href="?open=Laporan-Peminjaman-Pegawai"><i class="fa fa-circle-o"></i> Laporan Peminjaman </a></li>
					<li><a href="?open=Laporan-Service-Periode"><i class="fa fa-circle-o"></i> Laporan Data Service</a></li>
				</ul>
			</li>
			<li><a href="?open=Logout"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>
		<?php } ?>
	</ul>
</section>