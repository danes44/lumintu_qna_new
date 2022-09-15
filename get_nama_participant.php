<?php
    include 'database/connection.php';

    $id_participant=!empty($_POST['id_participant']) ? $_POST['id_participant'] : '';
    $sql = "SELECT * FROM participants WHERE id_participant = '$id_participant'";

    if (mysqli_query($conn, $sql)) {
        $array_values = array();
        // output data of each row
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);

        if(empty($row["nama"])){
            echo json_encode(array(
                "statusCode" => 200,
                "nama" => 'Kamu'));
        } else {
            echo json_encode(array(
                "statusCode" => 200,
                "nama" => $row["nama"]));
        }
    }
    else {
        echo json_encode(array(
            "statusCode" => 201,
            "statusMessage" => $conn->connect_error));
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_close($conn);
?>