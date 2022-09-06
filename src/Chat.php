<?php

//Chat.php

namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require dirname(__DIR__) . "/database/ChatRooms.php";


class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo 'Server Started ';
    }

    public function onOpen(ConnectionInterface $conn) {

        $this->clients->attach($conn);

        $querystring = $conn->httpRequest->getUri()->getQuery();

        parse_str($querystring, $queryarray);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        date_default_timezone_set("Asia/Jakarta");
        $numRecv = count($this->clients) - 1;
        $data = json_decode($msg, true);

        echo sprintf('Connection %d from '. $data['asal'] .' sending message "%s" to %d other connection%s on '. $data['date'] . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $chat_object = new \ChatRooms;

        $chat_object->setAsalMessage($data['asal']);
        // $chat_object->setMessageId($data["mId"]);

        if($data['asal'] == 'user'){
            $chat_object->setChatId($data["sesiId"]); // value nya ambil dari id_chat yang di chats
            $chat_object->setPengirimId($data['userId']);
            $chat_object->setMessage($data['msg']);
            $chat_object->setStatus(0);
            $chat_object->setCreatedOn($data['date']);
            $chat_object->setIsEdited($data['is_edited']);

            $chat_object->save_chat();
        }
        else{
            $chat_object->setChatId($data["sesiId"]); // value nya ambil dari id_chat yang di chats
            $chat_object->setPengirimId($data['userId']);
            $chat_object->setMessage($data['msg']);
            $chat_object->setCreatedOn($data['date']);
            $chat_object->setIsEdited($data['is_edited']);
        }

        $chat_last = new \ChatRooms;

        $last_chat = $chat_last->get_id_last_chat();
        
        foreach ($this->clients as $client) {

            if($from == $client)
            {
                $data['from'] = 'Me';
            }
            else
            {
                $data['from'] = 'Other';
            }

            if($data['asal'] == 'user') {
                $data['mId'] = $last_chat[0]["id_message"];
            }

            $client->send(json_encode($data));
        }
        
    }

    public function onClose(ConnectionInterface $conn) {

        $querystring = $conn->httpRequest->getUri()->getQuery();

        parse_str($querystring, $queryarray);

        if(isset($queryarray['token']))
        {

            $user_object = new \ChatUser;

            foreach($this->clients as $client)
            {
                $client->send(json_encode($data));
            }
        }
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

?>