<?php
    // Include the database configuration file
    include 'database/connection.php';

    if(isset($_POST["isi_note"])) {
        $isi_note = !empty($_POST["isi_note"]) ? $_POST["isi_note"] : '';
        $id_event = !empty($_POST["id_event"]) ? $_POST["id_event"] : '';


        $sql = "INSERT INTO note(isi_note, id_event) VALUES ('$isi_note' ,'$id_event' )";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array(
                "statusCode" => 200,
                "id" => $conn->insert_id));
        } else {
            echo json_encode(array(
                "statusCode" => 201,
                "statusMessage" => "Error: " . mysqli_error($conn)));
        }
    }
    else{
        var_dump($_POST["isi_note"]);
        echo json_encode(array(
            "statusCode" => 201,
            "statusMessage" => $_POST));
    }

    mysqli_close($conn);
?>