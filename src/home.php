<?php
  $user = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>

<?php require_once('templates/tpl.' . basename(__FILE__)) ?>
