<?php
    include 'database/connection.php';

    $id_note=!empty($_POST['id_note']) ? $_POST['id_note'] : '';

    $sql = "UPDATE note SET is_deleted=1 WHERE id_note='$id_note'";
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