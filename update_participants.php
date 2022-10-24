<?php
    include 'database/connection.php';


    if(isset($_POST["id_participant"])) {
        $id_participant = !empty($_POST["id_participant"]) ? $_POST["id_participant"] : '';
        $nama = !empty($_POST["nama"]) ? $_POST["nama"] : '';
        $email = !empty($_POST["email"]) ? $_POST["email"] : '';

        $sql_get = "SELECT * FROM participants WHERE email = '$email' AND nama = '$nama'";
        $cek = mysqli_num_rows(mysqli_query($conn,$sql_get));
        if ($cek > 0) {
            echo json_encode(array(
                "statusCode" => 202,
                "sql" => $sql_get,
                "statusMessage" => "Akun sudah dibuat sebelumnya. Gunakan email atau nama lain."));
        }
        else {
            $sql = "UPDATE participants SET nama='$nama', email='$email' WHERE id_participant='$id_participant'";


            if (mysqli_query($conn, $sql)) {
                echo json_encode(array(
                    "statusCode" => 200,
                    "statusMessage" => $_POST));
            } else {
                echo json_encode(array(
                    "statusCode" => 201,
                    "sql" => $sql,
                    "statusMessage" => "Error: " . mysqli_error($conn)));
            }
        }

    }
    else{
//        var_dump($_POST["submit"]);
        echo json_encode(array(
            "statusCode" => 201,
            "statusMessage" => $_POST));
    }
    mysqli_close($conn);
?>