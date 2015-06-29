<?php
require_once __DIR__ . "/config.php";
  
/**
 * Kill existing WS servers
 */
exec("kill $(ps aux | grep 'bg.php' | awk '{print $2}')");
exec("kill $(ps aux | grep 'cron.php' | awk '{print $2}')");
file_put_contents(__DIR__ . "/active.txt", "0\n"); // No Active Connections as server was killed

sleep(3);
/**
 * The WebSocket server is not started. So we, start it
 */
exec("nohup php -q '$docRoot/bg.php' > /dev/null 2>&1 &");
exec("nohup php -q '$docRoot/cron.php' > /dev/null 2>&1 &");
?>
<!DOCTYPE html>
<html>
 	<head></head>
 	<body>
		<h1>Done and Done</h1>
    <a href="http://subinsb.com">subinsb.com</a>
 	</body>
</html>
<?php
/**
 * Kill Apache
 */
exec("kill $(ps aux | grep 'httpd' | awk '{print $2}')");
?>
