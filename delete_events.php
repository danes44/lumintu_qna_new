<?php
    include 'database/connection.php';


    if(isset($_POST["id_event"])) {
        $id_event = !empty($_POST["id_event"]) ? $_POST["id_event"] : '';
        $id_admin = !empty($_POST["id_admin"]) ? $_POST["id_admin"] : '';

        $sql = "UPDATE events SET is_deleted=1 WHERE id_event='$id_event' AND id_admin='$id_admin'";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array(
                "statusCode" => 200,
                "statusMessage" => $_POST));
        } else {
            echo json_encode(array(
                "statusCode" => 201,
                "sql" => $sql,
                "statusMessage" => "Error: " . mysqli_error($conn)));
        }
    }
    else{
        echo json_encode(array(
            "statusCode" => 201,
            "statusMessage" => $_POST));
    }
    mysqli_close($conn);
?>