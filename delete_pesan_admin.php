<?php
    include 'database/connection.php';

    $id_pesan_admin=!empty($_POST['id_pesan_admin']) ? $_POST['id_pesan_admin'] : '';

    $sql = "UPDATE pesan_admin SET is_deleted=1 WHERE id_pesan='$id_pesan_admin'";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(array(
            "statusCode" => 200,
            "statusMessage" => $_POST));
    }
    else {
        echo json_encode(array(
            "statusCode" => 201,
            "statusMessage" => $_POST));;
    }
    mysqli_close($conn);
?>