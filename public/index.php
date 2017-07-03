<?php
  require_once('../config/config.php');
  require_once(SRC_DIR . '/routing/router.php');

  session_start();

  $url = $_GET['url'] ?? '';

  $router = new Router;

  $router->set_current_url($url);
  $router->get_from_current_url();
?>
