<?php require_once('../config/config.php') ?>
<?php require_once(SRC_DIR . '/routing/router.php') ?>

<?php
  $url = isset($_GET['url']) ? $_GET['url'] : '';
  $router = new Router($url);

  $router->get_from_url();
?>
