<?php
	include 'database/connection.php';
    $id_message=!empty($_POST['id_message']) ? $_POST['id_message'] : '';
    $status=!empty($_POST["status"]) ? $_POST["status"] : '';

	$sql = "UPDATE messages SET status='$status' WHERE id_message='$id_message'";
	if (mysqli_query($conn, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);
?>