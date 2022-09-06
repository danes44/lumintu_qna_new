<?php
    // Include the database configuration file
    include 'database/connection.php';

    if(isset($_POST["nama_event"])) {
        $unique_code = !empty($_POST["unique_code"]) ? $_POST["unique_code"] : '';
        $nama_event = !empty($_POST["nama_event"]) ? $_POST["nama_event"] : '';
        $event_mulai = !empty($_POST["event_mulai"]) ? $_POST["event_mulai"] : '';
        $event_berakhir = !empty($_POST["event_berakhir"]) ? $_POST["event_berakhir"] : '';
        $id_image = !empty($_POST["id_image"]) ? $_POST["id_image"] : '';
        $id_admin = !empty($_POST["id_admin"]) ? $_POST["id_admin"] : '';

        /*$status = 'error';
        if(!empty($_FILES['gambar']['name'])) {
            if($_FILES['gambar']['size'] <= 5242880) { //5 MB (size in bytes)
                // File within size restrictions
                $name = $_FILES['gambar']['name'];
                $target_dir = "../img/";
                $target_file = $target_dir . basename($_FILES["gambar"]["name"]);

                // Select file type
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // Valid file extensions
                $extensions_arr = array("jpg","jpeg","png","gif");
                // Check extension
                if( in_array($imageFileType,$extensions_arr) ){
                    // Upload file
                    if(move_uploaded_file($_FILES['gambar']['tmp_name'],$target_dir.$name)){
                        // Insert record
                        $insert = $conn->query("insert into images(name) values('".$name."')");

                        if($insert){
                            $status = 'success';
                            $statusMsg = "File uploaded successfully.";
                        }else{
                            $statusMsg = "File upload failed, please try again.";
                        }
                    }

                }
                else{
                    $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                }
            } else {
                // File too big
                $statusMsg = 'Sorry, max size is 5MB only.';
            }

        }else{
            $statusMsg = 'Please select an image file to upload.';
        }*/

        $sql = "INSERT INTO events(unique_code, nama_event, event_mulai, event_berakhir,id_image,id_admin) VALUES ('$unique_code' ,'$nama_event' ,'$event_mulai' ,'$event_berakhir' , '$id_image' ,'$id_admin' )";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array(
                "statusCode" => 200,
                "statusMessage" => $conn->insert_id));
        } else {
            echo json_encode(array(
                "statusCode" => 201,
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