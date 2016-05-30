<?php
require_once __DIR__ . "/config.php";

$host = getenv("OPENSHIFT_PHP_IP") ?:"192.168.1.2";
$port = getenv("OPENSHIFT_PHP_PORT") ?:"8000";

$DS = new Fr\DiffSocket(array(
  "server" => array(
    "host" => $host,
    "port" => $port
  ),
  "services" => array(
    "text-chat" => "$docRoot/services/TextChat.php",
    "voice-chat" => "$docRoot/services/VoiceChat.php",
    "advanced-chat" => "$docRoot/services/AdvancedChat.php",
    "pi" => "$docRoot/services/Pi.php",
    "chess" => "$docRoot/services/Chess.php"
  )
));
$DS->run();
?>
