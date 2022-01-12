<?php
<<<<<<< HEAD
include("connection.php");
$id_chat = $_GET['id_session'];
$id_session = $_GET['id_session'];
$sql = mysqli_query($conn, "SELECT * from chats WHERE id_chat='$id_chat' and id_session='$id_session'");
$cek = mysqli_num_rows($sql);

$url_sesi = "http://192.168.18.76:8001/items/session?fields=session_id,start_time,finish_time&filter[session_id]=".$id_session;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url_sesi);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$response_sesi = curl_exec($curl);
$hasil_sesi = json_decode($response_sesi, true);
curl_close($curl);

$jam_mulai = $hasil_sesi["data"][0]["start_time"];
$jam_selesai = $hasil_sesi["data"][0]["finish_time"];
	
	if ($cek > 0) {
		if ( new DateTime("2021-12-01T10:00:00") >= new DateTime($jam_mulai) && new DateTime("2021-12-01T11:00:00") < new DateTime($jam_selesai) ){ // SUDAH BERJALAN
			echo "<script>alert('Memasuki Chatroom!');document.location.href='../admin/admin_chatroom.php?id_session=".$id_chat."';</script>";
		} else { // SUDAH SELESAI
			$sql2 = mysqli_query($conn, "UPDATE chats SET status='1' WHERE id_chat=$id_chat");
			echo "<script>alert('Sesi sudah selesai!');document.location.href='../error-page/error_jam_sudah.html';</script>";
		}
	} else { // BELUM DIMULAI
		$sql1 = mysqli_query($conn, "INSERT into chats (id_chat, id_session, status) VALUES ($id_chat, $id_session, 0)");
		echo "<script>alert('Enter Chatroom!');document.location.href='../admin/admin_chatroom.php?id_session=".$id_chat."';</script>";
	}
=======
	include("connection.php");
	include("../api.php");

	// $kel1_api = "http://192.168.18.67:8001";

	$id_chat = $_GET['id_session'];
	$id_session = $_GET['id_session'];
	$sql = mysqli_query($conn, "SELECT * from chats WHERE id_chat='$id_chat' and id_session='$id_session'");
	$cek = mysqli_num_rows($sql);
	
	$url_sesi = $kel1_api."/items/session?fields=session_id,start_time,finish_time&filter[session_id]=".$id_session;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url_sesi);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$response_sesi = curl_exec($curl);
	$hasil_sesi = json_decode($response_sesi, true);
	curl_close($curl);

	$jam_mulai = $hasil_sesi["data"][0]["start_time"];
	$jam_selesai = $hasil_sesi["data"][0]["finish_time"];

	$temp = new DateTime($jam_mulai);
	// echo $temp->;
	echo $jam_mulai;
		
		if ($cek > 0) { 
			// if ( new DateTime("2021-12-01T10:00:00") >= new DateTime($jam_mulai) && new DateTime("2021-12-01T11:00:00") < new DateTime($jam_selesai) ){ // SUDAH BERJALAN
			if ( new DateTime("2021-12-01T10:00:00") >= new DateTime($jam_mulai) && new DateTime("2021-12-01T11:00:00") < new DateTime($jam_selesai) ){ // SUDAH BERJALAN
				echo "<script>alert('Memasuki Chatroom!');document.location.href='../admin/admin_chatroom.php?id_session=".$id_chat."';</script>";
			} else { // SUDAH SELESAI
				$sql2 = mysqli_query($conn, "UPDATE chats SET status='1' WHERE id_chat=$id_chat");
				echo "<script>alert('Sesi sudah selesai!');document.location.href='../error-page/error_jam_sudah.html';</script>";
			}
		} else { // BELUM DIMULAI
			$sql1 = mysqli_query($conn, "INSERT into chats (id_chat, id_session, status) VALUES ($id_chat, $id_session, 0)");
			echo "<script>alert('Enter Chatroom!');document.location.href='../admin/admin_chatroom.php?id_session=".$id_chat."';</script>";
		}
>>>>>>> ca6199b39032131972b84110ce667b32c73b834a
?>