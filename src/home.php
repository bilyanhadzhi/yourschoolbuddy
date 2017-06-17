<?php
  $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
  $title = 'Tests';
?>

<?php require_once('templates/tpl.' . basename(__FILE__)) ?>
