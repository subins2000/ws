<?php
$endTime = time() + 100;
while (true) {
  if (time() >= $endTime && file_get_contents(__DIR__ . "/active.txt") == "0\n") {
    exec("php " . __DIR__ . "/index.php");
  }
  sleep(30);
}
