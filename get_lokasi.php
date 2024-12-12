	<?php
    include_once "library/inc.connection.php";
    $cmbDepartemen = $_POST['cmbDepartemen'];

    echo "<option value=''>Pilih Kabupaten</option>";

    $query = "SELECT * FROM lokasi WHERE kd_departemen=? ORDER BY nm_lokasi ASC";
    $dewan1 = $db1->prepare($query);
    $dewan1->bind_param("i", $cmbDepartemen);
    $dewan1->execute();
    $res1 = $dewan1->get_result();
    while ($row = $res1->fetch_assoc()) {
        echo "<option value='" . $row['kd_lokasi'] . "'>" . $row['nm_lokasi'] . "</option>";
    }
    ?>