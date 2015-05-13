<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class AdvancedChatServer implements MessageComponentInterface {
	protected $clients;
	private $dbh;
	private $users = array();
	
	public function __construct() {
    global $dbh, $docRoot;
    $this->clients = array();
    $this->dbh = $dbh;
    $this->root = $docRoot;
  }
	
	public function onOpen(ConnectionInterface $conn) {
    $this->clients[$conn->resourceId] = $conn;
		$this->checkOnliners($conn);
		echo "New connection! ({$conn->resourceId})\n";
	}

	public function onMessage(ConnectionInterface $conn, $data) {
		$id	= $conn->resourceId;
		$data = json_decode($data, true);
    
		if(isset($data['data']) && count($data['data']) != 0){
			$type = $data['type'];
			$user = isset($this->users[$id]) ? $this->users[$id] : false;
      
			if($type == "register"){
				$name = htmlspecialchars($data['data']['name']);
        if(array_search($name, $this->users) === false){
				  $this->users[$id] = $name;
          $this->send($conn, "register", "success");
          $this->checkOnliners($conn);
        }else{
          $this->send($conn, "register", "taken");
        }
			}elseif($type == "send" && isset($data['data']['type']) && $user !== false){
				if($data['data']['type'] == "text"){
          $msg = htmlspecialchars($data['data']['msg']);
				  $sql = $this->dbh->prepare("INSERT INTO `wsMessages` (`name`, `msg`, `posted`) VALUES(?, ?, NOW())");
				  $sql->execute(array($user, $msg));
          $return = array(
          
          );
        }elseif($data['data']['type'] == "audio"){
        
        }
        
        foreach($this->clients as $client){
          $this->send($client, "msg", $return);
        }
			}elseif($type == "onliners"){
        $this->checkOnliners($conn);
      }
		}
	}

	public function onClose(ConnectionInterface $conn) {
		if(isset($this->users[$conn->resourceId])){
			unset($this->users[$conn->resourceId]);
		}
    $this->checkOnliners($conn);
		unset($this->clients[$conn->resourceId]);
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		if(isset($this->users[$conn->resourceId])){
			unset($this->users[$conn->resourceId]);
		}
    $conn->close();
    $this->checkOnliners();
	}
	
	/* My custom functions */
	public function fetchMessages(){
		$sql = $this->dbh->query("SELECT * FROM `wsMessages`");
		$msgs = $sql->fetchAll();
		return $msgs;
	}
	
	public function checkOnliners(ConnectionInterface $conn){
		date_default_timezone_set("UTC");
		
		/**
     * Send online users to everyone
     */
		$data = $this->users;
		foreach($this->clients as $id => $client) {
      $this->send($client, "onliners", $data);
		}
	}
	
	public function send(ConnectionInterface $client, $type, $data){
		$send = array(
			"type" => $type,
			"data" => $data
		);
		$send = json_encode($send, true);
		$client->send($send);
	}
}
?>
