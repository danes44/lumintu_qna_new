<?php

    include 'database/connection.php';
    //    $status=!empty($_POST["status"]) ? $_POST["status"] : '';
    $id_message=!empty($_POST['id_message']) ? $_POST['id_message'] : '';


//    if($status == 3) {
    //        echo "all";
    $sql = "SELECT * FROM messages where id_message = '$id_message'";
    //    }
    //    elseif ($status == 0 || $status == 1 || $status == 2) {
    //        echo "masuk else php".$status;
    //        $sql = "SELECT * FROM messages where status = '$status'";
    //    }

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
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_close($conn);

?>
