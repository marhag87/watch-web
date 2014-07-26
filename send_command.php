<?php
if (empty($_POST["file"])) {
  echo "Empty filename";
} else {
  $command = '/usr/bin/ssh martin@pluto "/usr/local/bin/playontv \'' . $_POST["file"] . '\'"';
  exec($command);
  echo "Sent command: " . $command;
}
?>
