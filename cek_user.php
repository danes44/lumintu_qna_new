<?php
    include("crypt.php");
    // mendapatkan id dari hash 
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    $hasilHash = mycrypt("decrypt", $uri_path);
    $arrayHasil = explode("&", $hasilHash);
    $peserta_id = explode("=",$arrayHasil[0]);
    $ticket_id = explode("=",$arrayHasil[1]);
    $sesi_id = explode("=",$arrayHasil[2]);
    // mendapatkan json sesuai id peserta dan id sesi
    $url = "http://192.168.18.76:8002/items/registration?fields=validated_on,id_participant,id_session&filter[id_session]=".$sesi_id[1]."&filter[id_participant]=".$peserta_id[1];
	$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    $hasil = json_decode($response, true);
    curl_close($curl);

    $url_sesi = "http://192.168.18.76:8001/items/session?fields=session_id,start_time,finish_time&filter[session_id]=".$sesi_id[1];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url_sesi);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response_sesi = curl_exec($curl);
    $hasil_sesi = json_decode($response_sesi, true);
    curl_close($curl);

    // cek waktu sesi sudah mulai atau belum, dan sesi sudah selesai atau belum
    $jam_mulai = $hasil_sesi["data"][0]["start_time"];
    $jam_selesai = $hasil_sesi["data"][0]["finish_time"];

    // cek sudah checkpoint atau belum
    $cek_check = $hasil["data"][0]["validated_on"];

    if (empty($hasil["data"])){
        echo "<script>alert('peserta tidak ada!');document.location.href='/lumintu_qna/error-page/error_link_salah.html';</script>";
    } else {
        if ( new DateTime("2021-12-01T10:00:00") >= new DateTime($jam_mulai) && new DateTime("2021-12-01T11:00:00") < new DateTime($jam_selesai) ){
            if (is_null($cek_check)){
            echo "<script>alert('peserta belum checkpoint!');document.location.href='/lumintu_qna/error-page/error_checkpoint.html';</script>";
            } else {
                echo "<script>alert('peserta dengan id ".$hasil["data"][0]["id_participant"]." jam mulai :".$jam_mulai.", silahkan masuk!');document.location.href='/lumintu_qna/user_chatroom.php?".$uri_path."';</script>";
            }
        } else if ( new DateTime("2021-12-01T13:00:00") >= new DateTime($jam_selesai)){
            echo "<script>alert('sesi sudah selesai!');document.location.href='/lumintu_qna/error-page/error_jam_mulai.html';</script>";
        } else {
            echo "<script>alert('sesi belum dimulai!');document.location.href='/lumintu_qna/error-page/error_jam_belum.php';</script>";
        }
    }
?>