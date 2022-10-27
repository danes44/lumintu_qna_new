<?php
    include("connection.php");
    include("../api.php");

    $id_chat = $_GET['id_session'];
    $id_session = $_GET['id_session'];
//    $sql = mysqli_query($conn, "SELECT * from chats WHERE id_chat='$id_chat' and id_session='$id_session'");
//    $sql = mysqli_query($conn, "SELECT * from chats WHERE id_chat='$id_session'");
//    $cek = mysqli_num_rows($sql);

    $sql_events = mysqli_query($conn, "SELECT * FROM events WHERE id_event='$id_session'");

    $hasil_sesi = mysqli_fetch_array($sql_events);
    $cek = mysqli_num_rows($sql_events);

    $jam_mulai = $hasil_sesi["event_mulai"];
    $jam_selesai = $hasil_sesi["event_berakhir"];

    $temp = new DateTime($jam_mulai);
    $current_time = new DateTime("2021-12-01T11:00:00");

    var_dump($cek);
    if ($cek > 0) {
        /*if ( $current_time >= new DateTime($jam_mulai) && $current_time < new DateTime($jam_selesai) ){ // SUDAH BERJALAN
            echo "<script>alert('Memasuki Chatroom!');document.location.href='../admin/admin_chatroom.php?id_session=".$id_chat."';</script>";
        }*/
        if ( $current_time < new DateTime($jam_selesai) ){ // SUDAH BERJALAN
            echo "<script>document.location.href='../admin/admin_chatroom.php?id_session=".$id_chat."';</script>";
        }
        else { // SUDAH SELESAI
//            $sql2 = mysqli_query($conn, "UPDATE chats SET status='1' WHERE id_chat=$id_chat");
            echo "<script>alert('Sesi sudah selesai!');document.location.href='../error-page/error_jam_sudah.html';</script>";
        }
    }
    /*else { // BELUM DIMULAI
        $sql1 = mysqli_query($conn, "INSERT into chats (id_chat, id_session, status) VALUES ($id_chat, $id_session, 0)");

        echo "<script>alert('Enter Chatroom!');document.location.href='../admin/admin_chatroom.php?id_session=".$id_chat."';</script>";
    }*/
?>