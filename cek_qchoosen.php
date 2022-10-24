<?php 
	function cek_qchoosen($id_session){
		require("database/connection.php");
		$sql_sesi = "SELECT * FROM messages WHERE id_chat = '$id_session' AND (status = 1 OR status = 4 OR status = 5 OR status = 6)";
	    $result = $conn->query($sql_sesi);
	    if ($result->num_rows > 0) {
	        return "1";
		} else {
			return "2";
		}
	}
?>