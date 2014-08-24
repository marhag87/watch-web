<?php
if (empty($_POST["file"])) {
  echo "Empty filename";
} else {
  $command = 'sudo -u martin /usr/local/bin/playontv \'' . $_POST["file"] . '\'';
  exec($command);
  echo "Sent command: " . $command;
}
?>
