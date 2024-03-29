<?php 
	
class ChatRooms
{
    private $is_edited;
    private $asal;
    private $message_id;
    private $chat_id;
    private $id_pengirim;
    private $message;
    private $status;
    private $created_on;
    private $nama_user;
    protected $connect;

    public function setNamaUser($nama_user)
    {
        $this->nama_user = $nama_user;
    }
    public function getNamaUser()
    {
        return $this->nama_user;
    }

    public function setIsEdited($is_edited)
    {
        $this->is_edited = $is_edited;
    }

    function getIsEdited()
    {
        return $this->is_edited;
    }

    public function setAsalMessage($asal)
    {
        $this->asal = $asal;
    }

    function getAsalMessage()
    {
        return $this->asal;
    }

    public function setMessageId($message_id)
    {
        $this->message_id = $message_id;
    }

    function getMessageId()
    {
        return $this->message_id;
    }

    public function setChatId($chat_id)
    {
        $this->chat_id = $chat_id;
    }

    function getChatId()
    {
        return $this->chat_id;
    }

    function setPengirimId($id_pengirim)
    {
        $this->id_pengirim = $id_pengirim;
    }

    function getPengirimId()
    {
        return $this->id_pengirim;
    }

    function setMessage($message)
    {
        $this->message = $message;
    }

    function getMessage()
    {
        return $this->message;
    }

    function setStatus($status)
    {
        $this->status = $status;
    }

    function getStatus()
    {
        return $this->status;
    }

    function setCreatedOn($created_on)
    {
        $this->created_on = $created_on;
    }

    function getCreatedOn()
    {
        return $this->created_on;
    }

    public function __construct()
    {
        require_once("Database_connection.php");

        $database_object = new Database_connection;

        $this->connect = $database_object->connect();
    }

    function save_chat()
    {
        $query = "
		INSERT INTO messages 
			(id_message, id_chat, id_pengirim, pesan, status, waktu_pengiriman, is_edited) 
			VALUES (:id_message, :id_chat, :id_pengirim, :msg, :status, :waktu_pengiriman, :is_edited)
		";

        $statement = $this->connect->prepare($query);

        $statement->bindParam(':id_message', $this->message_id);

        $statement->bindParam(':id_chat', $this->chat_id);

        $statement->bindParam(':id_pengirim', $this->id_pengirim);

        $statement->bindParam(':msg', $this->message);

        $statement->bindParam(':status', $this->status);

        $statement->bindParam(':waktu_pengiriman', $this->created_on);

        $statement->bindParam(':is_edited', $this->is_edited);

        $statement->execute();
    }

    function save_port($port)
    {
        $query = "
		INSERT INTO chats 
			(port) 
			VALUES ($port)
		";
    }

    function get_all_chat_data()
    {
        $query = "
		SELECT * FROM messages
		";
//        $query = "
//		SELECT messages.*, note.* FROM `messages` LEFT JOIN note ON messages.id_note = note.id_note
//		";

        $statement = $this->connect->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_id_last_chat()
    {
        $query = "
		SELECT * FROM messages WHERE id_message=(SELECT max(id_message) FROM messages)
		";

        $statement = $this->connect->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
	
?>