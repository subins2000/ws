<?php
require_once __DIR__ . "/config.php";

$status = file_get_contents(__DIR__ . "/status.txt");
var_dump($status == "0\n");
if($status == "0\n"){
  /**
   * Kill Apache
   */
  exec("kill $(ps aux | grep 'httpd' | awk '{print $2}')");
  
  /**
   * The WebSocket server is not started. So we, start it
   */
	exec("nohup php -q '$docRoot/bg.php' > /dev/null 2>&1 &", $output);
}
?>
<!DOCTYPE html>
<html>
 	<head></head>
 	<body>
		<h1>Done and Done</h1>
    <a href="http://subinsb.com">subinsb.com</a>
 	</body>
</html>
