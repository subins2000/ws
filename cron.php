<?php
if (file_get_contents(__DIR__ . "/active.txt") == "0\n") {
  exec("php " . __DIR__ . "/index.php");
}
