<?php
$host = '23.100.16.66';
$ports = range(22,24);
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
        break;
    }
}
?>