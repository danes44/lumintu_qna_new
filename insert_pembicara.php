<?php
    // Include the database configuration file
    include 'database/connection.php';

    if(isset($_POST["submit"])) {
        $id_pembicara = !empty($_POST["id_admin"]) ? $_POST["id_admin"] : '';
        $nama = !empty($_POST["id_image"]) ? $_POST["id_image"] : '';
        $asal = !empty($_POST["id_image"]) ? $_POST["id_image"] : '';


        $sql = "INSERT INTO `pembicara`(`id_pembicara`, `nama`, `asal_perusahaan`, `jabatan`) VALUES ([value-1],[value-2],[value-3],[value-4])";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    }

    mysqli_close($conn);
?>