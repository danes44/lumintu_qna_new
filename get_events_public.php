<?php
    session_start();
    include 'database/connection.php';
//    echo $_SESSION['id_admin'];
//    var_dump($_SESSION);
//    $sql = "SELECT events.*, images.image FROM events JOIN images ON events.id_image = images.id WHERE events.id_admin = '$id_admin'";
    $sql = "SELECT events.*, images.name AS photo_name FROM `events` JOIN images ON events.id_image = images.id";
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
