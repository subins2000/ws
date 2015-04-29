<?php
require_once __DIR__ . "/config.php";

file_put_contents(__DIR__ . "/status.txt", "1\n");
$startNow = 1;
include_once "$docRoot/server.php";
?>
