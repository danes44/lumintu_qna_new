<?php
    session_start();
    include 'database/connection.php';
    $id_message = !empty($_POST["id_message"]) ? $_POST["id_message"] : '';

    $sql = "SELECT messages.*, note.* FROM `messages` JOIN note ON messages.id_note = note.id_note WHERE message.id_message = '$id_message'";

    if (mysqli_query($conn, $sql)) {
        $array_values = array();
        // output data of each row
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $array_values[] = $row;
        };
        echo json_encode($array_values);
    }
    else {
        echo json_encode(array(
            "statusCode" => 201,
            "statusMessage" => $conn->connect_error));
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_close($conn);

?>
