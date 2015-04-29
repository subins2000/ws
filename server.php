<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

function shutdown(){
	global $docRoot;
	file_put_contents("$docRoot/status.txt", "0");
	//require_once "$docRoot/index.php";
}
register_shutdown_function('shutdown');

if(isset($startNow)){
	$ip = getenv("OPENSHIFT_PHP_IP");
	require_once "$docRoot/vendor/autoload.php";
	require_once "$docRoot/class.base.php";
  
	$server = IoServer::factory(
		new HttpServer(
      new WsServer(
				new BaseServer()
			)
		),
		8082,
		$ip
	);
	$server->run();
}
?>