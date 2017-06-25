<?php require_once(SRC_DIR . '/routing/router.php') ?>

<?php
  if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);

    $router = new Router;
    $router->redirect_to('/log_in');
  }
?>
