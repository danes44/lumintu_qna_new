<?php
require('../database/connection.php');
$host = '23.100.16.66';
$ports = range(8000,9000);
foreach ($ports as $port) {
    $connection = @fsockopen($host, $port);
    if (is_resource($connection))
    {
        echo $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') sudah digunakan.' . "\n";
        fclose($connection);
    }
    else
    {
        echo $host . ':' . $port . ' belum digunakan.' . "\n";
        echo $port;
        $checkdata = "UPDATE chats SET port =  
        (SELECT $port
        FROM (SELECT 1)a WHERE NOT EXISTS (SELECT port FROM chats WHERE port = $port)) where port is null limit 1";
        //$dd = "update chats set port = ";
        $runQuery = mysqli_query($conn, $checkdata) or die(mysqli_error($conn));
        $numRow = $conn->affected_rows;
        
        if($numRow == 0){
        // if($conn->query($checkdata) === TRUE){
            echo "\nport " . $port . ' ' . '(' .getservbyport($port, 'tcp') . ') sudah ada dalam database.' . "\n";
        }
        else{
            echo "\nPort berhasil ditambahkan\n";
            // $update = "UPDATE chats SET status = 1 where port is not null limit 1";
            // $runQuery = mysqli_query($conn, $update) or die(mysqli_error($conn));
            // $numRow = $conn->affected_rows;
            // $query = "INSERT INTO port (port) values ($port)";
            
            // if($conn->query($query) === TRUE){
            //     echo "\nPort berhasil ditambahkan\n";
            // }
            // else {
            //     echo "\nGagal memasukkan port";
            // }
            $conn->close();
            break;
        }
    }
}
?>