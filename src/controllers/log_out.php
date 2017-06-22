<?php require_once(SRC_DIR . '/routing/router.php') ?>

<?php
  if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);

    $router = new Router;
    $router->redirect_to('/log_in');
  }
?>
