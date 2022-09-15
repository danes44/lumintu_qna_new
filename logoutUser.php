<?php
    // panggil fungsi enkripsi
//    include("crypt.php");
    session_start();
    if (isset($_SESSION['is_login_user'])) {
//        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
//        $arr_sesi_id = explode("=",$uri_path);
//        $sesi_id = $arr_sesi_id[1];
//        $enkripsi = mycrypt("encrypt", "id_session=$sesi_id");

        /* delete user session variable */
        unset($_SESSION['id_participant']);
        unset($_SESSION['nama_participant']);
        unset($_SESSION['email_participant']);
        unset($_SESSION['is_login_user']);
        unset($_SESSION['sesi_id']);
    }

    echo "<script>document.location.href='index_user.php';</script>";

?>