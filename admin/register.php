<?php
// Mulai session
session_start();

// Panggil file config
include '../database/connection.php';

// Check apakah terdapat post Login
if (isset($_POST['email'])) {
    // username
    $email = htmlspecialchars($_POST['email']);
    // username
    $user = htmlspecialchars($_POST['user']);
    // password
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    // sql query
    // $id = intval($_GET['id']);
    // check apakah sudah ada
    $sql_get = "SELECT * FROM admins WHERE email = '$email' OR username = '$user'";
    $cek = mysqli_num_rows(mysqli_query($conn,$sql_get));
    if ($cek > 0) {
        echo json_encode(array(
            "statusCode" => 202,
            "sql" => $sql_get,
            "statusMessage" => "Akun sudah dibuat sebelumnya."));
    }
    else{
        $sql = "INSERT INTO admins( email, password, username) VALUES ('$email','$pass','$user')";

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

?>