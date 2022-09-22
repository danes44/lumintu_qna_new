<?php 
function mycrypt($action, $data){
    $secret_key="frumentius442120";
    $secret_iv="3501320421388490";

	$key = hash("sha256", $secret_key);
	$iv = substr(hash("sha256", $secret_iv), 0, 16);
	switch($action){
		case "encrypt":
			return openssl_encrypt($data, "aes-128-cbc", $key, 0, $iv);
			break;
		case "decrypt":
			return openssl_decrypt($data, "aes-128-cbc", $key, 0, $iv);
			break;
	}
}
?>