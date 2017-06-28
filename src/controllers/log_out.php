<?php require_once(SRC_DIR . '/routing/router.php') ?>

<?php
  if (isset($_SESSION['student_id'])) {
    unset($_SESSION['student_id']);

    $router = new Router;
    $router->redirect_to('/log_in');
  }
?>
