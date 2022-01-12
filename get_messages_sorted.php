<?php

    include 'database/connection.php';
//    $status=!empty($_POST["status"]) ? $_POST["status"] : '';
//    $nama=!empty($_POST["nama"]) ? $_POST["nama"] : '';
//    $length=!empty($_POST["length"]) ? $_POST["length"] : '';

//    if($status == 0)
//    {
//        echo "masuk else php".$status;
//        for ($i=0; $i < $length ; $i++){
//
//        }
        $sql = "SELECT * FROM messages where status = 0 ORDER BY waktu_pengiriman ASC";
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
