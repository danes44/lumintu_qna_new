<?php
//    include 'database/connection.php';
    $servername = "localhost";
    $database = "lumintu_qna";
    $username = "root";
    $password = "";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $id_message= !empty($_POST["id_message"]) ? $_POST["id_message"] : '';
    $id_chat= !empty($_POST["id_chat"]) ? $_POST["id_chat"] : '';
    $id_pengirim= !empty($_POST["id_pengirim"]) ? $_POST["id_pengirim"] : '';
    $pesan= !empty($_POST["pesan"]) ? $_POST["pesan"] : '';
    $status= !empty($_POST["status"]) ? $_POST["status"] : '';
    $waktu_pengiriman= !empty($_POST["waktu_pengiriman"]) ? $_POST["waktu_pengiriman"] : '';

    if($status == 0){
        echo $id_message." ". $id_pengirim. " ".$id_chat." ". $id_pengirim . " " .  $pesan . " ".  $status ." ". $waktu_pengiriman;
        $sql = "INSERT INTO messages 
			(id_message, id_chat, id_pengirim, pesan, status, waktu_pengiriman) 
			VALUES ('$id_message', '$id_chat', '$id_pengirim', '$pesan', '$status', '$waktu_pengiriman')
		";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode"=>200));
        }
        else {
            echo json_encode(array("statusCode"=>201));
        }
    }

    mysqli_close($conn);
?>