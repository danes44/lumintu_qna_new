<?php
// $kel1_api = "http://192.168.18.67:8001";

//function get_nama($id_participant){
//    require("api.php");
////	 echo $id_participant;
////    $kel1_api = "http://192.168.18.67:8001";
//	$url = $kel1_api."/items/customer?fields=customer_id,customer_name&filter[customer_id]=".$id_participant;
//    $curl = curl_init();
//    curl_setopt($curl, CURLOPT_URL, $url);
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//    $response = curl_exec($curl);
//    $hasil = json_decode($response, true);
//    if(empty($hasil["data"])){
//    	return "Kamu";
//    } else {
//	    $nama = $hasil["data"][0]["customer_name"];
//	    return $nama;
//	}
//}
function get_nama($id_participant){
    include 'database/connection.php';
    $sql = "SELECT * FROM participants WHERE id_participant = '$id_participant'";

    if (mysqli_query($conn, $sql)) {
        $array_values = array();
        // output data of each row
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);

        if(empty($row["nama"])){
            return "Kamu";
        } else {
            return $row["nama"];
        }
    }
    else {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_close($conn);
}

function get_email($id_participant){
    include 'database/connection.php';
    $sql = "SELECT * FROM participants WHERE id_participant = '$id_participant'";

    if (mysqli_query($conn, $sql)) {
        $array_values = array();
        // output data of each row
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);

        if(empty($row["nama"])){
            return "Kamu";
        } else {
            return $row["email"];
        }
    }
    else {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_close($conn);
}
?>