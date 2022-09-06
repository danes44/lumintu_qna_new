<?php
    // Include the database configuration file
    include 'connection.php';

    // If file upload form is submitted
    $insert = false;
    $last_id = $status = $statusMsg = '';

    if(isset($_FILES["input-gambar"])){
        $name = $_FILES['input-gambar']['name'];
        $status = 'error';
        if(!empty($_FILES['input-gambar']['name'])) {


            $query = "SELECT * FROM images WHERE name = '$name' LIMIT 1 ";
            $result = mysqli_query($conn,$query);

            // Check if photo existed
            if (mysqli_query($conn,$query)) {
                if (mysqli_num_rows($result) > 0) {
                    $status = 'Sudah Ada Photo yang sama';
                    $insert = true;
                    while($row = $result->fetch_assoc()) {
                        $last_id = $row["id"];
                    }
                }
                else {
                    if($_FILES['input-gambar']['size'] <= 5242880) { //5 MB (size in bytes)
                        // File within size restrictions

                        $target_dir = "../img/";
                        $target_file = $target_dir . basename($_FILES["input-gambar"]["name"]);

                        // Select file type
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                        // Valid file extensions
                        $extensions_arr = array("jpg","jpeg","png","gif");
                        // Check extension
                        if( in_array($imageFileType,$extensions_arr) ){
                            // Upload file
                            if(move_uploaded_file($_FILES['input-gambar']['tmp_name'],$target_dir.$name)){
                                // Insert record
                                $insert = $conn->query("insert into images(name) values('".$name."')");

                                if($insert){
                                    $status = 'success';
                                    $statusMsg = "Sukses diunggah.";
                                    $last_id = $conn->insert_id;
                                }
                                else{
                                    $statusMsg = "Gagal mengunggah, coba lagi.";
                                }
                            }

                        }
                        else{
                            $statusMsg = 'Hanya format JPG, JPEG, PNG, & GIF.';
                        }
                    }
                    else {
                        // File too big
                        $statusMsg = 'Ukuran maksimal adalah 5MB.';
                    }
                }
            }
            else {
                $status = 'Error: '.mysqli_error($conn);
            }

        }
        else{
            $statusMsg = 'Mohon pilih gambar.';
        }
    }
    else if(isset($_FILES["input-gambar-edit"])){
        $name = $_FILES['input-gambar-edit']['name'];
        $status = 'error';
        if(!empty($_FILES['input-gambar-edit']['name'])) {

            $query = "SELECT * FROM images WHERE name = '$name' LIMIT 1 ";
            $result = mysqli_query($conn,$query);

            // Check if photo existed
            if (mysqli_query($conn,$query)) {
                if (mysqli_num_rows($result) > 0) {
                    $status = 'Sudah Ada Photo yang sama';
                    $insert = true;
                    while($row = $result->fetch_assoc()) {
                        $last_id = $row["id"];
                    }
                }
                else {
                    if($_FILES['input-gambar-edit']['size'] <= 5242880) { //5 MB (size in bytes)
                        // File within size restrictions

                        $target_dir = "../img/";
                        $target_file = $target_dir . basename($_FILES["input-gambar-edit"]["name"]);

                        // Select file type
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                        // Valid file extensions
                        $extensions_arr = array("jpg","jpeg","png","gif");
                        // Check extension
                        if( in_array($imageFileType,$extensions_arr) ){
                            // Upload file
                            if(move_uploaded_file($_FILES['input-gambar-edit']['tmp_name'],$target_dir.$name)){
                                // Insert record
                                $insert = $conn->query("insert into images(name) values('".$name."')");

                                if($insert){
                                    $status = 'success';
                                    $statusMsg = "Sukses diunggah.";
                                    $last_id = $conn->insert_id;
                                }
                                else{
                                    $statusMsg = "Gagal mengunggah, coba lagi.";
                                }
                            }

                        }
                        else{
                            $statusMsg = 'Hanya format JPG, JPEG, PNG, & GIF.';
                        }
                    }
                    else {
                        // File too big
                        $statusMsg = 'Ukuran maksimal adalah 5MB.';
                    }
                }
            }
            else {
                $status = 'Error: '.mysqli_error($conn);
            }

        }
        else{
            $statusMsg = 'Mohon pilih gambar.';
        }
    }
    else{
        $statusMsg = $_FILES;
    }

    // return data response
    if ($insert) {
        echo json_encode(array(
            "statusCode" => 200,
            "lastId" => $last_id,
            "statusMessage" => $statusMsg
        ));
    } else {
        echo json_encode(array(
            "statusCode" => 201,
            "files" => $_FILES,
            "statusMessage" => $statusMsg
        ));
    }

?>