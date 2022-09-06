<?php
    include 'database/connection.php';

    $id_message=!empty($_POST['id_message']) ? $_POST['id_message'] : '';
    $pesan=!empty($_POST["pesan"]) ? $_POST["pesan"] : '';
    $is_edited=!empty($_POST["is_edited"]) ? $_POST["is_edited"] : '';

    $sql = "UPDATE messages SET pesan='$pesan', is_edited='$is_edited' WHERE id_message='$id_message'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(array("statusCode"=>200));
    }
    else {
        echo json_encode(array("statusCode"=>201));
    }
    mysqli_close($conn);
?>