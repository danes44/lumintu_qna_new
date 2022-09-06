<?php
    include 'database/connection.php';


    if(isset($_POST["nama_event"])) {
        $id_event = !empty($_POST["id_event"]) ? $_POST["id_event"] : '';
        $nama_event = !empty($_POST["nama_event"]) ? $_POST["nama_event"] : '';
        $event_mulai = !empty($_POST["event_mulai"]) ? $_POST["event_mulai"] : '';
        $event_berakhir = !empty($_POST["event_berakhir"]) ? $_POST["event_berakhir"] : '';
        $unique_code = !empty($_POST["unique_code"]) ? $_POST["unique_code"] : '';
        $id_image = !empty($_POST["id_image"]) ? $_POST["id_image"] : '';
        $id_admin = !empty($_POST["id_admin"]) ? $_POST["id_admin"] : '';

        if($_POST["id_image"] === '') {
            $sql = "UPDATE events SET unique_code='$unique_code', nama_event='$nama_event', event_mulai='$event_mulai', event_berakhir='$event_berakhir',id_admin='$id_admin' WHERE id_event='$id_event'";
        }
        else{
            $sql = "UPDATE events SET unique_code='$unique_code', nama_event='$nama_event', event_mulai='$event_mulai', event_berakhir='$event_berakhir',id_admin='$id_admin', id_image='$id_image' WHERE id_event='$id_event'";
        }

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
    else{
        var_dump($_POST["submit"]);
        echo json_encode(array(
            "statusCode" => 201,
            "statusMessage" => $_POST));
    }
    mysqli_close($conn);
?>