<?php
require('../database/connection.php');
$host = '23.100.16.66';
$ports = range(8000, 9000);
foreach ($ports as $port) {
    $connection = @fsockopen($host, $port);
    if (is_resource($connection))
    {
        echo 'port ' . $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') sudah terpakai.' . "\n";
        fclose($connection);
    }
    else
    {
        echo 'port ' . $host . ':' . $port . ' belum terpakai.' . "\n";
        echo $port;
        if ($conn->connect_error){
            die("Koneksi gagal" . $conn->connect_error);
        }
            $query = "UPDATE chats SET port = $port where port is null limit 1";
            
            if($conn->query($query) === TRUE){
                echo "\nPort berhasil dimasukkan\n";
            }
            else {
                echo "Error";
            }
            $conn->close();
            break;
    }
}
?>