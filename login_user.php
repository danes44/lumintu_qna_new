<?php 
    // Mulai session
    session_start();

    // Panggil file config
    include './database/connection.php';
    // panggil fungsi enkripsi
    include("crypt.php");

//    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    // $uri_segments = explode('/', $uri_path);


    // Check apakah terdapat post Login
    if (isset($_POST['input_nama'])) {
        // username
        $nama = htmlspecialchars($_POST['input_nama']);
        // password
        $email = mysqli_real_escape_string($conn, $_POST['input_email']);
        // id sesi
        $sesi_id = htmlspecialchars($_POST['id_sesi']);

        // sql query
        // $id = intval($_GET['id']);
        $sql = mysqli_query($conn, "SELECT * FROM participants WHERE nama ='$nama' AND email='$email'");
        $cek = mysqli_num_rows($sql);
        $hasil_sesi = mysqli_fetch_array($sql);

        // apakah user tersebut ada
        if ($cek > 0) {
            // buat session login
            $_SESSION['is_login_user'] = true;

            $id_customer = $_SESSION['id_participant'] = $hasil_sesi['id_participant'];
            $nama_customer = $_SESSION['nama_participant'] = $hasil_sesi['nama'];
            $email_customer = $_SESSION['email_participant'] = $hasil_sesi['email'];
            $_SESSION['sesi_id'] = $sesi_id;

            // beri pesan dan dialihkan ke halaman user
            $enkripsi = mycrypt("encrypt", "id_customer=$id_customer&id_session=$sesi_id");
            // echo "<br>";
            // echo 'enkripsi: '.$enkripsi;
            // echo "<script>document.location.href='user_chatroom.php?".$enkripsi."';</script>";

            echo json_encode(array(
                "statusCode" => 200,
                "statusMessage" => "Anggota lama",
                "data" => $_SESSION,
                "hasilHash" => $enkripsi));
        }
        else{
            $sql_insert = "INSERT INTO participants(nama, email) VALUES ('$nama','$email')";

            if (mysqli_query($conn, $sql_insert)) {
                $_SESSION['is_login_user'] = true;

                $id_customer = $_SESSION['id_participant'] = $conn->insert_id;
                $nama_customer = $_SESSION['nama_participant'] = $nama;
                $email_customer = $_SESSION['email_participant'] = $email;
                $_SESSION['sesi_id'] = $sesi_id;

                // beri pesan dan dialihkan ke halaman user
               $enkripsi = mycrypt("encrypt", "id_customer=$id_customer&id_session=$sesi_id");
//                 echo "<br>";
//                 echo 'enkripsi: '.$enkripsi;
//                 echo "<script>document.location.href='user_chatroom.php?".$enkripsi."';</script>";

//                echo json_encode(array(
//                    "statusCode" => 200,
//                    "statusMessage" => "Anggota baru",
//                    "hasilHash" => $enkripsi));
                echo json_encode(array(
                    "statusCode" => 200,
                    "statusMessage" => "Anggota baru",
                    "data" => $_SESSION,
                    "hasilHash" => $enkripsi));
            } else {
                echo json_encode(array(
                    "statusCode" => 201,
                    "statusMessage" => $sql_insert." Error: " . mysqli_error($conn)));
//                echo "Error: " . mysqli_error($conn);
            }

            // beri pesan dan dialihkan ke halaman login
//            echo "<script>alert('Selamat Datang!')</script>";
        }
    }
    else{
//        var_dump($_POST);
        echo json_encode(array(
            "statusCode" => 201,
            "statusMessage" => $_POST));
        echo "<script>document.location.href='index_user.php';</script>";
    }
    mysqli_close($conn);
?>