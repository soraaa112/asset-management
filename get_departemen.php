<?php
include_once "library/inc.connection.php";

echo "<option value=''>Pilih Departemen </option>";

$query = "SELECT * FROM departemen ORDER BY nm_departemen ASC";
$dewan1 = $db1->prepare($query);
$dewan1->execute();
$res1 = $dewan1->get_result();
while ($row = $res1->fetch_assoc()) {
    echo "<option value='" . $row['kd_departemen'] . "'>" . $row['nm_departemen'] . "</option>";
}
