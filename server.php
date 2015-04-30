<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

function shutdown(){
	global $docRoot;
	file_put_contents("$docRoot/status.txt", "0\n");
	require_once "$docRoot/index.php";
}
if(php_sapi_name() != "cli"){
  register_shutdown_function('shutdown');
}

if(isset($startNow)){
	$ip = getenv("OPENSHIFT_PHP_IP") ?:"127.0.0.1";
	require_once "$docRoot/vendor/autoload.php";
	require_once "$docRoot/class.base.php";
  
	$server = IoServer::factory(
		new HttpServer(
      new WsServer(
				new BaseServer()
			)
		),
		8000,
		$ip
	);
	$server->run();
}
?>
