<?php

// $kel1_api = "http://192.168.18.67:8001";

function get_nama($id_participant){
    require("api.php");
//	 echo $id_participant;
//    $kel1_api = "http://192.168.18.67:8001";
	$url = $kel1_api."/items/customer?fields=customer_id,customer_name&filter[customer_id]=".$id_participant;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    $hasil = json_decode($response, true);
    if(empty($hasil["data"])){
    	return "Kamu";
    } else {
	    $nama = $hasil["data"][0]["customer_name"];
	    return $nama;
	}
}
?>