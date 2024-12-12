<?php
if (isset($_SESSION['SES_ADMIN'])) {
	include "home_admin_row1.php";
} else if (isset($_SESSION['SES_OPERATOR'])) {
	include "home_admin_row1.php";
} elseif (isset($_SESSION['SES_PETUGAS'])) {
	include "home_admin_row1.php";
}
