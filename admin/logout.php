<?php 
    session_start();
    if (isset($_SESSION['is_login'])) {
        /* delete admin session variable */
        unset($_SESSION['is_login']);
        unset($_SESSION['id_admin']);
        unset($_SESSION['username']);
        unset($_SESSION['sesi_id']);

        echo "<script>document.location.href='index.php';</script>";

    }
?>