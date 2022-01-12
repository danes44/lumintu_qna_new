<?php

//server.php

use Ratchet\Server\IoServer; 
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;
<<<<<<< HEAD
require_once '..\admin\check_port.php';

    require dirname(__DIR__) . '/vendor/autoload.php';
=======

    require dirname(__DIR__) . '/vendor/autoload.php';

>>>>>>> ca6199b39032131972b84110ce667b32c73b834a
    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Chat()
            )
        ),
<<<<<<< HEAD
        $port
=======
        8082
>>>>>>> ca6199b39032131972b84110ce667b32c73b834a
    );

    $server->run();


?>