<?php require_once('config.php') ?>

<?php
  try {
    $handler = new PDO(DB_DRIVER, DB_USERNAME, DB_PASSWORD);
    $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo $e;
    exit;
  }
?>
