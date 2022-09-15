<?php
    session_start();
    include 'database/connection.php';

    if (isset($_POST['id_sesi'])) {
        $id_sesi = !empty($_POST["id_sesi"]) ? $_POST["id_sesi"] : '';

        $sql = "SELECT * FROM events WHERE id_event = '$id_sesi' AND is_deleted = 0";

        if (mysqli_query($conn, $sql)) {
            $array_values = array();
            // output data of each row
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);

            if(empty($row["id_event"])){
                echo json_encode(array(
                    "statusCode" => 201,
                    "data" => $row));
            } else {
                echo json_encode(array(
                    "statusCode" => 200,
                    "data" => $row));
            }
        }
        else {
            echo json_encode(array(
                "statusCode" => 201,
                "statusMessage" => $conn->connect_error));
            die("Connection failed: " . $conn->connect_error);
        }
    }
    mysqli_close($conn);

?>
