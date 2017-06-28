<?php
  echo 'Hey<br>';

  require_once('../config/config.php');
  echo 'Got config<br>';

  require_once(SRC_DIR . '/routing/router.php');
  echo 'Got router<br>';

?>
